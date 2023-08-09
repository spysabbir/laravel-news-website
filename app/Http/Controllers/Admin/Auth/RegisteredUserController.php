<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'indisposable', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', Rules\Password::defaults()],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if ($request->role == 'Reporter' && $request->branch_id == NULL) {
                $validator = Validator::make($request->all(), [
                    'branch_id' => ['required'],
                ]);
                return response()->json([
                    'status' => 401,
                    'error'=> $validator->errors()->toArray()
                ]);
            } else {
                Admin::create([
                    'role' => $request->role,
                    'branch_id' => $request->branch_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'created_by' => Auth::guard('admin')->user()->id,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Administrator create successfully.'
                ]);
            }
        }
    }
}
