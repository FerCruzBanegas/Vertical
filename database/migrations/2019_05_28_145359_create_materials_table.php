<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->integer('material_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('material_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Full Text Index
        DB::statement('ALTER TABLE materials ADD FULLTEXT idx_full_name (name)');
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
