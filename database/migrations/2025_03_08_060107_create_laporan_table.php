<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->nullable()->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('id_kategori')->nullable()->constrained('kategori')->onDelete('cascade');
            $table->foreignId('id_iventory')->nullable()->constrained('inventory')->onDelete('cascade');
            $table->foreignId('id_pembelian')->nullable()->constrained('pembelian')->onDelete('cascade');
            $table->foreignId('id_service')->nullable()->constrained('service')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('nama_barang_jasa'); // Perbaikan nama kolom
            $table->integer('jumlah')->nullable();
            $table->decimal('modal', 15, 2);
            $table->decimal('laba', 15, 2);
            $table->decimal('total_keuntungan', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};
