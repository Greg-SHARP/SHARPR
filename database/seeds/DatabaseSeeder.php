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
        $this->call(RolesTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(CertificatesTableSeeder::class);
        $this->call(CoursesTableSeeder::class);

        //relationship tables
        $this->call(UserCertificateTableSeeder::class);
        $this->call(CourseCategoryTableSeeder::class);
        $this->call(CourseTagTableSeeder::class);
        $this->call(CourseUserTableSeeder::class);
        $this->call(LikesTableSeeder::class);
    }
}
