<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->string('nama_pelanggan');
            $table->string('nama_barang');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->decimal('total_harga', 15, 2);
            $table->enum('tipe', ['faktur', 'surat jalan', 'service']);
            $table->foreignId('id_barang')->constrained('produk')->onDelete('cascade');  
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
