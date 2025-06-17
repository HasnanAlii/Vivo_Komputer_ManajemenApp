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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->integer('bayar')->nullable();
            $table->integer('sisaCicilan')->nullable();
            $table->date('tanggalBayar')->nullable();


    $table->unsignedBigInteger('idShopping')->nullable();
    $table->foreign('idShopping')->references('id')->on('shopping')->onDelete('set null');

    $table->unsignedBigInteger('idCustomer')->nullable();
    $table->foreign('idCustomer')->references('idCustomer')->on('customers')->onDelete('set null');
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
        Schema::dropIfExists('_pembayaran_');
    }
};
