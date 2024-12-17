<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcessProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function connection()
    {
        return "osano"; // Menggunakan koneksi 'osano'
    }

    public function up()
    {
        Schema::connection($this->connection())->create('process_purchase_order_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('process_id');
            $table->uuid('product_id');
            $table->integer('qty')->nullable();
            $table->timestamps();

            $table->foreign('process_id')->references('id')->on('process_purchase_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection())->dropIfExists('process_purchase_order_products');
    }
}
