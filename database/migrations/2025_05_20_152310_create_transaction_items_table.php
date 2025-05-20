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
        Schema::create('transaction_items', function (Blueprint $table) {
    $table->id('idTransactionItem');
    $table->unsignedBigInteger('idSale')->nullable();
    $table->foreign('idSale')->references('idSale')->on('sales')->onDelete('cascade');
    $table->unsignedBigInteger('idProduct');
    $table->foreign('idProduct')->references('idProduct')->on('products');
    // Salin data produk agar bisa diubah saat transaksi
    $table->string('namaBarang');
    $table->integer('hargaTransaksi'); // harga bisa markup/markdown saat transaksi
    $table->integer('jumlah');         // qty dibeli
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
