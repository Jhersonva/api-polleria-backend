<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DishRepositoryInterface;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Collection;

class DishRepository implements DishRepositoryInterface
{

    public function all() : Collection
    {
        return Dish::all();
    }

    public function find($id)
    {
        return Dish::findOrFail($id);
    }

    public function create($data)
    {
        return Dish::create($data);
    }

    public function update($data, $id)
    {
        $Dish = Dish::findOrFail($id);
        $Dish->update($data);
        return $Dish;
    }

    public function delete($id)
    {
        $Dish = Dish::findOrFail($id);
        return $Dish->delete();
    }
}
