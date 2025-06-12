<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use App\Services\SaleService;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Http\Resources\Sale\SaleResource;
use App\Http\Resources\Sale\SaleCollection;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * Obtener todas las ventas
     */
    public function index(): JsonResponse
    {
        $sales = $this->saleService->getAllSales();

        return new JsonResponse(
            new SaleCollection($sales)
        );
    }

    /**
     * Obtener una venta específica con detalles
     */
    public function show($id): JsonResponse
    {
        $sale = $this->saleService->getSaleById($id);

        return new JsonResponse([
            'success' => true,
            'data' => new SaleResource($sale)
        ]);
    }

    /**
     * Crear una nueva venta completa (con pago inmediato)
     *
     */
    public function store(StoreSaleRequest $request): JsonResponse
    {
        $sale = $this->saleService->createCompletedSale($request->validated());

        return new JsonResponse([
            'success' => true,
            'message' => 'Venta registrada exitosamente',
            'data' => new SaleResource($sale)
        ], 201);
    }

    /**
     * Actualizar una venta existente
     * Permite actualizar datos básicos, detalles y pagos
     */
    public function update(UpdateSaleRequest $request, $id): JsonResponse
    {
        $sale = $this->saleService->updateSale($id, $request->validated());

        return new JsonResponse([
            'success' => true,
            'message' => 'Venta actualizada exitosamente',
            'data' => new SaleResource($sale)
        ]);
    }

    /**
     * Cancelar una venta (cambiar estado a cancelled)
     */
    public function destroy($id): JsonResponse
    {
        $sale = $this->saleService->cancelSale($id);

        return new JsonResponse([
            'success' => true,
            'message' => 'Venta cancelada exitosamente',
            'data' => new SaleResource($sale)
        ]);
    }
}
