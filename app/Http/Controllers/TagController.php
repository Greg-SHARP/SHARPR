<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function postTag(Request $request){

    	$tag = new Tag();
    	
    	$tag->name = $request->input('name');

    	$tag->save();

    	return response()->json(['tag' => $tag], 201);
    }
    public function getTags(){

    	$tags = Tag::all();

    	$response = [
    		'tags' => $tags
    	];

    	return response()->json($response, 200);
    }
    public function getTag($id){

    	$tag = Tag::all();

    	if(!$tag){

    		return response()->json(['message' => 'Tag not found'], 404);
    	}

    	return response()->json($tag, 200);
    }
    public function putTag(Request $request, $id){

    	$tag = Tag::find($id);

    	if(!$tag){

    		return response()->json(['message' => 'Tag not found'], 404);
    	}

    	$tag->name = $request->input('name');

    	$tag->save();

    	return response()->json(['tag' => $tag], 200);
    }
    public function deleteTag($id){

    	$tag = Tag::find($id);

    	$tag->delete();

    	return response()->json(['message' => 'Tag deleted'], 200);
    }
}