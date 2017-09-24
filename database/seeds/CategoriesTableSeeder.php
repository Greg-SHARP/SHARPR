<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//create 10 primary categores
        $categories = factory(Category::class, 10)->create();

        //for each category, create 0 to 3 subcategories
        foreach($categories as $category){

        	$rand = rand(0, 3);

        	if($rand){

        		//create subcategories
        		$subcategories = factory(Category::class, $rand)->create([ 'parent' => $category->id ]);

        		//for each subcategory, create 0 to 5 sub-subcategories
        		foreach($subcategories as $subcategory){

        			$rand = rand(0, 5);

        			if($rand)
        				factory(Category::class, $rand)->create([ 'parent' => $subcategory->id ]);
        		}
        	}
        }
    }
}
