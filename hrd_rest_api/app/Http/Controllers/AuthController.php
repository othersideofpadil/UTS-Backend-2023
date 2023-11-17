<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // membuat fitur register
    public function register(Request $request){
        // menangkap inputan
        $input = [
            'name'=> $request->nama,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ];

        // menginsert data ke table user
        $user = User::create($input);

        $data = [
            'message' =>'User is created successfully'
        ];

        // mengirim respon json
        return response()->json($data, 200);
    }

    // membuat fitur login
    public function login(Request $request){
        $input = [
            'email'=> $request->email,
            'password'=>$request->password,
        ];
        // membuat data user
        $user = User::where('email', $input['email'])->first();

        // membandingkan input user dengan data user 
        $isLoginSuccessfully = (
            $input['email'] == $user->email 
            && 
            Hash::check($input['password'], $user->password)
        );

        if($isLoginSuccessfully){
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken
            ];

            // mengembalikan response json
            return response()->json($data, 200);
        }
        else{
            $data = [
                'message' =>'Username or Password is wrong'
            ];

            return response()->json($data, 401);
        }
    }
}
