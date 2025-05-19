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
        Schema::create('purchasings', function (Blueprint $table) {
            $table->id('idPurchasing');
            $table->integer('nomorFaktur');
            $table->integer('jumlah');
            $table->integer('hargaBeli');
            $table->integer('hargaJual');
            $table->string('type', 50);
            $table->string('serialNumber', 50)->nullable();
            $table->string('spek', 50);
            $table->string('buktiTransaksi')->nullable();




            $table->date('tanggal');

            $table->unsignedBigInteger('idCustomer');
            $table->foreign('idCustomer')->references('idCustomer')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('idProduct');
            $table->foreign('idProduct')->references('idProduct')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('idFinance')->nullable();
             $table->foreign('idFinance')->references('idFinance')->on('finance')->onDelete('set null');

            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasings');
    }
};
