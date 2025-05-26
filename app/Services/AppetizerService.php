<?php

namespace App\Services;

use App\Repositories\Interfaces\AppetizerRepositoryInterface;

class AppetizerService
{
    protected $appetizerRepository;

    public function __construct(AppetizerRepositoryInterface $appetizerRepository)
    {
        $this->appetizerRepository = $appetizerRepository;
    }

    public function getAllAppetizers()
    {
        return $this->appetizerRepository->all();
    }

    public function getById($id)
    {
        return $this->appetizerRepository->find($id);
    }

    public function createAppetizer($data)
    {
        return $this->appetizerRepository->create($data);
    }

    public function updateAppetizer($data, $id)
    {
        return $this->appetizerRepository->update($data, $id);
    }

    public function deleteAppetizer($id)
    {
        return $this->appetizerRepository->delete($id);
    }
}
