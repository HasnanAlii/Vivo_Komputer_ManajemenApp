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
    Schema::table('services', function (Blueprint $table) {
        $table->dropForeign(['idProduct']);
        $table->dropColumn('idProduct');
        $table->string('idProduct')->nullable()->after('idCustomer');
    });
}

public function down(): void
{
    Schema::table('services', function (Blueprint $table) {
        $table->dropColumn('idProduct');
        $table->unsignedBigInteger('idProduct')->nullable();
        $table->foreign('idProduct')->references('idProduct')->on('products')->onDelete('cascade');
    });
}

};
