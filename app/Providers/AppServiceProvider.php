<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'courses' => 'App\Course',
            'instructors' => 'App\Instructor',
            'institutions' => 'App\Institution',
            'students' => 'App\Student',
            'semesters' => 'App\Semester',
            'categories' => 'App\Category',
            'tags' => 'App\Tag'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
