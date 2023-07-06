<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function auth(Request $request){
     
        $admin=Admin::where('email',$request->email)->first();
        if($admin){

            if(!Hash::check($request->password,$admin->password))
                return response()->json(['message'=>'email or password not correct'],422); 
            return response()->json(['token'=>$admin->createToken($request->email)->plainTextToken,'isAdmin'=>true],200);
        }
        
        return response()->json(['message'=>'email or password not correct'],422); 
  
    }
}

