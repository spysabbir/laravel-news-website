<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $advertisements = "";
            $query = Advertisement::select('advertisements.*');

            if($request->status){
                $query->where('advertisements.status', $request->status);
            }

            $advertisements = $query->get();

            return Datatables::of($advertisements)
                    ->addIndexColumn()
                    ->editColumn('advertisement_photo', function($row){
                        return '<img src="'.asset('uploads/advertisement_photo').'/'.$row->advertisement_photo.'" width="40" >';
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
                    ->rawColumns(['advertisement_photo', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.advertisement.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'advertisement_photo' => 'required|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->advertisement_position == 'Center Right'){
                $size  = "800, 500";
            }else{
                $size  = "728, 90";
            }
            // Advertisement Photo Upload
            $advertisement_photo_name =  Str::slug($request->advertisement_title)."advertisement-photo".".". $request->file('advertisement_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/advertisement_photo/").$advertisement_photo_name;
            Image::make($request->file('advertisement_photo'))->resize($size)->save($upload_link);

            Advertisement::insert([
                'advertisement_position' => $request->advertisement_position,
                'advertisement_title' => $request->advertisement_title,
                'advertisement_link' => $request->advertisement_link,
                'advertisement_photo' => $advertisement_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Advertisement create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $advertisement = Advertisement::where('id', $id)->first();
        return response()->json($advertisement);
    }

    public function update(Request $request, $id)
    {
        $advertisement = Advertisement::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'advertisement_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->advertisement_position == 'Center Right'){
                $size  = "800, 500";
            }else{
                $size  = "728, 90";
            }
            // Advertisement Photo Upload
            if($request->hasFile('advertisement_photo')){
                unlink(base_path("public/uploads/advertisement_photo/").$advertisement->advertisement_photo);
                $advertisement_photo_name =  $id."-advertisement-photo".".". $request->file('advertisement_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/advertisement_photo/").$advertisement_photo_name;
                Image::make($request->file('advertisement_photo'))->resize($size)->save($upload_link);
                $advertisement->update([
                    'advertisement_photo' => $advertisement_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $advertisement->update([
                'advertisement_position' => $request->advertisement_position,
                'advertisement_title' => $request->advertisement_title,
                'advertisement_link' => $request->advertisement_link,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Advertisement update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::where('id', $id)->first();
        $advertisement->updated_by = Auth::guard('admin')->user()->id;
        $advertisement->deleted_by = Auth::guard('admin')->user()->id;
        $advertisement->save();
        $advertisement->delete();
        return response()->json([
            'message' => 'Advertisement destroy successfully.'
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_advertisements = "";
            $query = Advertisement::onlyTrashed();
            $trashed_advertisements = $query->get();

            return Datatables::of($trashed_advertisements)
                    ->addIndexColumn()
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
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function restore($id)
    {
        Advertisement::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Advertisement::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Advertisement restore successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        unlink(base_path("public/uploads/advertisement_photo/").Advertisement::onlyTrashed()->where('id', $id)->first()->advertisement_photo);
        Advertisement::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Advertisement force delete successfully.'
        ]);
    }

    public function status($id)
    {
        $advertisement = Advertisement::where('id', $id)->first();
        if($advertisement->status == "Active"){
            $advertisement->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Advertisement status inactive.'
            ]);
        }else{
            $advertisement->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Advertisement status active.'
            ]);
        }
    }
}
