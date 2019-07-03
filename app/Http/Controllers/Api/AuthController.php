<?php

namespace App\Http\Controllers\Api;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends AccessTokenController{

    public function getAccessToken(ServerRequestInterface $request){


    
        $data_request = $request->getParsedBody();
        $user = User::where('name', $data_request['username'])->orWhere('email',$data_request['username'])->first();
        if($user==null){
            return response()->json(
                [
                    'status'    => false, 
                    'code'      => 1, 
                    'message'      => 'Username not found !!!',
                    
                ]
            );
        }else if(!Hash::check($data_request['password'], $user->password)){
            return response()->json(
                [
                    'status'    => false, 
                    'code'      => 2, 
                    'message'      => 'Password not correct !!!',
                    
                ]
            );
        }
        
        $tokenResponse = parent::issueToken($request);
        $token = $tokenResponse->getContent();
        $tokenInfo = json_decode($token, true);
        $tokenInfo = collect($tokenInfo);
        if($tokenInfo->has('error')){
            
            return response()->json([
                'status' => false,
                'error_code' => $tokenInfo['error'],
                'message'=> $tokenInfo['message']
            ],401);
        }

        $tokenInfo->put('user', $user);
        return response()->json(
                    [
                        'status'    => true, 
                        'data'      => $tokenInfo
                        
                    ]
                );
        
    }


    public function getAccessTokenByRefreshToken(ServerRequestInterface $request){
       
        
        $tokenResponse = parent::issueToken($request);
        $token = $tokenResponse->getContent();
        $tokenInfo = json_decode($token, true);
        $tokenInfo = collect($tokenInfo);
       
        if($tokenInfo->has('error')){
            
            return response()->json([
                'status' => false,
                'message' => $tokenInfo['message'],
                'error_code' => $tokenInfo['error']   
            ],401);
        }

        return response()->json(
                    [
                        'status'    => true, 
                        'data'      => $tokenInfo
                        
                    ]
        );
 
    }





}


?>