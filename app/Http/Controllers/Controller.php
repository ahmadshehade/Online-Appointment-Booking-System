<?php

namespace App\Http\Controllers;

abstract class Controller
{

/**
 * Undocumented function
 *
 * @param array $data
 * @param [type] $message
 * @param [type] $code
 * @return void
 */
    public  function successMessage(array $data,$message,$code){
        return response()->json([
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }


    /**
     * Undocumented function
     *
     * @param [type] $error
     * @param [type] $data
     * @param [type] $code
     * @return void
     */
    public function errorMessage($error,$data,$code){
           return response()->json([
            'message'=>$error,
            'data'=>$data,
        ],$code);
    }
}
