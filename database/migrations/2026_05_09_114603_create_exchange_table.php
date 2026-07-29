<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange', function (Blueprint $table) {
            $table->string('exc_code', 15)->primary();
            $table->string('product1', 10);
            $table->string('product2', 10);
            $table->decimal('rate', 10, 2);
            $table->string('fee_type', 10);
            $table->decimal('fee', 10, 2);
            $table->decimal('min', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange');
    }
};