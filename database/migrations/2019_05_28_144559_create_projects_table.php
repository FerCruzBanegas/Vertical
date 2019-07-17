<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name', 60);
            $table->string('location', 100);
            $table->mediumText('comments')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->tinyInteger('state')->default('1');
            $table->integer('project_type_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('project_type_id')->references('id')->on('project_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Full Text Index
        DB::statement('ALTER TABLE projects ADD FULLTEXT idx_full_text (name, location)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
