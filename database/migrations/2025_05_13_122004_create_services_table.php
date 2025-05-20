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
            $table->string('kerusakan', 50)->nullable();
            $table->string('jenisPerangkat', 50);
            $table->string('kondisi', 250)->nullable();
            $table->string('keterangan', 250)->nullable();
            $table->string('kelengkapan', 250)->nullable();
            $table->string('ciriCiri', 250)->nullable();
            $table->boolean('status')->default(false);
            $table->integer('biayaJasa')->nullable();
            $table->integer('totalHarga')->nullable();
            $table->integer('keuntungan')->nullable();
            $table->date('tglMasuk');
            $table->date('tglSelesai')->nullable();

            
            $table->unsignedBigInteger('idCustomer');
            $table->foreign('idCustomer')->references('idCustomer')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('idProduct')->nullable();
            $table->foreign('idProduct')->references('idProduct')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('idFinance')->nullable();
             $table->foreign('idFinance')->references('idFinance')->on('finance')->onDelete('cascade');


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
