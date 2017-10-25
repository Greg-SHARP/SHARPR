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
        Group::create(['label' => 'For Fun']);
        Group::create(['label' => 'For Work']); 
        Group::create(['label' => 'For Kids']);
    }
}
