<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeNameToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type_name')->after('type_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type_name');
        });
    }
}
