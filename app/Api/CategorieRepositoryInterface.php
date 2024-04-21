<?php

namespace App\Api;

use App\Api\Data\CategoriaInterface;

interface CategorieRepositoryInterface
{
    public function save(CategoriaInterface $categoria);
    public function delete(CategoriaInterface $categoria);
    public function getList();
}
