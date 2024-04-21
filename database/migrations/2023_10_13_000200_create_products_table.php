<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products',
            function (Blueprint $table) {
                $table->id();
                $table->string('titolo');
                $table->string('prezzo');
                $table->string('url');
                $table->timestamp('price_updated_at')->default(now()->addSecond(1));
                $table->unsignedBigInteger('categoria_id')->default(1);
                $table->foreign('categoria_id')->references('id')->on('categories');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
