<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Instructor;
use App\Institution;
use App\Student;
use App\Role;
use App\Rules\Roles;
use JWTAuth;
use Google_Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'login', 
            'signup', 
            'google', 
            'facebook', 
            'linkedin']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        //get user
        $user = $this->guard()->user()->load('roles');

        //create empty array
        $roles = [];

        //for each role, add to new array
        foreach ($user->roles as $role) {
            
            array_push($roles, $role->label);
        }

        //unset relationship
        unset($user->roles);

        //set new array
        $user->roles = array_unique($roles);

        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    public function signup(Request $request){

        //validate data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => ['required', new Roles]
        ]);

        //create data to insert
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        //save user
        $user->save();

        //get role
        $role = Role::select('id', 'label')
                ->where('label', $request->input('role'))
                ->first();


        //save role
        $user->roles()->save($role);

        //save user type
        if($role->label == 'student'){
            $student = new Student;
            $student->user_id = $user->id;
            $student->save();
        }
        else if($role->label == 'instructor'){
            $instructor = new Instructor;
            $instructor->user_id = $user->id;
            $instructor->save();
        }
        else if($role->label == 'institution'){
            $institution = new Institution;
            $institution->user_id = $user->id;
            $institution->save();
        }

        //create token
        $token = JWTAuth::fromUser($user);

        //send token back
        return $this->respondWithToken($token);
    }

    public function google(Request $request){

        $client_id = env('GOOGLE_CLIENT_ID');
        $client_secret = env('GOOGLE_CLIENT_SECRET');
        $token = $request->input('token');

        $client = new Google_Client([
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ]);

        $result = $client->verifyIdToken($token);

        if($result) {

            //get details
            $name        = $result['name'];
            $email       = $result['email'];
            $google_id   = $result['sub'];
            $profile_img = $result['picture'];

            $user = User::query()->firstOrNew([ 'email' => $email ]);

            if(!$user->exists) {

                $user->name = $name;
                $user->google_id = $google_id;
                $user->profile_img = $profile_img;
                $user->save(); 

                //get role
                $role = Role::select('id', 'label')
                        ->where('label', $request->input('role'))
                        ->first();


                //save role
                $user->roles()->save($role);

                //save user type
                if($role->label == 'student'){
                    $student = new Student;
                    $student->user_id = $user->id;
                    $student->save();
                }
                else if($role->label == 'instructor'){
                    $instructor = new Instructor;
                    $instructor->user_id = $user->id;
                    $instructor->save();
                }
                else if($role->label == 'institution'){
                    $institution = new Institution;
                    $institution->user_id = $user->id;
                    $institution->save();
                }
            }
            else{
                if(!$user->google_id){
                    return response()->json([
                        'error' => 'Email belongs to another account.'
                    ], 401);
                }

                //create token
                $token = JWTAuth::fromUser($user);

                //send token back
                return $this->respondWithToken($token);
            }
        }
        else {

            return response()->json([
                'error' => 'Invalid credentials.'
            ], 409);
        }
    }

    public function facebook(Request $request){
        
        $token = $request->input('token');

        $client = new Client();

        $result = $client->get('https://graph.facebook.com/me?', 
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '. $token
                ],
                'query' => [
                    'fields' => 'id,name,email,picture',
                    'scope' => 'email'
                ]
            ]);

        if($result) {

            $result = json_decode($result->getBody()->getContents());

            if(!isset($result->email)){

                return response()->json([
                    'error' => 'Email required!'
                ], 409);
            }

            //get details
            $name        = $result->name;
            $email       = $result->email;
            $facebook_id = $result->id;
            $profile_img = $result->picture->data->url;

            $user = User::query()->firstOrNew([ 'email' => $email ]);

            if(!$user->exists) {

                $user->name = $name;
                $user->facebook_id = $facebook_id;
                $user->profile_img = $profile_img;
                $user->save(); 

                //get role
                $role = Role::select('id', 'label')
                        ->where('label', $request->input('role'))
                        ->first();


                //save role
                $user->roles()->save($role);

                //save user type
                if($role->label == 'student'){
                    $student = new Student;
                    $student->user_id = $user->id;
                    $student->save();
                }
                else if($role->label == 'instructor'){
                    $instructor = new Instructor;
                    $instructor->user_id = $user->id;
                    $instructor->save();
                }
                else if($role->label == 'institution'){
                    $institution = new Institution;
                    $institution->user_id = $user->id;
                    $institution->save();
                }
            }
            else{

                if(!$user->facebook_id){
                    return response()->json([
                        'error' => 'Email belongs to another account.'
                    ], 401);
                }

                //create token
                $token = JWTAuth::fromUser($user);

                //send token back
                return $this->respondWithToken($token);
            }
        }
        else {

            return response()->json([
                'error' => 'Invalid credentials.'
            ], 409);
        }
    }

    public function linkedIn(Request $request){

        $email = $request->input('email');

        $user = User::query()->firstOrNew([ 'email' => $email ]);

        if(!$user->exists) {
            $user->name = $request->input('name');
            $user->linkedin_id = $request->input('linkedin_id');
            $user->profile_img = $request->input('profile_img');
            $user->save(); 

            //get role
            $role = Role::select('id', 'label')
                    ->where('label', $request->input('role'))
                    ->first();


            //save role
            $user->roles()->save($role);

            //save user type
            if($role->label == 'student'){
                $student = new Student;
                $student->user_id = $user->id;
                $student->save();
            }
            else if($role->label == 'instructor'){
                $instructor = new Instructor;
                $instructor->user_id = $user->id;
                $instructor->save();
            }
            else if($role->label == 'institution'){
                $institution = new Institution;
                $institution->user_id = $user->id;
                $institution->save();
            }
        }
        else{
            if(!$user->linkedin_id){
                return response()->json([
                    'error' => 'Email belongs to another account.'
                ], 401);
            }

            //create token
            $token = JWTAuth::fromUser($user);

            //send token back
            return $this->respondWithToken($token);
        }
    }
}