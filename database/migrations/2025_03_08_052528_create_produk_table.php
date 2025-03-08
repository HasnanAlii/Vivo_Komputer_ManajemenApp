<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah')->nullable();
            $table->decimal('harga_awal', 15, 2)->nullable();
            $table->decimal('harga_jual', 15, 2);
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade');
            $table->string('garansi', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};
