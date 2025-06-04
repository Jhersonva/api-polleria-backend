<?php

namespace App\Services;

use App\Repositories\Interfaces\PaymentMethodRepositoryInterface;

class PaymentMethodService
{
    protected $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function getAllPaymentMethods()
    {
        return $this->paymentMethodRepository->all();
    }

    public function getById($id)
    {
        return $this->paymentMethodRepository->find($id);
    }

    public function createPaymentMethod($data)
    {
        return $this->paymentMethodRepository->create($data);
    }

    public function updatePaymentMethod($data, $id)
    {
        return $this->paymentMethodRepository->update($data, $id);
    }

    public function deletePaymentMethod($id)
    {
        return $this->paymentMethodRepository->delete($id);
    }
}
