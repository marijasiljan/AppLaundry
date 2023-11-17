<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'nullable',
            'status' => 'nullable',
            'role' => ['required', 'in:ADMIN,EMPLOYEE,BUSINESS,WORK_PLACE,ACCOUNTANT'],
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data!', 404);
        }
        try {

            $user = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'image' => $request->input('image'),
                'status' => $request->input('status'),
            ]);
            $user->save();


            return $this->ResponseSuccess($user, 'User created successfully!');
        }catch (\Exception $e){
            return $this->ResponseError($e->getTrace(),'Invalid data!', 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $token = $user->createToken('LoginToken')->plainTextToken;
            $user->token = $token;
            $user->save();


            return $this->ResponseSuccess( $user, '', 'User logged in successfully!', 200);
        }
        return $this->ResponseError(null, 'Invalid Credentials', 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $token = $user->createToken('LoginToken')->plainTextToken;
        $user->tokens()->delete();

        $user->token = $token;
        $user->save();

        return $this->ResponseSuccess(null, '', 'User logged out successfully!', 200);
    }
}
