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
        Schema::create('reports', function (Blueprint $table) {
            $table->id('idLaporan');
            


            $table->unsignedBigInteger('idSale')->nullable();
            $table->foreign('idSale')->references('idSale')->on('sales')->onDelete('set null');

            $table->unsignedBigInteger('idPurchasing')->nullable();
            $table->foreign('idPurchasing')->references('idPurchasing')->on('purchasings')->onDelete('set null');

            $table->unsignedBigInteger('idService')->nullable();
            $table->foreign('idService')->references('idService')->on('services')->onDelete('set null');

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
        Schema::dropIfExists('reports');
    }
};
