<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blockchain', function (Blueprint $table) {
            $table->string('blockchain_code', 20)->primary();
            $table->string('product_name', 10);
            $table->string('blockchain', 15);
            $table->decimal('blockchain_fee', 10, 2);
            $table->string('blockchain_img', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blockchain');
    }
};