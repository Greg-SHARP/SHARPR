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
use Socialite;
use Google_Client;
use Facebook\Facebook;

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
                $user->name = $name;
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

            //create token
            $token = JWTAuth::fromUser($user);

            //send token back
            return $this->respondWithToken($token);
        }
        else {

            return response()->json([
                'error' => 'Invalid credentials.'
            ], 409);
        }
    }

    public function facebook(Request $request){

        $client_id = env('FACEBOOK_CLIENT_ID');
        $client_secret = env('FACEBOOK_CLIENT_SECRET');
        $token = $request->input('token');

        $fb = new Facebook([
            'app_id' => $client_id,
            'app_secret' => $client_secret,
            'default_graph_version' => 'v2.2'
        ]);

        $helper = $fb->getJavaScriptHelper();

        try {
          $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        if (! isset($accessToken)) {
          echo 'No cookie set or no OAuth data could be obtained from cookie.';
          exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // $providerUser = Socialite::driver('facebook')->stateless()->userFromToken($token);

        // if(!$providerUser->getEmail()){

        //     return response()->json([
        //         'error' => 'No email given.'
        //     ], 409);
        // }

        // $user = User::query()->firstOrNew([ 'email' => $providerUser->getEmail() ]);

        // if(!$user->exists) {
        //     $user->name = $providerUser->getName();
        //     $user->facebook_id = $providerUser->getId();
        //     $user->profile_img = $providerUser->getAvatar();
        //     $user->name = $providerUser->getName();
        //     $user->save(); 

        //     //get role
        //     $role = Role::select('id', 'label')
        //             ->where('label', $request->input('role'))
        //             ->first();


        //     //save role
        //     $user->roles()->save($role);

        //     //save user type
        //     if($role->label == 'student'){
        //         $student = new Student;
        //         $student->user_id = $user->id;
        //         $student->save();
        //     }
        //     else if($role->label == 'instructor'){
        //         $instructor = new Instructor;
        //         $instructor->user_id = $user->id;
        //         $instructor->save();
        //     }
        //     else if($role->label == 'institution'){
        //         $institution = new Institution;
        //         $institution->user_id = $user->id;
        //         $institution->save();
        //     }
        // }

        // //create token
        // $token = JWTAuth::fromUser($user);

        // //send token back
        // return $this->respondWithToken($token);
    }

    public function linkedIn(Request $request){

        $token = $request->input('token');

        $providerUser = Socialite::driver('linkedin')->stateless()->userFromToken($token);

        if(!$providerUser->getEmail()){

            return response()->json([
                'error' => 'No email given.'
            ], 409);
        }

        $user = User::query()->firstOrNew([ 'email' => $providerUser->getEmail() ]);

        if(!$user->exists) {
            $user->name = $providerUser->getName();
            $user->linkedin_id = $providerUser->getId();
            $user->profile_img = $providerUser->getAvatar();
            $user->name = $providerUser->getName();
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

        //create token
        $token = JWTAuth::fromUser($user);

        //send token back
        return $this->respondWithToken($token);
    }
}