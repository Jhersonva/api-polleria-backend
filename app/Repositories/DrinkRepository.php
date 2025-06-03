<?php

namespace App\Repositories;

use App\Models\Drink;
use App\Repositories\Interfaces\DrinkRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DrinkRepository implements DrinkRepositoryInterface
{
    public function all() : Collection
    {
        return Drink::all();
    }

    public function find($id)
    {
        return Drink::findOrFail($id);
    }

    public function create(array $data)
    {
        return Drink::create($data);
    }

    public function update(array $data, $id)
    {
        $drink = Drink::findOrFail($id);
        $drink->update($data);
        return $drink;
    }

    public function delete($id)
    {
        $drink = Drink::findOrFail($id);
        return $drink->delete();
    }
}
