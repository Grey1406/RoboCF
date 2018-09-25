<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CashFlows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sender');
            $table->integer('id_receiver');
            $table->string('status');
            $table->double('amount');
            $table->dateTime('create');
            $table->dateTime('changed')->nullable()->default(null);
            $table->dateTime('approved')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CashFlows');
    }
}
