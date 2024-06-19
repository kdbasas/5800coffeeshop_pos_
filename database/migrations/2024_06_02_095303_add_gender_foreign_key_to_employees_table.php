<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderForeignKeyToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('gender_id')->references('gender_id')->on('genders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
        });
    }
}