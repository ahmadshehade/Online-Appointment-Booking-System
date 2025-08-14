<?php
namespace App\Services;

use App\Enum\UserRoles;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {

   /**
    * Undocumented function
    *
    * @param array $data
    * @return mixed
    */
    public function  register(array $data):mixed{
        try{
            $data['password']=Hash::make($data['password']);
            $user=User::create($data);
            $token = $user->createToken('auth_user')->plainTextToken;
            return [
                'user'=>$user,
                'token'=>$token
            ];
        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     *
     * @param array $data
     * @throws \Exception
     * @return array{token: string, user: User}
     */
    public function  login(array $data){
        try{
            $user=User::where('email',$data['email'])->firstOrFail();
            if($user && Hash::check($data['password'], $user->password)){
                $token = $user->createToken('auth_user')->plainTextToken;
                return [
                    'user'=>$user,
                    'token'=>$token

                ];
            }else{
                throw new Exception('Invalid credentials');
            }
        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * Summary of logout
     * @param mixed $all
     * @return bool
     */
    public function logout($all=null){
        $user=Auth::user();
        if($all !=null){
             $user->tokens()->delete();
        }else{
             $user->currentAccessToken()->delete();

        }
        return true;
    }


}
