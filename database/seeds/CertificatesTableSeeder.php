<?php

use Illuminate\Database\Seeder;
use App\Certificate;

class CertificatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//create 25 certificates
        factory(Certificate::class, 20)->create();
    }
}
