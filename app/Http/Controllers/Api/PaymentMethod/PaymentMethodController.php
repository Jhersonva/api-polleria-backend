<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Services\PaymentMethodService;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{

    protected $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = $this->paymentMethodService->getAllPaymentMethods();
        return PaymentMethodResource::collection($paymentMethods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $paymentMethod = $this->paymentMethodService->createPaymentMethod($request->validated());
        return (new PaymentMethodResource($paymentMethod))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentMethod = $this->paymentMethodService->getById($id);
        return new PaymentMethodResource($paymentMethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        $paymentMethod = $this->paymentMethodService->updatePaymentMethod($request->validated(), $id);
        return new PaymentMethodResource($paymentMethod);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->paymentMethodService->deletePaymentMethod($id);
        return response()->json(['message' => 'Payment method deleted successfully'], 200);
    }
}
