<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id('transaction_id'); // Specify 'transaction_id' as primary key
        $table->string('customer_name')->nullable();
        $table->double('paid_amount', 8, 2)->nullable();
        $table->double('balance', 8, 2)->nullable();
        $table->enum('payment_method', ['cash', 'debit_card', 'credit_card'])->default('cash');
        $table->unsignedBigInteger('user_id');
        $table->date('transac_date');
        $table->double('transac_amount', 8, 2);
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });

    Schema::create('product_transaction', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('transaction_id'); // Corrected to match 'transactions' table
        $table->integer('quantity');
        $table->timestamps();

        $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade'); // Corrected to match 'transactions' table primary key
    });
}

public function down()
{
    Schema::dropIfExists('product_transaction');
    Schema::dropIfExists('transactions');
}
}
