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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('idSale');
            $table->integer('nomorFaktur');
            $table->integer('jumlah');
            $table->integer('hargaTransaksi')->nullable();
            $table->integer('totalHarga');
            $table->integer('keuntungan');
            $table->date('tanggal');

            

            $table->unsignedBigInteger('idProduct');
            $table->foreign('idProduct')->references('idProduct')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('idFinance')->nullable();
            $table->foreign('idFinance')->references('idFinance')->on('finance')->onDelete('set null');

            $table->unsignedBigInteger('idCustomer')->nullable();
            $table->foreign('idCustomer')->references('idCustomer')->on('customers')->onDelete('set null');

            $table->unsignedBigInteger('idEmployee')->nullable();
            $table->foreign('idEmployee')->references('idEmployee')->on('employess')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
