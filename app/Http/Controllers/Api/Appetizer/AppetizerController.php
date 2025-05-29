<?php

namespace App\Http\Controllers\Api\Appetizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appetizer\StoreAppetizerRequest;
use App\Http\Requests\Appetizer\UpdateAppetizerRequest;
use App\Http\Resources\AppetizerResource;
use App\Services\AppetizerService;

class AppetizerController extends Controller
{

    protected $service;

    public function __construct(AppetizerService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appetizers = $this->service->getAllAppetizers();
        return AppetizerResource::collection($appetizers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppetizerRequest $request)
    {
        $appetizer = $this->service->createAppetizer($request->validated());
        return (new AppetizerResource($appetizer))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $appetizer = $this->service->getById($id);
        return new AppetizerResource($appetizer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppetizerRequest $request, $id)
    {
        $appetizer = $this->service->updateAppetizer($request->validated(), $id);
        return new AppetizerResource($appetizer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->deleteAppetizer($id);
        return response()->json([
            'message' => 'Appetizer deleted successfully'
        ], 200);
    }
}
