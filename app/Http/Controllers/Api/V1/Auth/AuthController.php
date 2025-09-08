<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     protected  $authentication;

     /**
      * Undocumented function
      *
      * @param AuthService $authentication
      */

     public function __construct(AuthService $authentication)
     {
        $this->authentication=$authentication;
     }

 
     /**
      * Summary of register
      * @param \App\Http\Requests\Auth\RegisterRequest $request
      * @return \Illuminate\Http\JsonResponse
      */
     public function register(RegisterRequest $request){
         $data=$this->authentication->register($request->validated());
         return $this->successMessage($data,'Successfully add new User ',201);
     }



     /**
      * Summary of login
      * @param \App\Http\Requests\Auth\LoginRequest $request
      * @return \Illuminate\Http\JsonResponse
      */
     public function login(LoginRequest $request){
        $data=$this->authentication->login($request->validated());
        return $this->successMessage([$data],'Successfully Login',200);
     }


     /**
      * Summary of logout
      * @param mixed $all
      * @return \Illuminate\Http\JsonResponse
      */
     public function logout($all=null){

        $data=$this->authentication->logout($all);
        return $this->successMessage(['status'=>true],'Successfully logout',200);
     }
}
