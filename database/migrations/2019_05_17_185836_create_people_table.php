<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('surnames', 128)->nullable();
            $table->string('phone', 32);
            $table->string('address', 128)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Full Text Index
        DB::statement('ALTER TABLE people ADD FULLTEXT idx_full_text (name, surnames)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
