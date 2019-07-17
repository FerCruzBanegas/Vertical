<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateIncomeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->mediumText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Full Text Index
        DB::statement('ALTER TABLE income_types ADD FULLTEXT idx_full_text (name, description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_types');
    }
}
