<?php

namespace App\Http\Controllers;

abstract class Controller
{


    /**
     * Summary of successMessage
     * @param array $data
     * @param mixed $message
     * @param mixed $code
     * @return \Illuminate\Http\JsonResponse
     */
    public  function successMessage(array $data,$message,$code){
        return response()->json([
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }


    /**
     * Summary of errorMessage
     * @param mixed $error
     * @param mixed $data
     * @param mixed $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorMessage($error,$data,$code){
           return response()->json([
            'message'=>$error,
            'data'=>$data,
        ],$code);
    }
}
