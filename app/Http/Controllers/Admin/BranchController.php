<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $branches = "";
            $query = Branch::select('branches.*');

            if($request->status){
                $query->where('branches.status', $request->status);
            }

            $branches = $query->get();

            return Datatables::of($branches)
                    ->addIndexColumn()
                    ->editColumn('branch_photo', function($row){
                        return '<img src="'.asset('uploads/branch_photo').'/'.$row->branch_photo.'" width="40" >';
                    })
                    ->editColumn('branch_name_en', function($row){
                        return'
                        '.$row->translate('en')->branch_name.'
                        ';
                    })
                    ->editColumn('branch_name_bn', function($row){
                        return'
                        '.$row->translate('bn')->branch_name.'
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
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['branch_photo', 'branch_name_en', 'branch_name_bn', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.branch.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'branch_name_en' => 'required|unique:branch_translations,branch_name',
            'branch_name_bn' => 'required|unique:branch_translations,branch_name',
            'branch_photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Branch Photo Upload
            $branch_photo_name =  "branch-photo-".Str::random(5).".". $request->file('branch_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/branch_photo/").$branch_photo_name;
            Image::make($request->file('branch_photo'))->resize(150, 100)->save($upload_link);

            $branch_data = [
                'branch_photo' => $branch_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
                'en' => [
                    'branch_name' => $request->input('branch_name_en'),
                    'branch_phone_number' => $request->input('branch_phone_number_en'),
                    'branch_email' => $request->input('branch_email_en'),
                    'branch_address' => $request->input('branch_address_en'),
                ],
                'bn' => [
                    'branch_name' => $request->input('branch_name_bn'),
                    'branch_phone_number' => $request->input('branch_phone_number_bn'),
                    'branch_email' => $request->input('branch_email_bn'),
                    'branch_address' => $request->input('branch_address_bn'),
                ],
            ];
            Branch::create($branch_data);

            return response()->json([
                'status' => 200,
                'message' => 'Branch create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $branch = Branch::where('id', $id)->first();
        return response()->json([
            'branch_id' => $branch->id,
            'branch_name_en' => $branch->translate('en')->branch_name,
            'branch_name_bn' => $branch->translate('bn')->branch_name,
            'branch_phone_number_en' => $branch->translate('en')->branch_phone_number,
            'branch_phone_number_bn' => $branch->translate('bn')->branch_phone_number,
            'branch_email_en' => $branch->translate('en')->branch_email,
            'branch_email_bn' => $branch->translate('bn')->branch_email,
            'branch_address_en' => $branch->translate('en')->branch_address,
            'branch_address_bn' => $branch->translate('bn')->branch_address,
        ]);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'branch_name_en' => 'required',
            'branch_name_bn' => 'required',
            'branch_photo' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Branch Photo Upload
            if($request->hasFile('branch_photo')){
                unlink(base_path("public/uploads/branch_photo/").$branch->branch_photo);
                $branch_photo_name =  "branch-photo-".Str::random(5).".". $request->file('branch_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/branch_photo/").$branch_photo_name;
                Image::make($request->file('branch_photo'))->resize(150, 100)->save($upload_link);
                $branch->update([
                    'branch_photo' => $branch_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $branch_data = [
                'updated_by' => Auth::guard('admin')->user()->id,
                'en' => [
                    'branch_name' => $request->input('branch_name_en'),
                    'branch_phone_number' => $request->input('branch_phone_number_en'),
                    'branch_email' => $request->input('branch_email_en'),
                    'branch_address' => $request->input('branch_address_en'),
                ],
                'bn' => [
                    'branch_name' => $request->input('branch_name_bn'),
                    'branch_phone_number' => $request->input('branch_phone_number_bn'),
                    'branch_email' => $request->input('branch_email_bn'),
                    'branch_address' => $request->input('branch_address_bn'),
                ],
            ];

            $branch->update($branch_data);

            return response()->json([
                'status' => 200,
                'message' => 'Branch update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        $branch = Branch::where('id', $id)->first();
        $branch->updated_by = Auth::guard('admin')->user()->id;
        $branch->deleted_by = Auth::guard('admin')->user()->id;
        $branch->save();
        $branch->delete();
        return response()->json([
            'message' => 'Branch destroy successfully.'
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_branches = "";
            $query = Branch::onlyTrashed();
            $trashed_branches = $query->get();

            return Datatables::of($trashed_branches)
                    ->addIndexColumn()
                    ->editColumn('branch_name_en', function($row){
                        return'
                        '.$row->translate('en')->branch_name.'
                        ';
                    })
                    ->editColumn('branch_name_bn', function($row){
                        return'
                        '.$row->translate('bn')->branch_name.'
                        ';
                    })
                    ->addColumn('action', function($row){
                        if(Auth::guard('admin')->user()->role == 'Super Admin'){
                            $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm restoreBtn"><i class="fa-solid fa-rotate"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm forceDeleteBtn"><i class="fa-solid fa-delete-left"></i></button>
                            ';
                            return $btn;
                        }else{
                            $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm restoreBtn"><i class="fa-solid fa-rotate"></i></button>
                            ';
                            return $btn;
                        }
                    })
                    ->rawColumns(['branch_name_en', 'branch_name_bn', 'action'])
                    ->make(true);
        }
    }

    public function restore($id)
    {
        Branch::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Branch::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Branch restore successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        unlink(base_path("public/uploads/branch_photo/").Branch::onlyTrashed()->where('id', $id)->first()->branch_photo);
        Branch::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Branch force delete successfully.'
        ]);
    }

    public function status($id)
    {
        $branch = Branch::where('id', $id)->first();
        if($branch->status == "Active"){
            $branch->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Branch status inactive.'
            ]);
        }else{
            $branch->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Branch status active.'
            ]);
        }
    }

    public function showHomeScreen($id)
    {
        $branch = Branch::where('id', $id)->first();
        if($branch->show_home_screen == "Yes"){
            $branch->update([
                'show_home_screen' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Branch show home screen yes.'
            ]);
        }else{
            $branch->update([
                'show_home_screen' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Branch show home screen no.'
            ]);
        }
    }
}
