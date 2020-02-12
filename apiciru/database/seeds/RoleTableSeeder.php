<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name='Admin';
        $role->descripcion='Permiso para usar Ciru Client Desktop y App';
        $role->save();

        $role = new Role();
        $role->name='Invitado';
        $role->descripcion='Permiso para usar Ciru Cient App';
        $role->save();

    }
}
