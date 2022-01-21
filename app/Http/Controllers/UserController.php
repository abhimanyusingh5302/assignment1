<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Request\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Request\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user=$user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RegistrationUser(RegisterUserRequest $request)    // user registration 
    {
        
        if(isset($request)){
            $password = Hash::make($request->password);
            $data=$this->user->create([
                    "email"=>$request->email,
                    "name"=>$request->name,
                    "country_iso_code"=>$request->country_iso_code,
                    "date_of_birth"=>$request->date_of_birth,
                    "phone_number"=>$request->phone_number,
                    "password"=>$password,      
            ]);

            $data->auth_token = $data->createToken('Api access token')->accessToken;
            $return_data['data']=new  UserResource($data);
            $return_data['message']="Response successfully";
            $return_data['status']=200;
            return $return_data;
        }

    }

    /** login user request and response with tokken 
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)    //login 
    {
        
       if(isset($request)){
           $user=$this->user->where('email',$request->email)->first();
           if($user){
           if (!Hash::check($request->password, $user->password)) {
            
            $return_data['message']="Login Fail, pls check password";
            $return_data['status']=400;
            return $return_data;
         }
        
            
                $user->auth_token = $user->createToken('Api access token')->accessToken;     // token_create  
                $return_data['data']=new  UserResource($user);
                $return_data['message']="Response successfully";
                $return_data['status']=200;
                return $return_data;
        }
                $return_data['message']='Email not Found in our database';
                $return_data['status']=404;
                return $return_data;
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function show()    // profille 
    {
       $user=Auth::user();
       if ($user) {
           $return_data['data']=new  UserResource($user);
           $return_data['message']="Response successfully";
           $return_data['status']=200;
       }
        else{
            $return_data['message']="unauthorized";
       }
       return $return_data;
    }

   
}
