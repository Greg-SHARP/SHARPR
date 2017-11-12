<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Excel;

class CategoryController extends Controller
{
    public function postCategory(Request $request){

    	$category = new Category();

    	$category->name   = $request->input('name');
    	$category->parent = $request->input('parent');

    	$category->save();

    	return response()->json(['category' => $category], 201);
    }
    public function getCategories(){

    	$categories = Category::all();

    	$response = [
    		'categories' => $categories
    	];

    	return response()->json($response, 200);
    }
    public function getCategory($id){

    	$category = Category::find($id);

    	if(!$category){

    		return response()->json(['message' => 'Category not found'], 404);
    	}

    	return response()->json($category, 200);
    }
    public function putCategory(Request $request, $id){

    	$category = Category::find($id);

    	if(!$category){

    		return response()->json(['message' => 'Category not found'], 404);
    	}

    	$category->name   = $request->input('name');
    	$category->parent = $request->input('parent');

    	$category->save();

    	return response()->json(['category' => $category], 200);
    }
    public function deleteCategory($id){

    	$category = Category::find($id);

    	$category->delete();

    	return response()->json(['message' => 'Category deleted'], 200);
    }
}