<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function postRole(Request $request){

    	$role = new Role();
    	
    	$role->name = $request->input('name');

    	$role->save();

    	return response()->json(['role' => $role], 201);
    }
    public function getRoles(){

    	$roles = Role::all();

    	$response = [
    		'roles' => $roles
    	];

    	return response()->json($response, 200);
    }
    public function getRole($id){

    	$role = Role::find($id);

    	if(!$role){

    		return response()->json(['message' => 'Role not found'], 404);
    	}

    	return response()->json($role, 200);
    }
    public function putRole(Request $request, $id){

    	$role = Role::find($id);

    	if(!$role){

    		return response()->json(['message' => 'Role not found'], 404);
    	}

    	$role->name = $request->input('name');

    	$role->save();

    	return response()->json(['role' => $role], 200);
    }
    public function deleteRole($id){

    	$role = Role::find($id);

    	$role->delete();

    	return response()->json(['message' => 'Role deleted'], 200);
    }
}