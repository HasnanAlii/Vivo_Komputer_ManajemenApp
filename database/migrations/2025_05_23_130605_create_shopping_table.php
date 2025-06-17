<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingTable extends Migration
{
    public function up()
    {
        Schema::create('shopping', function (Blueprint $table) {
            $table->id();
            $table->string('sumber');
            $table->integer('jumlah');
            $table->boolean('statuspembayaran')->default(false);
            $table->integer('totalbelanja');
            $table->integer('hutang')->nullable();
            // $table->integer('bayar')->nullable();


            $table->unsignedBigInteger('idFinance')->nullable();
            $table->foreign('idFinance')->references('idFinance')->on('finance')->onDelete('set null');

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping');
    }
}
