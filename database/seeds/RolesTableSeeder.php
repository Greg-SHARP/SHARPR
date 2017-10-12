<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
        Role::create(['label' => 'admin']);
        Role::create(['label' => 'instructor']); 
        Role::create(['label' => 'student']); 
        Role::create(['label' => 'institution']); 
        Role::create(['label' => 'employee']); 
        Role::create(['label' => 'manager']);
        Role::create(['label' => 'parent']);
    }
}
