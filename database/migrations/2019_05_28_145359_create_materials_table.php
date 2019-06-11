<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->enum('unity', ['amarro', 'barra', 'bolsa', 'caja', 'cajón', 'carga', 'dm³', 'fajo', 'fardo', 'g', 'galón', 'glb', 'ha', 'juego', 'kg', 'l', 'lata', 'lb', 'm', 'm²', 'm³', 'mm', 'perfil', 'pie', 'pie²', 'placa', 'plomo', 'pqte', 'pto', 'pza', 'resma', 'rollo', 't', 'tubo', 'turril', 'unds']);
            $table->mediumText('description');
            $table->float('price', 9, 2)->nullable();
            $table->integer('category_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')
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
        Schema::dropIfExists('materials');
    }
}
