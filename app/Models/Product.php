<?php

namespace App\Models;

use App\Api\Data\ProdottoInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements ProdottoInterface
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }
}
