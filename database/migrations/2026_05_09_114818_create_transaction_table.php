<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->string('trx_id', 25)->primary();
            $table->string('client_name', 50);
            $table->string('client_email', 255);
            $table->string('client_phonenumber', 20);
            $table->string('trx_status', 10);
            $table->datetime('trx_date');
            $table->string('product1', 10);
            $table->string('product2', 10);
            $table->string('blockchain1', 15)->nullable();
            $table->string('blockchain2', 15)->nullable();
            $table->decimal('product1_amount', 10, 2);
            $table->decimal('product2_amount', 10, 2);
            $table->decimal('fee', 10, 2);
            $table->string('product1_dest', 255);
            $table->string('product2_dest', 255);
            $table->string('product1_payment_proof', 255);
            $table->string('product2_payment_proof', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};