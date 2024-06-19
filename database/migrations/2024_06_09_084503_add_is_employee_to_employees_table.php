<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsEmployeeToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->boolean('is_employee')->default(false)->after('suffix_name');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('is_employee');
        });
    }
}