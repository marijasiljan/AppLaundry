<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends BaseController
{
    public function index(){

    $users = User::whereStatus(1)->with('business')->paginate(10);

        return $this->ResponseSuccess(UserResource::collection($users)->response()->getData(true));
    }

    public function getAdmin() {

        $users = User::whereRole('ADMIN')->with('business')->paginate(10);

        return $this->ResponseSuccess(UserResource::collection($users)->response()->getData(true));
    }

    public function getEmployee() {

        $users = User::whereRole('EMPLOYEE')->with('business')->paginate(10);

        return $this->ResponseSuccess(UserResource::collection($users)->response()->getData(true));
    }

    public function getBusiness() {

        $users = User::whereRole('BUSINESS')->with('business')->paginate(10);

        return $this->ResponseSuccess(UserResource::collection($users)->response()->getData(true));
    }

    public function getWorkPlace() {

        $users = User::whereRole('WORK_PLACE')->with('business')->paginate(10);

        return $this->ResponseSuccess(UserResource::collection($users)->response()->getData(true));
    }

    public function getAccountant() {

        $users = User::whereRole('ACCOUNTANT')->with('business')->paginate(10);

        return $this->ResponseSuccess(UserResource::collection($users)->response()->getData(true));
    }

    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => '',
            'phone' => 'nullable',
            'address' => 'nullable',
            'role' => ['required', 'in:ADMIN,EMPLOYEE,BUSINESS,WORK_PLACE,ACCOUNTANT'],
            'image' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        if($request->input('id')){
            $user = User::find($request->input('id'));
        }else{
            $user = new User();
            $user->email = $request->input('email');
        }

        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->role = $request->input('role');
        $user->image = $request->input('image');
        $user->status = $request->input('status');

        $user->save();

        return $this->ResponseSuccess(new UserResource($user), '', 'User created successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->ResponseSuccess(new UserResource($user), '', 'User deleted successfully!');
    }

    public function restore($id){
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return $this->ResponseSuccess(new UserResource($user), '', 'User restored successfully!');
    }
}
