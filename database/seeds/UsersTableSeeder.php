<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Instructor;
use App\Student;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//create 1 admin
        $id = factory(User::class)->create()->id;

        DB::table('user_type')->insert(['user_id' => $id, 'type_id' => 1]);

    	//create 10 instructors
        $users = factory(User::class, 10)->create();

        foreach($users as $user){

        	DB::table('user_type')->insert(['user_id' => $user->id, 'type_id' => 2]);
        	factory(Instructor::class)->create([ 'user_id' => $user->id ]);
        }

    	//create 50 students
        $users = factory(User::class, 10)->create();

        foreach($users as $user){

        	DB::table('user_type')->insert(['user_id' => $user->id, 'type_id' => 3]);
        	factory(Student::class)->create([ 'user_id' => $user->id ]);
        }

    	//create 10 institutions
        $users = factory(User::class, 10)->create();

        foreach($users as $user){

        	DB::table('user_type')->insert(['user_id' => $user->id, 'type_id' => 4]);
        }

    	//create 10 employees
        $users = factory(User::class, 10)->create();

        foreach($users as $user){

        	DB::table('user_type')->insert(['user_id' => $user->id, 'type_id' => 5]);
        }

    	//create 5 managers
        $users = factory(User::class, 5)->create();

        foreach($users as $user){

        	DB::table('user_type')->insert(['user_id' => $user->id, 'type_id' => 6]);
        }

        //get users
        $users = User::all();

        //for every user, add referred by id
        foreach($users as $user){

        	//leave null 80% of the time
        	$rand = rand(1, 100); 

        	if($rand >= 80) 
        		$user->update(['referred_by' => User::pluck('id')->where('id', '!=', $user->id)->random()]);
        }
    }
}
