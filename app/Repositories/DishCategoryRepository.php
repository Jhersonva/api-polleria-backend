<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DishCategoryRepositoryInterface;
use App\Models\DishCategory;
use Illuminate\Database\Eloquent\Collection;

class DishCategoryRepository implements DishCategoryRepositoryInterface
{

    public function all() : Collection
    {
        return DishCategory::all();
    }

    public function find($id)
    {
        return DishCategory::findOrFail($id);
    }

    public function create($data)
    {
        return DishCategory::create($data);
    }

    public function update($data, $id)
    {
        $DishCategory = DishCategory::findOrFail($id);
        $DishCategory->update($data);
        return $DishCategory;
    }

    public function delete($id)
    {
        $DishCategory = DishCategory::findOrFail($id);
        return $DishCategory->delete();
    }
}
