<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository implements SaleRepositoryInterface
{
    public function all(): Collection
    {
        return Sale::with(['saleDetails', 'salePayments.paymentMethod'])->get();
    }

    public function find($id)
    {
        return Sale::findOrFail($id);
    }

    public function findWithDetails($id)
    {
        return Sale::with([
            'saleDetails.dish',
            'saleDetails.drink',
            'saleDetails.appetizer',
            'salePayments.paymentMethod'
        ])->findOrFail($id);
    }

    public function create($data)
    {
        return Sale::create($data);
    }

    public function update($data, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->update($data);
        return $sale;
    }
}
