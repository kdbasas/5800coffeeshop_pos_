<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypesTable extends Migration
{
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id('type_id');
            $table->string('type_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_types');
    }
}
