<?php

namespace App\Api;

use App\Api\Data\ProdottoInterface;

interface ProdottiRepositoryInterface
{
    public function save(ProdottoInterface $prodotto);
    public function delete(ProdottoInterface $prodotto);
    public function getList();
}
