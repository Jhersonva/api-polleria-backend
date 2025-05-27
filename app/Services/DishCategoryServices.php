<?php

namespace App\Services;

use App\Repositories\Interfaces\DishCategoryRepositoryInterface;

class DishCategoryServices
{
    protected $dishCategoryRepository;

    public function __construct(DishCategoryRepositoryInterface $dishCategoryRepository)
    {
        $this->dishCategoryRepository = $dishCategoryRepository;
    }

    public function getAllDishCategories()
    {
        return $this->dishCategoryRepository->all();
    }

    public function getById($id)
    {
        return $this->dishCategoryRepository->find($id);
    }

    public function createDishCategory($data)
    {
        return $this->dishCategoryRepository->create($data);
    }

    public function updateDishCategory($data, $id)
    {
        return $this->dishCategoryRepository->update($data, $id);
    }

    public function deleteDishCategory($id)
    {
        return $this->dishCategoryRepository->delete($id);
    }
}
