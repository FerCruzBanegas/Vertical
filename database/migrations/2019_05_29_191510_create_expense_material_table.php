<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_material', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expense_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->float('price', 9, 2);
            $table->softDeletes();
            // $table->timestamps();

            $table->foreign('expense_id')->references('id')->on('expenses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('material_id')->references('id')->on('materials')
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
        Schema::dropIfExists('expense_material');
    }
}
