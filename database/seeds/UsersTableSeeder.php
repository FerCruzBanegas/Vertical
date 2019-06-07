<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$2y$10$jMhW4fDubsP20BxBp.4T0udNhJJlg9pd/Nvk7b951bGnmlmPQAMOO
        //$2y$10$PQvmtTVryJA4Dcb.gCRQSuzbUaadKH0yu8hWZ1LVeuMxviaxdPrGe
        User::create([
            'name'       => 'Nano',
            'email'      => 'nano.fer777@gmail.com',
            'password'   => bcrypt('nanolei'),
            'active'     => 1,
            'profile_id' => 1,
        ]);
    }
}
