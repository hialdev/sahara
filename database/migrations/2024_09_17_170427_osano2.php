<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Osano2 extends Migration
{
    public function connection()
    {
        return "osano"; // Menggunakan koneksi 'osano'
    }

    public function up()
    {
        Schema::connection($this->connection())->create('quotations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no');
            $table->date('date');
            $table->uuid('client_id');
            $table->string('for');
            $table->text('message');
            $table->text('keterangan');
            $table->json('products');
            $table->enum('status', [0, 1, 2])->default(0); // Status : 0 -> offering, 1 -> purchased, 3 -> canceled 
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::connection($this->connection())->create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no');
            $table->text('po_number');
            $table->uuid('client_id');
            $table->uuid('quotation_id');
            $table->string('po_file');
            $table->json('products');
            $table->enum('status', [0, 1, 2, 3])->default(0); // Status : 0 -> waiting, 1 -> delivered, 2 -> waiting delivery, 3 -> finished 
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
        });

        Schema::connection($this->connection())->create('process_purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_id');
            $table->json('products');
            $table->uuid('principle_id');
            $table->boolean('is_logistic_in_sahara')->default(1);
            $table->uuid('logistic_id')->nullable();
            $table->text('spk_file')->nullable();
            $table->text('surjal_file')->nullable();
            $table->boolean('is_finished')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('principle_id')->references('id')->on('principles')->onDelete('cascade');
            $table->foreign('logistic_id')->references('id')->on('logistics')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection($this->connection())->dropIfExists('quotations');
        Schema::connection($this->connection())->dropIfExists('purchase_orders');
        Schema::connection($this->connection())->dropIfExists('process_purchase_orders');
    }
}
