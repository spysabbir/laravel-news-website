<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('status', 'Failed to authenticate with google');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'google_id' => $socialUser->getId(),
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => Carbon::now(),
            ]);
        }

        Auth::login($user, true);

        $loginUrl = Session::get('loginUrl');

        return redirect($loginUrl);
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('status', 'Failed to authenticate with facebook');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'facebook_id' => $socialUser->getId(),
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => Carbon::now(),
            ]);
        }

        Auth::login($user, true);

        $loginUrl = Session::get('loginUrl');

        return redirect($loginUrl);
    }

    public function dashboard()
    {
        $totalComment = Comment::where('user_id', Auth::user()->id)->get();
        return view('frontend.dashboard', compact('totalComment'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg',
            'phone_number' => 'nullable|digits:11',
        ]);

        User::find(Auth::user()->id)->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        if($request->hasFile('profile_photo')){
            if(Auth::user()->profile_photo != "default_profile_photo.png"){
                unlink(base_path("public/uploads/profile_photo/").Auth::user()->profile_photo);
            }
            $profile_photo_name =  "Customer-Profile-Photo-".Auth::user()->id.".". $request->file('profile_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/profile_photo/").$profile_photo_name;
            Image::make($request->file('profile_photo'))->resize(300,300)->save($upload_link);
            User::find(Auth::user()->id)->update([
                'profile_photo' => $profile_photo_name
            ]);
        }
        return back()->with('success', 'Profile Change Success.');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);
        if($request->current_password == $request->password){
            return back()->withErrors(['password_error' => 'New password can not same as old password']);
        }
        if(Hash::check($request->current_password, Auth::guard('admin')->user()->password)){
            User::find(Auth::user()->id)->update([
                'password' => Hash::make($request->password)
            ]);
            return back()->with('success', 'Password Change Success.');
        }else{
            return back()->withErrors(['password_error' => 'Your Old Password is Wrong!']);
        }
    }
}
