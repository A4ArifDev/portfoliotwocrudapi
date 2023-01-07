<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // show all user
    public function index(){
        return User::all();
    }
    // register function:

    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required | email',
            'bio' => 'required | max:50',
            'profile' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'required | confirmed'
        ]);
        if(User::where('email',$request->email)->first()){
            return response([
                'message'=>"USER ALREADY EXIST"
            ]);
        }

            //naming and storing image

            $ext = $request->profile->getClientOriginalExtension();
            $profile = time().'.'.$ext;
            $request->profile->move(public_path() . '/avatars/', $profile);
            
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'bio' => $request->bio,
            'profile'=>$profile,
            'password'=>Hash::make($request->password),
        ]);
        $token = $user->createToken($request->email)->plainTextToken;
        
        return response(compact('user','token'));
    }

    //login function

    public function login(Request $request){
        $request->validate([
            'email'=>'required | email',
            'password'=>'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
        $token = $user->createToken($request->email)->plainTextToken;
            return response([
                'token'=>$token,
                'message'=>"LOGIN SUCCESFULL",
                "status"=>true
            ]);
        }
        return response([
            'message'=>"LOGIN  UNSUCCESFULL"
        ],422);
    }

    // logout funtion

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message'=>"LOGOUT  SUCCESFULL",
            "status"=>true
        ]);
    }

    public function logged_user(){
        $loggeduser = auth()->user();
        return response([
            'user'=>$loggeduser,
            'message' => 'Logged User Data',
            'status'=>true
        ], 200);
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();

        return response([
            'message'=>'Admin successfully Deleted',
            'status'=>true
        ]);
    }

}
