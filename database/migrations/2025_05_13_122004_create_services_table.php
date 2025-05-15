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
        Schema::create('services', function (Blueprint $table) {
            $table->id('idService');
            $table->integer('nomorFaktur');
            $table->string('kerusakan', 50);
            $table->string('jenisPerangkat', 50);
            $table->boolean('status')->default(false);
            $table->integer('totalBiaya');
            $table->integer('keuntungan');
            $table->date('tglMasuk');
            $table->date('tglSelesai');

            
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
        Schema::dropIfExists('services');
    }
};
