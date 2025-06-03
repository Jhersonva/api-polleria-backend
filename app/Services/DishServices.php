<?php

namespace App\Services;

use App\Http\Service\Image\DeleteImage;
use App\Http\Service\Image\SaveImage;
use App\Repositories\Interfaces\DishRepositoryInterface;

class DishServices{
    use SaveImage, DeleteImage;
    protected $dishRepository;

    public function __construct(DishRepositoryInterface $dishRepository)
    {
        $this->dishRepository = $dishRepository;
    }

    public function getAllDish()
    {
        return $this->dishRepository->all()->load('image');
    }

    public function getById($id)
    {
        return $this->dishRepository->find($id)->load('image');
    }

    public function createDish($data)
    {
        $dish = $this->dishRepository->create($data);
        if (isset($data['image']) && !empty($data['image'])){
            $imagePath = $this->upload($data['image'], 'dish');
            $dish->image()->create(['url' => $imagePath]);
            $dish->load('image');
        }
        else {
            $imagePath = 'default/logo.jpg';
            $dish->image()->create(['url' => $imagePath]);
            $dish->load('image');
        }
        return $dish;
    }

    public function updateDish($data, $id)
    {
        $dish = $this->dishRepository->update($data, $id);

        // Validamos si llegó imagen nueva
        if (isset($data['image']) && !empty($data['image'])) {
            // 1. Eliminamos imagen previa (si existe)
            $existingImage = $dish->image()->latest()->first();
            if ($existingImage) {
               // Verificar que la imagen no esté en la carpeta default
                if (!str_starts_with($existingImage->url, 'default/')) {
                    $this->delete($existingImage->url); // borrar archivo del disco
                }
                $existingImage->delete(); // borrar registro en DB siempre
            }

            // 2. Subimos nueva imagen y la asociamos
            $newImagePath = $this->upload($data['image'], 'dish');
            $dish->image()->create(['url' => $newImagePath]);
        }

        // 3. Cargamos la relación para devolver en la respuesta
        $dish->load('image');

        return $dish;
    }

    public function deleteDish($id)
    {
        $dish = $this->dishRepository->find($id);
        if ($dish->image) {
           // Solo eliminar el archivo físico si no está en la carpeta default
            if (!str_starts_with($dish->image->url, 'default/')) {
                $this->delete($dish->image->url);
            }
            $dish->image->delete(); // Eliminar registro de DB siempre
        }
        return $this->dishRepository->delete($id);
    }
}
