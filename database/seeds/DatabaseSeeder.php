<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(CertificatesTableSeeder::class);
        $this->call(CoursesTableSeeder::class);

        //relationship tables
        $this->call(UserCertificateTableSeeder::class);
        $this->call(CourseCategoryTableSeeder::class);
        $this->call(CourseTagTableSeeder::class);
    }
}
