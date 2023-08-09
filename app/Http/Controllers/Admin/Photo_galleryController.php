<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo_gallery;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Photo_galleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $photo_galleries = "";
            if(Auth::guard('admin')->user()->role == "Manager"){
                $query = Photo_gallery::where('branch_id', Auth::guard('admin')->user()->branch_id)
                            ->select('photo_galleries.*');
            }else{
                $query = Photo_gallery::where('created_by', Auth::guard('admin')->user()->id)
                            ->select('photo_galleries.*');
            }

            if($request->status){
                $query->where('photo_galleries.status', $request->status);
            }

            $photo_galleries = $query->get();

            return Datatables::of($photo_galleries)
                    ->addIndexColumn()
                    ->editColumn('gallery_photo_name', function($row){
                        return '<img src="'.asset('uploads/photo_galleries').'/'.$row->gallery_photo_name.'" width="40" >';
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
                    ->rawColumns(['gallery_photo_name', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.photo_gallery.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'gallery_photo_name' => 'required|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Gallery Photo Upload
            $gallery_photo_name = "gallery-photo".Str::random(10).".". $request->file('gallery_photo_name')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/photo_galleries/").$gallery_photo_name;
            Image::make($request->file('gallery_photo_name'))->resize(1280, 853)->save($upload_link);

            Photo_gallery::insert([
                'branch_id' => Auth::guard('admin')->user()->branch_id,
                'gallery_photo_title' => $request->gallery_photo_title,
                'gallery_photo_name' => $gallery_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Gallery photo create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $photo_gallery = Photo_gallery::where('id', $id)->first();
        return response()->json($photo_gallery);
    }

    public function update(Request $request, $id)
    {
        $photo_gallery = Photo_gallery::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'gallery_photo_name' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Gallery Photo Upload
            if($request->hasFile('gallery_photo_name')){
                unlink(base_path("public/uploads/photo_galleries/").$photo_gallery->gallery_photo_name);
                $gallery_photo_name =  "gallery-photo".Str::random(10).".". $request->file('gallery_photo_name')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/photo_galleries/").$gallery_photo_name;
                Image::make($request->file('gallery_photo_name'))->resize(1280, 853)->save($upload_link);
                $photo_gallery->update([
                    'gallery_photo_name' => $gallery_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $photo_gallery->update([
                'branch_id' => Auth::guard('admin')->user()->branch_id,
                'gallery_photo_title' => $request->gallery_photo_title,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Gallery photo update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        $photo_gallery = Photo_gallery::where('id', $id)->first();
        $photo_gallery->updated_by = Auth::guard('admin')->user()->id;
        $photo_gallery->deleted_by = Auth::guard('admin')->user()->id;
        $photo_gallery->save();
        $photo_gallery->delete();
        return response()->json([
            'message' => 'Gallery photo destroy successfully.'
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_photo_galleries = "";
            $query = Photo_gallery::onlyTrashed();
            $trashed_photo_galleries = $query->get();

            return Datatables::of($trashed_photo_galleries)
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
        Photo_gallery::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Photo_gallery::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Gallery photo restore successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        unlink(base_path("public/uploads/photo_galleries/").Photo_gallery::onlyTrashed()->where('id', $id)->first()->gallery_photo_name);
        Photo_gallery::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Gallery photo force delete successfully.'
        ]);
    }

    public function status($id)
    {
        $photo_gallery = Photo_gallery::where('id', $id)->first();
        if($photo_gallery->status == "Active"){
            $photo_gallery->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Gallery photo status inactive.'
            ]);
        }else{
            $photo_gallery->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Gallery photo status active.'
            ]);
        }
    }
}
