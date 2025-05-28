<?php

namespace App\Http\Controllers\Api\DishCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\DishCategory\StoreDishCategoryRequest;
use App\Http\Requests\DishCategory\UpdateDishCategoryRequest;
use App\Http\Resources\DishCategoryResource;
use App\Services\DishCategoryServices;

class DishCategoryController extends Controller
{
    protected $service;

    public function __construct(DishCategoryServices $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishCategories = $this->service->getAllDishCategories();
        return DishCategoryResource::collection($dishCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishCategoryRequest $request)
    {
        $dishCategory = $this->service->createDishCategory($request->validated());
        return (new DishCategoryResource($dishCategory))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dishCategory = $this->service->getById($id);
        return new DishCategoryResource($dishCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishCategoryRequest $request, $id)
    {
        $dishCategory = $this->service->updateDishCategory($request->validated(), $id);
        return new DishCategoryResource($dishCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->deleteDishCategory($id);
        return response()->json([
            'message' => 'Dish category deleted successfully'
        ], 200);
    }
}
