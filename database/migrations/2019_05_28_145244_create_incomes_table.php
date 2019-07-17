<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->enum('payment', ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia']);
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

        // Full Text Index
        DB::statement('ALTER TABLE incomes ADD INDEX idx_date (date)');
        DB::statement('ALTER TABLE incomes ADD FULLTEXT idx_full_title (title)');
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
