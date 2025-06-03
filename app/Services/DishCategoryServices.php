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
        if (isset($data['image']) && !empty($data['image'])){
            $imagePath = $this->upload($data['image'], 'dish_categories');
            $dishCategory->image()->create(['url' => $imagePath]);
            $dishCategory->load('image');
        }
        else {
            $imagePath = 'default/categorias.jpg';
            $dishCategory->image()->create(['url' => $imagePath]);
            $dishCategory->load('image');
        }
        return $dishCategory;
    }

    public function updateDishCategory($data, $id)
    {
        $dishCategory = $this->dishCategoryRepository->update($data, $id);

        // Validamos si llegó imagen nueva
        if (isset($data['image']) && !empty($data['image'])) {
            // 1. Eliminamos imagen previa (si existe)
            $existingImage = $dishCategory->image()->latest()->first();
            if ($existingImage) {
                // Verificar que la imagen no esté en la carpeta default
                if (!str_starts_with($existingImage->url, 'default/')) {
                    $this->delete($existingImage->url); // borrar archivo del disco
                }
                $existingImage->delete(); // borrar registro en DB siempre
            }

            // 2. Subimos nueva imagen y la asociamos
            $newImagePath = $this->upload($data['image'], 'dish_categories');
            $dishCategory->image()->create(['url' => $newImagePath]);
        }

        // 3. Cargamos la relación para devolver en la respuesta
        $dishCategory->load('image');

        return $dishCategory;
    }

    public function deleteDishCategory($id)
    {
        $dishCategory = $this->dishCategoryRepository->find($id);
        if ($dishCategory->image) {
            if (!str_starts_with($dishCategory->image->url, 'default/')) {
                $this->delete($dishCategory->image->url);
            }
            $dishCategory->image->delete();
        }
        return $this->dishCategoryRepository->delete($id);
    }
}
