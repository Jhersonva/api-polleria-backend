<?php

namespace App\Http\Controllers\Api\Dish;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dish\StoreDishRequest;
use App\Http\Requests\Dish\UpdateDishRequest;
use App\Http\Resources\DishResource;
use App\Services\DishServices;

class DishController extends Controller
{
    protected $service;

    public function __construct(DishServices $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dish = $this->service->getAllDish();
        return DishResource::collection($dish);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishRequest $request)
    {
        $dish = $this->service->createDish($request->validated());
        return (new DishResource($dish))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dish = $this->service->getById($id);
        return new DishResource($dish);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishRequest $request, $id)
    {
        $dish = $this->service->updateDish($request->validated(), $id);
        return new DishResource($dish);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->deleteDish($id);
        return response()->json([
            'message' => 'Dish deleted successfully'
        ], 200);
    }
}
