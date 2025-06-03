<?php

namespace App\Http\Controllers\Api\Drink;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drink\StoreDrinkRequest;
use App\Http\Requests\Drink\UpdateDrinkRequest;
use App\Http\Resources\DrinkResource;
use App\Services\DrinkService;
use Illuminate\Http\Request;

class DrinkController extends Controller
{

    protected $service;

    public function __construct(DrinkService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $drinks = $this->service->getAllDrinks();
        return DrinkResource::collection($drinks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDrinkRequest $request)
    {
        $drink = $this->service->createDrink($request->validated());
        return (new DrinkResource($drink))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $drink = $this->service->getById($id);
        return new DrinkResource($drink);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDrinkRequest $request, $id)
    {
        $drink = $this->service->updateDrink($request->validated(), $id);
        return new DrinkResource($drink);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->deleteDrink($id);
        return response()->json(['message' => 'Drink deleted successfully'], 204);
    }
}
