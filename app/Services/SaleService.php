<?php

namespace App\Services;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Models\SaleDetail;
use App\Models\SalePayment;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getAllSales()
    {
        return $this->saleRepository->all();
    }

    public function getSaleById($id)
    {
        return $this->saleRepository->findWithDetails($id);
    }

    /**
     * Crear una venta completa (siempre completada)
     * Para pollerías - el pago es inmediato y completo
     */
    public function createCompletedSale(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Calcular total desde detalles
            $totalAmount = $this->calculateTotalFromDetails($data['details']);

            // 2. Validar que los pagos sumen exactamente el total
            $totalPayments = array_sum(array_column($data['payments'], 'amount'));

            if (abs($totalPayments - $totalAmount) > 0.01) {
                throw new \Exception("Los pagos (S/. {$totalPayments}) no coinciden con el total (S/. {$totalAmount})");
            }

            // 3. Crear la venta (siempre completed)
            $saleData = [
                'sale_date' => now(),
                'customer_name' => $data['customer_name'] ?? null,
                'total_amount' => $totalAmount,
                'paid_amount' => $totalPayments,
                'status' => 'completed' // Siempre completed en pollería
            ];

            $sale = $this->saleRepository->create($saleData);

            // 4. Crear detalles
            $this->createSaleDetails($sale->id, $data['details']);

            // 5. Crear pagos
            $this->createSalePayments($sale->id, $data['payments']);

            return $this->saleRepository->findWithDetails($sale->id);
        });
    }

    /**
     * Cancelar una venta cambiando su estado a "cancelled"
     */
    public function cancelSale($id)
    {
        $sale = $this->saleRepository->find($id);

        if (!$sale) {
            throw new \Exception("Venta no encontrada");
        }

        if ($sale->status === 'cancelled') {
            throw new \Exception("La venta ya está cancelada");
        }

        $sale->status = 'cancelled';
        $sale->save();

        return $sale;
    }

    private function calculateTotalFromDetails(array $details): float
    {
        return array_reduce($details, function ($total, $detail) {
            return $total + ($detail['quantity'] * $detail['unit_price']);
        }, 0);
    }

    private function createSaleDetails($saleId, array $details)
    {
        foreach ($details as $detail) {
            $detailData = [
                'sale_id' => $saleId,
                'quantity' => $detail['quantity'],
                'unit_price' => $detail['unit_price'],
                'subtotal' => $detail['quantity'] * $detail['unit_price'],
                'notes' => $detail['notes'] ?? null
            ];

            // Agregar el producto específico
            if (isset($detail['dish_id'])) {
                $detailData['dish_id'] = $detail['dish_id'];
            } elseif (isset($detail['drink_id'])) {
                $detailData['drink_id'] = $detail['drink_id'];
            } elseif (isset($detail['appetizer_id'])) {
                $detailData['appetizer_id'] = $detail['appetizer_id'];
            }

            SaleDetail::create($detailData);
        }
    }

    private function createSalePayments($saleId, array $payments)
    {
        foreach ($payments as $payment) {
            SalePayment::create([
                'sale_id' => $saleId,
                'payment_method_id' => $payment['payment_method_id'],
                'amount' => $payment['amount'],
                'notes' => $payment['notes'] ?? null
            ]);
        }
    }

    public function updateSale($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            // 1. Buscar la venta existente
            $sale = $this->saleRepository->find($id);

            if (!$sale) {
                throw new \Exception("Venta no encontrada");
            }

            if ($sale->status === 'cancelled') {
                throw new \Exception("No se puede actualizar una venta cancelada");
            }

            // 2. Si se proporcionan nuevos detalles, recalcular todo
            if (isset($data['details'])) {
                $totalAmount = $this->calculateTotalFromDetails($data['details']);

                // 3. Si se proporcionan nuevos pagos, validar que sumen el total
                if (isset($data['payments'])) {
                    $totalPayments = array_sum(array_column($data['payments'], 'amount'));

                    if (abs($totalPayments - $totalAmount) > 0.01) {
                        throw new \Exception("Los pagos (S/. {$totalPayments}) no coinciden con el total (S/. {$totalAmount})");
                    }
                } else {
                    // Si no se proporcionan pagos, mantener los existentes pero validar
                    $currentPayments = $sale->salePayments->sum('amount');
                    if (abs($currentPayments - $totalAmount) > 0.01) {
                        throw new \Exception("Los pagos actuales (S/. {$currentPayments}) no coinciden con el nuevo total (S/. {$totalAmount})");
                    }
                }

                // 4. Actualizar datos de la venta
                $saleData = [
                    'total_amount' => $totalAmount,
                    'paid_amount' => isset($data['payments']) ? $totalPayments : $currentPayments,
                ];

                if (isset($data['customer_name'])) {
                    $saleData['customer_name'] = $data['customer_name'];
                }

                $sale = $this->saleRepository->update($saleData, $id);

                // 5. Actualizar detalles (eliminar existentes y crear nuevos)
                SaleDetail::where('sale_id', $id)->delete();
                $this->createSaleDetails($id, $data['details']);

                // 6. Actualizar pagos si se proporcionan
                if (isset($data['payments'])) {
                    SalePayment::where('sale_id', $id)->delete();
                    $this->createSalePayments($id, $data['payments']);
                }
            } else {
                // Solo actualizar datos básicos sin tocar detalles ni pagos
                $saleData = [];
                if (isset($data['customer_name'])) {
                    $saleData['customer_name'] = $data['customer_name'];
                }

                if (!empty($saleData)) {
                    $sale = $this->saleRepository->update($saleData, $id);
                }
            }

            return $this->saleRepository->findWithDetails($id);
        });
    }
}
