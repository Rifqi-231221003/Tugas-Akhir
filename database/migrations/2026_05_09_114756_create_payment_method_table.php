<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_method', function (Blueprint $table) {
            $table->string('pm_code', 25)->primary();
            $table->string('product_name', 10);
            $table->string('pm_blockchain', 15)->nullable();
            $table->string('type', 10);
            $table->string('destination', 70);
            $table->string('name', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_method');
    }
};