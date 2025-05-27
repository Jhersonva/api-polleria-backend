<?php

namespace App\Services;

use App\Http\Service\Image\DeleteImage;
use App\Http\Service\Image\SaveImage;
use App\Repositories\Interfaces\DishCategoryRepositoryInterface;

class DishCategoryServices
{
    use SaveImage, DeleteImage;
    protected $dishCategoryRepository;

    public function __construct(DishCategoryRepositoryInterface $dishCategoryRepository)
    {
        $this->dishCategoryRepository = $dishCategoryRepository;
    }

    public function getAllDishCategories()
    {
        return $this->dishCategoryRepository->all()->load('image');
    }

    public function getById($id)
    {
        return $this->dishCategoryRepository->find($id)->load('image');
    }

    public function createDishCategory($data)
    {
        $dishCategory = $this->dishCategoryRepository->create($data);

        if (isset($data['image']) && !empty($data['image'])) {
            $image = $this->saveImageBase64($data['image'], 'dish_categories');

            if ($image) { // Asegurar que no sea null
                $dishCategory->image()->create(['url' => $image]);
                $dishCategory->load('image'); // Recargar la relación para que no devuelva null
            }
        }

        return $dishCategory;
    }

    public function updateDishCategory($data, $id)
    {
        $dishCategory = $this->dishCategoryRepository->update($data, $id);

        if (isset($data['image']) && !empty($data['image'])) {
            $existingImage = $dishCategory->image()->latest()->first();
            $image = $this->saveImageBase64($data['image'], 'dish_categories');
            if ($existingImage) {
                $this->deleteImage($existingImage->url);
            }
            if ($dishCategory->image) {
                $dishCategory->image()->update(['url' => $image]);
            } else {
                $dishCategory->image()->create(['url' => $image]);
            }
            $dishCategory->load('image');
        }

        return $dishCategory;
    }

    public function deleteDishCategory($id)
    {
        $dishCategory = $this->dishCategoryRepository->find($id);
        if ($dishCategory->image) {
            $this->deleteImage($dishCategory->image->url);
            $dishCategory->image->delete();
        }
        return $this->dishCategoryRepository->delete($id);
    }
}
