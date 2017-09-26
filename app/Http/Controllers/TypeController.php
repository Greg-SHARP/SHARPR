<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;

class TypeController extends Controller
{
    public function postType(Request $request){

    	$type = new Type();
    	
    	$type->name = $request->input('name');

    	$type->save();

    	return response()->json(['type' => $type], 201);
    }
    public function getTypes(){

    	$types = Type::all();

    	$response = [
    		'types' => $types
    	];

    	return response()->json($response, 200);
    }
    public function getType($id){

    	$type = Type::find($id);

    	if(!$type){

    		return response()->json(['message' => 'Type not found'], 404);
    	}

    	return response()->json($type, 200);
    }
    public function putType(Request $request, $id){

    	$type = Type::find($id);

    	if(!$type){

    		return response()->json(['message' => 'Type not found'], 404);
    	}

    	$type->name = $request->input('name');

    	$type->save();

    	return response()->json(['type' => $type], 200);
    }
    public function deleteType($id){

    	$type = Type::find($id);

    	$type->delete();

    	return response()->json(['message' => 'Type deleted'], 200);
    }
}