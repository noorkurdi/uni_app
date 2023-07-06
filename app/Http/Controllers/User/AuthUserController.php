<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{


    public function show(){  
        return auth('user')->user();
        // return auth('user')->user();   
    }
    public function update(UserRequest $request){
       
        auth('user')->user()->update($request->validated());
        return response()->json(['message'=>'updated successfully']);
    }
    public function store(UserRequest $request){
        $user=User::create($request->validated());
        $token=$user->createToken($request->uni_number)->plainTextToken;
        return response()->json(['token'=>$token,'isAdmin'=>false]);
    }
    public function login(Request $request){
        
        $user=User::where('uni_number',$request->uni_number)->first();
        if($user){
          
            
            if(!Hash::check($request->password,$user->password))
                return response()->json(['message'=>'uni-number or password not correct'],422); 
            return response()->json(['token'=>$user->createToken($request->uni_number)->plainTextToken,'isAdmin'=>false],200);
        }
        
        return response()->json(['message'=>'uni-number or password not correct'],422); 
    }
}
