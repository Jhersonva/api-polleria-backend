<?php

namespace App\Services;

use App\Http\Service\Image\DeleteImage;
use App\Http\Service\Image\SaveImage;
use App\Repositories\Interfaces\DrinkRepositoryInterface;

class DrinkService
{
    use SaveImage, DeleteImage;

    protected $drinkRepository;

    public function __construct(DrinkRepositoryInterface $drinkRepository)
    {
        $this->drinkRepository = $drinkRepository;
    }

    public function getAllDrinks()
    {
        return $this->drinkRepository->all()->load('image');
    }

    public function getById($id)
    {
        return $this->drinkRepository->find($id)->load('image');
    }

    public function createDrink($data)
    {
        $drink = $this->drinkRepository->create($data);
        if (isset($data['image']) && !empty($data['image'])) {
            $imagePath = $this->upload($data['image'], 'drinks');
            $drink->image()->create(['url' => $imagePath]);
            $drink->load('image');
        } else {
            $imagePath = 'default/categorias.jpg';
            $drink->image()->create(['url' => $imagePath]);
            $drink->load('image');
        }
        return $drink;
    }

    public function updateDrink($data, $id)
    {
        $drink = $this->drinkRepository->update($data, $id);

        // Validamos si llegó imagen nueva
        if (isset($data['image']) && !empty($data['image'])) {
            // 1. Eliminamos imagen previa (si existe)
            $existingImage = $drink->image()->latest()->first();
            if ($existingImage) {
                // Verificar que la imagen no esté en la carpeta default
                if (!str_starts_with($existingImage->url, 'default/')) {
                    $this->delete($existingImage->url); // borrar archivo del disco
                }
            $existingImage->delete(); // borrar registro en DB siempre
            }

            // 2. Subimos nueva imagen y la asociamos
            $newImagePath = $this->upload($data['image'], 'drinks');
            $drink->image()->create(['url' => $newImagePath]);
        }
        $drink->load('image');
        return $drink;
    }

    public function deleteDrink($id)
    {
        $drink = $this->drinkRepository->find($id);
        if ($drink->image) {
            // Solo eliminar el archivo físico si no está en la carpeta default
            if (!str_starts_with($drink->image->url, 'default/')) {
                $this->delete($drink->image->url);
            }
            $drink->image->delete(); // Eliminar registro de DB siempre
        }

        return $this->drinkRepository->delete($id);
    }
}
