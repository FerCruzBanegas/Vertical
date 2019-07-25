<?php

use App\Action;
use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    public function run()
    {
        Action::create(['name' => 'Acesso total al sistema', 'method' => '*', 'order' => 1, 'title' => 'Sistema']);

        //Tipos de Material
        Action::create(['name' => 'Ver Lista', 'method' => 'material-types.index', 'order' => 2, 'title' => 'Tipos de Material']);
        Action::create(['name' => 'Registrar', 'method' => 'material-types.create', 'order' => 3, 'title' => 'Tipos de Material']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'material-types.show', 'order' => 4, 'title' => 'Tipos de Material']);
        Action::create(['name' => 'Actualizar', 'method' => 'material-types.update', 'order' => 5, 'title' => 'Tipos de Material']);
        Action::create(['name' => 'Eliminar', 'method' => 'material-types.destroy', 'order' => 6, 'title' => 'Tipos de Material']);

        //Materiales
        Action::create(['name' => 'Ver Lista', 'method' => 'materials.index', 'order' => 7, 'title' => 'Materiales']);
        Action::create(['name' => 'Registrar', 'method' => 'materials.create', 'order' => 8, 'title' => 'Materiales']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'materials.show', 'order' => 9, 'title' => 'Materiales']);
        Action::create(['name' => 'Actualizar', 'method' => 'materials.update', 'order' => 10, 'title' => 'Materiales']);
        Action::create(['name' => 'Eliminar', 'method' => 'materials.destroy', 'order' => 11, 'title' => 'Materiales']);

        //Tipos de Proyecto
        Action::create(['name' => 'Ver Lista', 'method' => 'project-types.index', 'order' => 12, 'title' => 'Tipos de Proyecto']);
        Action::create(['name' => 'Registrar', 'method' => 'project-types.create', 'order' => 13, 'title' => 'Tipos de Proyecto']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'project-types.show', 'order' => 14, 'title' => 'Tipos de Proyecto']);
        Action::create(['name' => 'Actualizar', 'method' => 'project-types.update', 'order' => 15, 'title' => 'Tipos de Proyecto']);
        Action::create(['name' => 'Eliminar', 'method' => 'project-types.destroy', 'order' => 16, 'title' => 'Tipos de Proyecto']);

        //Proyectos
        Action::create(['name' => 'Ver Lista', 'method' => 'projects.index', 'order' => 17, 'title' => 'Proyectos']);
        Action::create(['name' => 'Registrar', 'method' => 'projects.create', 'order' => 18, 'title' => 'Proyectos']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'projects.show', 'order' => 19, 'title' => 'Proyectos']);
        Action::create(['name' => 'Actualizar', 'method' => 'projects.update', 'order' => 20, 'title' => 'Proyectos']);
        Action::create(['name' => 'Eliminar', 'method' => 'projects.destroy', 'order' => 21, 'title' => 'Proyectos']);

        //Tipos de egreso
        Action::create(['name' => 'Ver Lista', 'method' => 'expense-types.index', 'order' => 22, 'title' => 'Tipos de Egreso']);
        Action::create(['name' => 'Registrar', 'method' => 'expense-types.create', 'order' => 23, 'title' => 'Tipos de Egreso']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'expense-types.show', 'order' => 24, 'title' => 'Tipos de Egreso']);
        Action::create(['name' => 'Actualizar', 'method' => 'expense-types.update', 'order' => 25, 'title' => 'Tipos de Egreso']);
        Action::create(['name' => 'Eliminar', 'method' => 'expense-types.destroy', 'order' => 26, 'title' => 'Tipos de Egreso']);

        //Egresos
        Action::create(['name' => 'Ver Lista', 'method' => 'expenses.index', 'order' => 27, 'title' => 'Egresos']);
        Action::create(['name' => 'Registrar', 'method' => 'expenses.create', 'order' => 28, 'title' => 'Egresos']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'expenses.show', 'order' => 29, 'title' => 'Egresos']);
        Action::create(['name' => 'Actualizar', 'method' => 'expenses.update', 'order' => 30, 'title' => 'Egresos']);
        Action::create(['name' => 'Eliminar', 'method' => 'expenses.destroy', 'order' => 31, 'title' => 'Egresos']);

        //Tipos de ingreso
        Action::create(['name' => 'Ver Lista', 'method' => 'income-types.index', 'order' => 32, 'title' => 'Tipos de Ingreso']);
        Action::create(['name' => 'Registrar', 'method' => 'income-types.create', 'order' => 33, 'title' => 'Tipos de Ingreso']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'income-types.show', 'order' => 34, 'title' => 'Tipos de Ingreso']);
        Action::create(['name' => 'Actualizar', 'method' => 'income-types.update', 'order' => 35, 'title' => 'Tipos de Ingreso']);
        Action::create(['name' => 'Eliminar', 'method' => 'income-types.destroy', 'order' => 36, 'title' => 'Tipos de Ingreso']);

        //Ingresos
        Action::create(['name' => 'Ver Lista', 'method' => 'incomes.index', 'order' => 37, 'title' => 'Ingresos']);
        Action::create(['name' => 'Registrar', 'method' => 'incomes.create', 'order' => 38, 'title' => 'Ingresos']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'incomes.show', 'order' => 39, 'title' => 'Ingresos']);
        Action::create(['name' => 'Actualizar', 'method' => 'incomes.update', 'order' => 40, 'title' => 'Ingresos']);
        Action::create(['name' => 'Eliminar', 'method' => 'incomes.destroy', 'order' => 41, 'title' => 'Ingresos']);

        //Perfiles
        Action::create(['name' => 'Ver Lista', 'method' => 'profiles.index', 'order' => 42, 'title' => 'Perfiles']);
        Action::create(['name' => 'Registrar', 'method' => 'profiles.create', 'order' => 43, 'title' => 'Perfiles']);
        Action::create(['name' => 'Actualizar', 'method' => 'profiles.show|profiles.update', 'order' => 44, 'title' => 'Perfiles']);
        Action::create(['name' => 'Eliminar', 'method' => 'profiles.destroy', 'order' => 45, 'title' => 'Perfiles']);

        //Personas
        Action::create(['name' => 'Ver Lista', 'method' => 'people.index', 'order' => 46, 'title' => 'Personas']);
        Action::create(['name' => 'Registrar', 'method' => 'people.create', 'order' => 47, 'title' => 'Personas']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'people.show', 'order' => 48, 'title' => 'Personas']);
        Action::create(['name' => 'Actualizar', 'method' => 'people.update', 'order' => 49, 'title' => 'Personas']);
        Action::create(['name' => 'Eliminar', 'method' => 'people.destroy', 'order' => 50, 'title' => 'Personas']);

        //Usuarios
        Action::create(['name' => 'Ver Lista', 'method' => 'users.index', 'order' => 51, 'title' => 'Usuarios']);
        Action::create(['name' => 'Registrar', 'method' => 'users.create', 'order' => 52, 'title' => 'Usuarios']);
        Action::create(['name' => 'Ver Detalle', 'method' => 'users.show', 'order' => 53, 'title' => 'Usuarios']);
        Action::create(['name' => 'Actualizar', 'method' => 'users.update', 'order' => 54, 'title' => 'Usuarios']);
        Action::create(['name' => 'Eliminar', 'method' => 'users.destroy', 'order' => 55, 'title' => 'Usuarios']);

        //Informes
        Action::create(['name' => 'Ver Todos', 'method' => 'reports.index', 'order' => 56, 'title' => 'Informes']);

        // Action::create(['name' => 'Acesso total al sistema', 'method' => '*', 'order' => 1]);

        // //Tipos de Material
        // Action::create(['name' => 'Lista de tipos de material', 'method' => 'material-types.index', 'order' => 2]);
        // Action::create(['name' => 'Registrar tipo de material', 'method' => 'material-types.create', 'order' => 3]);
        // Action::create(['name' => 'Detalle tipo de material', 'method' => 'material-types.show', 'order' => 4]);
        // Action::create(['name' => 'Actualizar tipo de material', 'method' => 'material-types.show|material-types.update', 'order' => 5]);
        // Action::create(['name' => 'Eliminar tipo de material', 'method' => 'material-types.destroy', 'order' => 6]);

        // //Materiales
        // Action::create(['name' => 'Lista de materiales', 'method' => 'materials.index', 'order' => 7]);
        // Action::create(['name' => 'Registrar material', 'method' => 'materials.create', 'order' => 8]);
        // Action::create(['name' => 'Detalle de material', 'method' => 'materials.show', 'order' => 9]);
        // Action::create(['name' => 'Actualizar material', 'method' => 'materials.show|materials.update', 'order' => 10]);
        // Action::create(['name' => 'Eliminar material', 'method' => 'materials.destroy', 'order' => 11]);

        // //Tipos de Proyecto
        // Action::create(['name' => 'Lista de tipos de proyecto', 'method' => 'project-types.index', 'order' => 12]);
        // Action::create(['name' => 'Registrar tipo de proyecto', 'method' => 'project-types.create', 'order' => 13]);
        // Action::create(['name' => 'Detalle tipo de proyecto', 'method' => 'project-types.show', 'order' => 14]);
        // Action::create(['name' => 'Actualizar tipo de proyecto', 'method' => 'project-types.show|project-types.update', 'order' => 15]);
        // Action::create(['name' => 'Eliminar tipo de proyecto', 'method' => 'project-types.destroy', 'order' => 16]);

        // //Proyectos
        // Action::create(['name' => 'Lista de proyectos', 'method' => 'projects.index', 'order' => 17]);
        // Action::create(['name' => 'Registrar proyecto', 'method' => 'projects.create', 'order' => 18]);
        // Action::create(['name' => 'Detalle de proyecto', 'method' => 'projects.show', 'order' => 19]);
        // Action::create(['name' => 'Actualizar proyecto', 'method' => 'projects.show|projects.update', 'order' => 20]);
        // Action::create(['name' => 'Eliminar proyecto', 'method' => 'projects.destroy', 'order' => 21]);

        // //Tipos de egreso
        // Action::create(['name' => 'Lista de tipos de egreso', 'method' => 'expense-types.index', 'order' => 22]);
        // Action::create(['name' => 'Registrar tipo de egreso', 'method' => 'expense-types.create', 'order' => 23]);
        // Action::create(['name' => 'Detalle tipo de egreso', 'method' => 'expense-types.show', 'order' => 24]);
        // Action::create(['name' => 'Actualizar tipo de egreso', 'method' => 'expense-types.show|expense-types.update', 'order' => 25]);
        // Action::create(['name' => 'Eliminar tipo de egreso', 'method' => 'expense-types.destroy', 'order' => 26]);

        // //Egresos
        // Action::create(['name' => 'Lista de egresos', 'method' => 'expenses.index', 'order' => 27]);
        // Action::create(['name' => 'Registrar egreso', 'method' => 'expenses.create', 'order' => 28]);
        // Action::create(['name' => 'Detalle de egreso', 'method' => 'expenses.show', 'order' => 29]);
        // Action::create(['name' => 'Actualizar egreso', 'method' => 'expenses.show|expenses.update', 'order' => 30]);
        // Action::create(['name' => 'Eliminar egreso', 'method' => 'expenses.destroy', 'order' => 31]);

        // //Tipos de ingreso
        // Action::create(['name' => 'Lista de tipos de ingreso', 'method' => 'income-types.index', 'order' => 32]);
        // Action::create(['name' => 'Registrar tipo de ingreso', 'method' => 'income-types.create', 'order' => 33]);
        // Action::create(['name' => 'Detalle tipo de ingreso', 'method' => 'income-types.show', 'order' => 34]);
        // Action::create(['name' => 'Actualizar tipo de ingreso', 'method' => 'income-types.show|income-types.update', 'order' => 35]);
        // Action::create(['name' => 'Eliminar tipo de ingreso', 'method' => 'income-types.destroy', 'order' => 36]);

        // //Ingresos
        // Action::create(['name' => 'Lista de ingresos', 'method' => 'incomes.index', 'order' => 37]);
        // Action::create(['name' => 'Registrar ingreso', 'method' => 'incomes.create', 'order' => 38]);
        // Action::create(['name' => 'Detalle de ingreso', 'method' => 'incomes.show', 'order' => 39]);
        // Action::create(['name' => 'Actualizar ingreso', 'method' => 'incomes.show|incomes.update', 'order' => 40]);
        // Action::create(['name' => 'Eliminar ingreso', 'method' => 'incomes.destroy', 'order' => 41]);

        // //Perfiles
        // Action::create(['name' => 'Lista de perfiles', 'method' => 'profiles.index', 'order' => 42]);
        // Action::create(['name' => 'Registrar perfiles', 'method' => 'profiles.create', 'order' => 43]);
        // Action::create(['name' => 'Actualizar perfiles', 'method' => 'profiles.show|profiles.update', 'order' => 44]);
        // Action::create(['name' => 'Eliminar perfiles', 'method' => 'profiles.destroy', 'order' => 45]);

        // //Personas
        // Action::create(['name' => 'Lista de personas', 'method' => 'people.index', 'order' => 46]);
        // Action::create(['name' => 'Registrar persona', 'method' => 'people.create', 'order' => 47]);
        // Action::create(['name' => 'Detalle de persona', 'method' => 'people.show', 'order' => 48]);
        // Action::create(['name' => 'Actualizar persona', 'method' => 'people.show|people.update', 'order' => 49]);
        // Action::create(['name' => 'Eliminar persona', 'method' => 'people.destroy', 'order' => 50]);

        // //Usuarios
        // Action::create(['name' => 'Lista de usuarios', 'method' => 'users.index', 'order' => 51]);
        // Action::create(['name' => 'Registrar usuario', 'method' => 'users.create', 'order' => 52]);
        // Action::create(['name' => 'Detalle de usuario', 'method' => 'users.show', 'order' => 53]);
        // Action::create(['name' => 'Actualizar usuario', 'method' => 'users.show|users.update', 'order' => 54]);
        // Action::create(['name' => 'Eliminar usuario', 'method' => 'users.destroy', 'order' => 55]);
    }
}
