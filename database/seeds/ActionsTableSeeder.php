<?php

use App\Action;
use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::create(['name' => 'Acesso total al sistema', 'method' => '*', 'order' => 1]);

        Action::create(['name' => 'Lista de categorías', 'method' => 'categories.index', 'order' => 2]);
        Action::create(['name' => 'Registrar categoría', 'method' => 'categories.create', 'order' => 3]);
        Action::create(['name' => 'Actualizar categoría', 'method' => 'categories.update', 'order' => 4]);
        Action::create(['name' => 'Eliminar categoría', 'method' => 'categories.destroy', 'order' => 5]);

        Action::create(['name' => 'Lista de materiales', 'method' => 'materials.index', 'order' => 6]);
        Action::create(['name' => 'Registrar material', 'method' => 'materials.create', 'order' => 7]);
        Action::create(['name' => 'Detalle de material', 'method' => 'materials.show', 'order' => 8]);
        Action::create(['name' => 'Actualizar material', 'method' => 'materials.show|materials.update', 'order' => 9]);
        Action::create(['name' => 'Eliminar material', 'method' => 'materials.destroy', 'order' => 10]);

        Action::create(['name' => 'Lista de perfiles', 'method' => 'profiles.index', 'order' => 11]);
        Action::create(['name' => 'Registrar perfiles', 'method' => 'profiles.create', 'order' => 12]);
        Action::create(['name' => 'Actualizar perfiles', 'method' => 'profiles.show|profiles.update', 'order' => 13]);
        Action::create(['name' => 'Eliminar perfiles', 'method' => 'profiles.destroy', 'order' => 14]);

        Action::create(['name' => 'Lista de usuarios', 'method' => 'users.index', 'order' => 15]);
        Action::create(['name' => 'Registrar usuario', 'method' => 'users.create', 'order' => 16]);
        Action::create(['name' => 'Detalle de usuario', 'method' => 'users.show', 'order' => 17]);
        Action::create(['name' => 'Actualizar usuario', 'method' => 'users.show|users.update', 'order' => 18]);
        Action::create(['name' => 'Eliminar usuario', 'method' => 'users.destroy', 'order' => 19]);
    }
}
