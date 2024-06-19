<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->double('price', 8, 2); // Modify price column to match products table
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('price'); // Revert the change if necessary
        });
    }
}
