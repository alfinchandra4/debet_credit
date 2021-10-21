<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitCreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_credit', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('date_created');
            $table->foreignId('category_id')->constrained();
            $table->integer('amount');
            $table->char('debit_id')->nullable();
            $table->char('credit_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debit_credit');
    }
}
