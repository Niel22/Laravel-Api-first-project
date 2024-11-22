<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function store(Request $request){

        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            return $validator->errors();
        }

        $data = $validator->validated();

        if(Auth::attempt($data)){

            $user = Auth::user();
            
            $token = $user->createToken('laravel-api-project')->plainTextToken;
            return response()->json([
                'user' => Auth::user(),
                'token' => $token
            ], 201);
        }else{
            return response()->json([
                'message' => "These credentials do not match our record"
            ], 404);
        }

    }

    public function create(Request $request){

        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8']
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            return $validator->errors();
        }

        $data = $validator->validated();

        $user = User::create($data);

        Auth::login($user);

        $token = $user->createToken('laravel-api-project')->plainTextToken;

        return response()->json([
            'user' => Auth::user(),
            'token' => $token
        ], 201);


    }
}
