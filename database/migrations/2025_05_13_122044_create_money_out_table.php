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
        Schema::create('money_out', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan', 50);
            $table->integer('jumlah');
            $table->date('tanggal');

            $table->unsignedBigInteger('idFinance');
            $table->foreign('idFinance')->references('idFinance')->on('finance')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_out');
    }
};
