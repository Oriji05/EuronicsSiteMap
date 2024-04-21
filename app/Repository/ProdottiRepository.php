<?php

namespace App\Repository;

use App\Api\Data\ProdottoInterface;
use App\Api\ProdottiRepositoryInterface;
use App\Models\Product;

class ProdottiRepository implements ProdottiRepositoryInterface
{

    public function save(ProdottoInterface $prodotto)
    {
        $prodotto->save();
    }

    public function delete(ProdottoInterface $prodotto)
    {
        $prodotto->delete();
    }

    public function getList()
    {
        return Product::all();
    }
}
