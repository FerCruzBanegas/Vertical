<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_box', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('box_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->float('income', 9, 2);
            $table->float('expense', 9, 2);
            $table->float('cash', 9, 2);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('box_id')->references('id')->on('box')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('account_id')->references('id')->on('account')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_box');
    }
}
