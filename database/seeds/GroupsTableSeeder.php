<?php

use Illuminate\Database\Seeder;
use App\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
        Group::create(['name' => 'For Fun']);
        Group::create(['name' => 'For Work']); 
        Group::create(['name' => 'For Kids']);
    }
}
