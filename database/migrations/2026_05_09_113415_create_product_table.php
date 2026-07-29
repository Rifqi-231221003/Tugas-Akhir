<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->string('product_code', 5)->primary();
            $table->string('product_name', 10);
            $table->string('category', 10);
            $table->string('status', 10);
            $table->string('img', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};