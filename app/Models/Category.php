<?php

namespace App\Models;

use App\Api\Data\CategoriaInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements CategoriaInterface
{
    use HasFactory;

    public function prodotti()
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }
}
