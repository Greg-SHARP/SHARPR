<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create types
        Type::create(['label' => 'admin']);
        Type::create(['label' => 'instructor']); 
        Type::create(['label' => 'student']); 
        Type::create(['label' => 'institution']); 
        Type::create(['label' => 'employee']); 
        Type::create(['label' => 'manager']);
    }
}
