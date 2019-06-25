<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 60);
            $table->enum('unity', ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia']);
            $table->date('date');
            $table->mediumText('note')->nullable();
            $table->float('amount', 9, 2);
            $table->integer('income_type_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('income_type_id')->references('id')->on('income_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('project_id')->references('id')->on('projects')
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
        Schema::dropIfExists('incomes');
    }
}
