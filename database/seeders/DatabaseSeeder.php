<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Management\CategoriaManagement;
use App\Management\ProdottoManagement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(CategoriaManagement $categoriaManagement, ProdottoManagement $prodottoManagemt): void
    {
        $categoriaManagement->unsignedCategory();
        $categoriaManagement->loadCategory();
        $prodottoManagemt->loadProducts();
    }
}
