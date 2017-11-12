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
        Excel::load('excel/categories.csv', function($reader) {

            //get all categories
            $categories = $reader->all();

            //set current category
            $current = false;
            $parent = false;

            foreach($categories as $category){

                //remove whitespace
                $category->name = trim($category->name);
                $category->parent = trim($category->parent);

                if( (!$current) || ($current !== $category->parent)){

                    //set current category
                    $current = $category->name;

                    $parent = new Category;

                    $parent->name = $category->name;
                    $parent->save();
                }
                elseif($parent){ //if we have a parent

                    //check if category parent matches current parent
                    if($category->parent == $parent->name){

                        $sub_category = new Category;
                        
                        $sub_category->name = $category->name;
                        $sub_category->parent = $parent->id;
                        $sub_category->save();
                    }
                }
            }
        });

        // //create 10 primary categores
        // $categories = factory(Category::class, 10)->create();

        // //for each category, create 0 to 3 subcategories
        // foreach($categories as $category){

        // 	$rand = rand(0, 3);

        // 	if($rand){

        // 		//create subcategories
        // 		$subcategories = factory(Category::class, $rand)->create([ 'parent' => $category->id ]);

        // 		//for each subcategory, create 0 to 5 sub-subcategories
        // 		foreach($subcategories as $subcategory){

        // 			$rand = rand(0, 5);

        // 			if($rand)
        // 				factory(Category::class, $rand)->create([ 'parent' => $subcategory->id ]);
        // 		}
        // 	}
        // }
    }
}
