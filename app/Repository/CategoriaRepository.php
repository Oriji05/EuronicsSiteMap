<?php

namespace App\Repository;

use App\Api\CategorieRepositoryInterface;
use App\Api\Data\CategoriaInterface;
use App\Models\Category;

class CategoriaRepository implements CategorieRepositoryInterface
{

    public function save(CategoriaInterface $categoria)
    {
        $categoria->save();
    }

    public function delete(CategoriaInterface $categoria)
    {
        $categoria->delete();
    }

    public function getList()
    {
        return Category::all();
    }
}
