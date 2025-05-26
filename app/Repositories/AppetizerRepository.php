<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AppetizerRepositoryInterface;
use App\Models\Appetizer;
use Illuminate\Database\Eloquent\Collection;

class AppetizerRepository implements AppetizerRepositoryInterface
{

    public function all() : Collection
    {
        return Appetizer::all();
    }

    public function find($id)
    {
        return Appetizer::findOrFail($id);
    }

    public function create($data)
    {
        return Appetizer::create($data);
    }

    public function update($data, $id)
    {
        $appetizer = Appetizer::findOrFail($id);
        $appetizer->update($data);
        return $appetizer;
    }

    public function delete($id)
    {
        $appetizer = Appetizer::findOrFail($id);
        return $appetizer->delete();
    }
}
