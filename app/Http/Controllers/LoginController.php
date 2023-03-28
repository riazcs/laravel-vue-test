<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $result['response'] = 'success';
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $result['response'] = 'error';
            $result['message'] = $validator->errors();
            return response()->json($result);
        }
        $password = sha1($request->password);
        $user = User::where(['email' => $request->email, 'password' => $password, 'type' => $request->type])->first();
        if ($user) {
            $token = sha1($request->email);
            $result = [
                'response' => 'success',
                'user' => $user,
                'token' => $token,
                'message' => 'Login successfully',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Login Failed!',
            ];
        }
        return response()->json($result);
    }
}
