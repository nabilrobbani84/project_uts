<?php

namespace App\Http\Controllers;
 use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //membuat fitur Register
    public function register(Request $request) {
        // menangkap inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        #Menginsert data ke table user
        $user = User::create($input);

        $data = [
            'message' => 'User is created successfully'
        ];

        // mengirim response json
        return response()->json($data, 200);

    }

    public function login(Request $request) {
        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::Where('email', $input['email'])->first();

        $isLoginSuccessfully = (
            $input[ 'email'] == $user ->email
            &&
            Hash::check($input['password'], $user->password)
        );

        // melakukan autentifikasi
        if (Auth::attempt($input)) {
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'login successfully',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
            
        } else {
            $data = [
                'message'=> 'username, or password is wrong'
            ];
            
            return response()->json($data, 401);
        }


    }
}
