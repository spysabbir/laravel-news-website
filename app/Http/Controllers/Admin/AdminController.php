<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        $all_news = News::count();
        $categories = Category::count();
        $tags = Tag::count();
        $all_reporter = Admin::where('role', 'Reporter')->count();
        $all_user = User::count();
        $reporter_wise_news = News::where('created_by', Auth::guard('admin')->user()->id)->count();
        return view('admin.dashboard', compact('all_news', 'categories', 'tags', 'all_reporter', 'all_user', 'reporter_wise_news'));
    }

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg',
            'phone_number' => 'nullable|digits:11',
        ]);

        Admin::find(Auth::guard('admin')->id())->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        if($request->hasFile('profile_photo')){
            if(Auth::guard('admin')->user()->profile_photo != "default_profile_photo.png"){
                unlink(base_path("public/uploads/profile_photo/").Auth::guard('admin')->user()->profile_photo);
            }
            $profile_photo_name =  "Admin-Profile-Photo-".Auth::guard('admin')->user()->id.".". $request->file('profile_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/profile_photo/").$profile_photo_name;
            Image::make($request->file('profile_photo'))->resize(300,300)->save($upload_link);
            Admin::find(Auth::guard('admin')->id())->update([
                'profile_photo' => $profile_photo_name
            ]);
        }
        $notification = array(
            'message' => 'Profile change successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
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
            Admin::find(Auth::guard('admin')->id())->update([
                'password' => Hash::make($request->password)
            ]);
            $notification = array(
                'message' => 'Password change successfully.',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }else{
            return back()->withErrors(['password_error' => 'Your Old Password is Wrong!']);
        }
    }

    public function allAdministrator (Request $request)
    {
        if ($request->ajax()) {
            $all_administrator = "";
            $query = Admin::where('role', '!=', 'Reporter')->select('admins.*');

            if($request->status){
                $query->where('admins.status', $request->status);
            }
            if($request->role){
                $query->where('admins.role', $request->role);
            }

            $all_administrator = $query->get();

            return Datatables::of($all_administrator)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Active"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm statusBtn"><i class="fa-solid fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm statusBtn"><i class="fa-solid fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('role', function($row){
                        if($row->role == "Admin"){
                            return'
                            <span class="badge bg-success">'.$row->role.'</span>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->role.'</span>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'status', 'role', 'action'])
                    ->make(true);
        }

        return view('admin.administrator.index');
    }

    public function administratoreEdit($id)
    {
        $administratore = Admin::where('id', $id)->first();
        return response()->json($administratore);
    }

    public function administratoreUpdate(Request $request, $id)
    {
        $administratore = Admin::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $administratore->update([
                'email' => $request->email,
                'role' => $request->role,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Administrator update successfully',
            ]);
        }
    }

    public function administratorStatus($id)
    {
        $administrator = Admin::where('id', $id)->first();
        if($administrator->status == "Active"){
            $administrator->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Administrator status inactive',
            ]);
        }else{
            $administrator->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Administrator status active',
            ]);
        }
    }

    public function allUser (Request $request)
    {
        if ($request->ajax()) {
            $all_user = "";
            $query = User::select('users.*');

            if($request->status){
                $query->where('users.status', $request->status);
            }

            $all_user = $query->get();

            return Datatables::of($all_user)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('last_active', function($row){
                        return'
                        <span class="badge bg-info">'.date('d-M,Y h:m:s A', strtotime($row->last_active)).'</span>
                        ';
                    })
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge bg-success">'.$row->created_at->format('d-M,Y h:m:s A').'</span>
                            ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Active"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm statusBtn"><i class="fa-solid fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm statusBtn"><i class="fa-solid fa-check"></i></button>
                            ';
                        }
                    })
                    ->rawColumns(['profile_photo', 'last_active', 'created_at', 'status'])
                    ->make(true);
        }
        return view('admin.user.index');
    }

    public function userStatus($id)
    {
        $user = User::where('id', $id)->first();
        if($user->status == "Active"){
            $user->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'User status active.'
            ]);
        }else{
            $user->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'User status active.'
            ]);
        }
    }

    public function allReporter (Request $request)
    {
        if ($request->ajax()) {
            $all_reporter = "";
            $query = Admin::where('role', 'Reporter');

            if($request->status){
                $query->where('admins.status', $request->status);
            }
            if($request->branch_id){
                $query->where('admins.branch_id', $request->branch_id);
            }

            $all_reporter = $query->select('admins.*')->get();

            return Datatables::of($all_reporter)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('branch_name', function($row){
                        return'
                        <span class="badge bg-success">'.Branch::find($row->branch_id)->branch_name.'</span>
                        ';
                    })
                    ->editColumn('last_active', function($row){
                        return'
                        <span class="badge bg-info">'.date('d-M,Y h:m:s A', strtotime($row->last_active)).'</span>
                        ';
                    })
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge bg-success">'.$row->created_at->format('d-M,Y h:m:s A').'</span>
                            ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Active"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm statusBtn"><i class="fa-solid fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm statusBtn"><i class="fa-solid fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'branch_name', 'last_active', 'created_at', 'status', 'action'])
                    ->make(true);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('admin.reporter.index', compact('branches'));
    }

    public function reporterEdit($id)
    {
        $reporter = Admin::where('id', $id)->first();
        return response()->json($reporter);
    }

    public function reporterUpdate(Request $request, $id)
    {
        $reporter = Admin::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $reporter->update([
                'email' => $request->email,
                'branch_id' => $request->branch_id,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Reporter update successfully',
            ]);
        }
    }

    public function reporterStatus($id)
    {
        $reporter = Admin::where('id', $id)->first();
        if($reporter->status == "Active"){
            $reporter->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Reporter status active.'
            ]);
        }else{
            $reporter->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Reporter status active.'
            ]);
        }
    }

}
