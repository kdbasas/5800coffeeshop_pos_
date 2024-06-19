<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
{
    Schema::create('carts', function (Blueprint $table) {
        $table->id('cart_id');
        $table->unsignedBigInteger('employee_id')->nullable(); // Allow null values
        $table->unsignedBigInteger('product_id');
        $table->integer('quantity')->default(1);
        $table->timestamps();

        // Foreign key constraint
        $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
        $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
