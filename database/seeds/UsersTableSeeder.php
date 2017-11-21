<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Instructor;
use App\Student;
use App\Rating;
use App\Address;

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

        DB::table('role_user')->insert(['user_id' => $id, 'role_id' => 1]);

        // //create 10 instructors
        // $users = factory(User::class, 10)->create();

        // foreach($users as $user){

        // 	DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => 2]);
        // 	factory(Instructor::class)->create([ 'user_id' => $user->id ]);

        //     //create 0 to 10 ratings for each instructor
        //     $rand = rand(1, 10);

        //     factory(Rating::class, $rand)->create(['rateable_id' => $user->id, 'rateable_type' => 'instructors']);

        //     //create 1 to 2 addresses
        //     $rand = rand(0, 1);

        //     //create address
        //     factory(Address::class)->create([
        //         'addressable_id' => $user->id, 
        //         'addressable_type' => 'instructors']);

        //     if($rand){

        //         //create work address
        //         factory(Address::class)->create([
        //             'addressable_id' => $user->id, 
        //             'addressable_type' => 'instructors',
        //             'type' => 'work']);
        //     }

        //     factory(Rating::class, $rand)->create(['rateable_id' => $user->id, 'rateable_type' => 'instructors']);
        // }
        
        //import instructors
        Excel::load('excel/instructors.csv', function($reader) {

            //get all instructors
            $instructors = $reader->all();

            foreach($instructors as $instructor){

                //remove whitespace
                $instructor->name = trim($instructor->name);
                $instructor->email = trim($instructor->email);
                $instructor->profile_img = trim($instructor->profile_img);
                $instructor->dob = trim($instructor->dob);
                $instructor->phone = trim($instructor->phone);
                $instructor->description = trim($instructor->description);
                $instructor->url = trim($instructor->url);
                $instructor->facebook = trim($instructor->facebook);
                $instructor->twitter = trim($instructor->twitter);
                $instructor->linkedin = trim($instructor->linkedin);
                $instructor->pinterest = trim($instructor->pinterest);
                $instructor->yelp = trim($instructor->yelp);

                //create user
                $user = new User;

                //set data
                $user->name = $instructor->name;
                $user->email = $instructor->email;
                $user->password = bcrypt('password');
                $user->remember_token = str_random(10);
                $user->profile_img = $instructor->profile_img;
                $user->dob = date_create($instructor->dob);
                $user->status = 'active';
                $user->verified = 1;

                //save user
                $user->save();

                //make new instructor
                $new_instructor = new Instructor;

                //create details
                $details = [
                    'description' => $instructor->description,
                    'url' => $instructor->url,
                    'facebook' => $instructor->facebook,
                    'twitter' => $instructor->twitter,
                    'linkedin' => $instructor->linkedin,
                    'pinterest' => $instructor->pinterest,
                    'yelp' => $instructor->yelp
                ];

                $new_instructor->phone = $instructor->phone;
                $new_instructor->details = json_encode($details);

                //save instructor to newly created user
                $user->instructor()->save($new_instructor);

                //attach instructor role
                $user->roles()->attach(2);
            }
        });

    	//create 50 students
        $users = factory(User::class, 50)->create();

        foreach($users as $user){

        	DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => 3]);
        	factory(Student::class)->create([ 'user_id' => $user->id ]);

            //create 0 to 10 ratings for each student
            $rand = rand(1, 10);
            
            factory(Rating::class, $rand)->create(['rateable_id' => $user->id, 'rateable_type' => 'students']);

            //create 1 to 2 addresses
            $rand = rand(0, 1);

            //create address
            factory(Address::class)->create([
                'addressable_id' => $user->id, 
                'addressable_type' => 'students']);

            if($rand){

                //create secondary address
                factory(Address::class)->create([
                    'addressable_id' => $user->id, 
                    'addressable_type' => 'students',
                    'type' => 'secondary']);
            }
        }

    	//create 10 institutions
        $users = factory(User::class, 10)->create();

        foreach($users as $user){

        	DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => 4]);
        }

    	//create 10 employees
        $users = factory(User::class, 10)->create();

        foreach($users as $user){

        	DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => 5]);
        }

    	//create 5 managers
        $users = factory(User::class, 5)->create();

        foreach($users as $user){

        	DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => 6]);
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
