<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video_gallery;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Video_galleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $video_galleries = "";
            $query = Video_gallery::select('video_galleries.*');

            if($request->status){
                $query->where('video_galleries.status', $request->status);
            }

            $video_galleries = $query->get();

            return Datatables::of($video_galleries)
                    ->addIndexColumn()
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
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.video_gallery.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{

            Video_gallery::insert([
                'gallery_video_title' => $request->gallery_video_title,
                'gallery_video_link' => $request->gallery_video_link,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Gallery video create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $video_gallery = Video_gallery::where('id', $id)->first();
        return response()->json($video_gallery);
    }

    public function update(Request $request, $id)
    {
        $video_gallery = Video_gallery::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $video_gallery->update([
                'gallery_video_title' => $request->gallery_video_title,
                'gallery_video_link' => $request->gallery_video_link,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Gallery video update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        $video_gallery = Video_gallery::where('id', $id)->first();
        $video_gallery->updated_by = Auth::guard('admin')->user()->id;
        $video_gallery->deleted_by = Auth::guard('admin')->user()->id;
        $video_gallery->save();
        $video_gallery->delete();
        return response()->json([
            'message' => 'Gallery video destroy successfully.'
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_video_galleries = "";
            $query = Video_gallery::onlyTrashed();
            $trashed_video_galleries = $query->get();

            return Datatables::of($trashed_video_galleries)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if(Auth::guard()->user()->role == 'Super Admin'){
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
        Video_gallery::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Video_gallery::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Gallery video restore successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        Video_gallery::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Gallery photo force delete successfully.'
        ]);
    }

    public function status($id)
    {
        $video_gallery = Video_gallery::where('id', $id)->first();
        if($video_gallery->status == "Active"){
            $video_gallery->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Gallery photo status inactive.'
            ]);
        }else{
            $video_gallery->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Gallery photo status active.'
            ]);
        }
    }
}
