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
        Schema::create('finance', function (Blueprint $table) {
            $table->id('idFinance');
            $table->integer('danaMasuk');
            $table->integer('modal');
            $table->integer('totalDana');
            $table->date('tanggal');
            $table->integer('keuntungan');

            $table->unsignedBigInteger('idUser')->nullable();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('idSale')->nullable();
            $table->foreign('idSale')->references('idSale')->on('sales')->onDelete('set null');

            $table->unsignedBigInteger('idPurchasing')->nullable();
            $table->foreign('idPurchasing')->references('idPurchasing')->on('purchasings')->onDelete('set null');

            $table->unsignedBigInteger('idService')->nullable();
            $table->foreign('idService')->references('idService')->on('services')->onDelete('set null');

            $table->unsignedBigInteger('idProduct');
            $table->foreign('idProduct')->references('idProduct')->on('products')->onDelete('cascade');


            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance');
    }
};
