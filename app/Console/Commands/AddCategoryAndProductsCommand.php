<?php

namespace App\Console\Commands;

use App\Management\CategoriaManagement;
use App\Management\ProdottoManagement;
use Illuminate\Console\Command;

class AddCategoryAndProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-category-and-products-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CategoriaManagement $categoriaManagement, ProdottoManagement $prodottoManagemt)
    {
        $categoriaManagement->loadCategory();
        $prodottoManagemt->loadProducts();
    }
}
