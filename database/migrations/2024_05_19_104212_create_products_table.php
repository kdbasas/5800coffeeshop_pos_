<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_image')->nullable();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->double('price', 8, 2);
            $table->integer('quantity');
            $table->integer('alert_stock')->default(100);
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('type_id')->references('type_id')->on('product_types')->onDelete('set null')->name('products_type_id_foreign');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
