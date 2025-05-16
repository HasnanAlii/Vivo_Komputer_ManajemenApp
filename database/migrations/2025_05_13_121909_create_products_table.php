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
        Schema::create('products', function (Blueprint $table) {
            $table->id('idProduct');
            $table->string('namaBarang', 50);
            // $table->string('kategori', 20);
            // $table->integer('kodeBarang');
            $table->integer('jumlah');
            $table->integer('hargaBeli');
            $table->integer('hargaJual');
            
            $table->unsignedBigInteger('idCategory');
            $table->foreign('idCategory')->references('idCategory')->on('categories')->onDelete('cascade');
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
