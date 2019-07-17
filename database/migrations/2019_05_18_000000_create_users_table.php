<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 128)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('active');
            $table->integer('profile_id')->unsigned();
            $table->integer('people_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Full Text Index
        DB::statement('ALTER TABLE users ADD FULLTEXT idx_full_text (name, email)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
