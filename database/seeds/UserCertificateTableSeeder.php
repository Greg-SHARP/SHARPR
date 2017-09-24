<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Certificate;

class UserCertificateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        //give every user 0 to 3 certificates
        foreach($users as $user){

        	$rand = rand(0, 3);

        	if($rand){

        		$certificates = Certificate::all()->random($rand);

	        	foreach($certificates as $certificate){

	        		DB::table('user_certificate')
	        			->insert(['user_id' => $user->id, 'certificate_id' => $certificate->id]);
	        	}
        	}
        }
    }
}
