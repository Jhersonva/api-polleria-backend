<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use App\Repositories\Interfaces\PaymentMethodRepositoryInterface;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    public function all()
    {
        return PaymentMethod::all();
    }

    public function find($id)
    {
        return PaymentMethod::findOrFail($id);
    }

    public function create(array $data)
    {
        return PaymentMethod::create($data);
    }

    public function update(array $data, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update($data);
        return $paymentMethod;
    }

    public function delete($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return $paymentMethod->delete();
    }
}
