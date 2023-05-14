<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tags = "";
            $query = Tag::select('tags.*');

            if($request->status){
                $query->where('tags.status', $request->status);
            }

            $tags = $query->get();

            return Datatables::of($tags)
                    ->addIndexColumn()
                    ->editColumn('tag_name_en', function($row){
                        return'
                        '.$row->translate('en')->tag_name.'
                        ';
                    })
                    ->editColumn('tag_name_bn', function($row){
                        return'
                        '.$row->translate('bn')->tag_name.'
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
                    ->rawColumns(['tag_name_en', 'tag_name_bn', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.tag.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_name_en' => 'required|unique:tag_translations,tag_name',
            'tag_name_bn' => 'required|unique:tag_translations,tag_name',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $tag_data = [
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
                'en' => [
                    'tag_name' => $request->input('tag_name_en'),
                    'tag_slug' => Str::slug($request->tag_name_en),
                ],
                'bn' => [
                    'tag_name' => $request->input('tag_name_bn'),
                    'tag_slug' => Str::slug($request->tag_name_bn),
                ],
            ];
            Tag::create($tag_data);

            return response()->json([
                'status' => 200,
                'message' => 'Tag create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $tag = Tag::where('id', $id)->first();
        return response()->json([
            'tag_id' => $tag->id,
            'tag_name_en' => $tag->translate('en')->tag_name,
            'tag_name_bn' => $tag->translate('bn')->tag_name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'tag_name_en' => 'required',
            'tag_name_bn' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $tag_data = [
                'updated_by' => Auth::guard('admin')->user()->id,
                'en' => [
                    'tag_name' => $request->input('tag_name_en'),
                    'tag_slug' => Str::slug($request->tag_name_en),
                ],
                'bn' => [
                    'tag_name' => $request->input('tag_name_bn'),
                    'tag_slug' => Str::slug($request->tag_name_bn),
                ],
            ];
            $tag->update($tag_data);

            return response()->json([
                'status' => 200,
                'message' => 'Tag update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        $tag = Tag::where('id', $id)->first();
        $tag->updated_by = Auth::guard('admin')->user()->id;
        $tag->deleted_by = Auth::guard('admin')->user()->id;
        $tag->save();
        $tag->delete();
        return response()->json([
            'message' => 'Tag destroy successfully.'
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_tags = "";
            $query = Tag::onlyTrashed();
            $trashed_tags = $query->get();

            return Datatables::of($trashed_tags)
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
        Tag::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Tag::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Tag restore successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        Tag::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Tag destroy successfully.'
        ]);
    }

    public function status($id)
    {
        $tag = Tag::where('id', $id)->first();
        if($tag->status == "Active"){
            $tag->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Tag status inactive.'
            ]);
        }else{
            $tag->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Tag status active.'
            ]);
        }
    }
}
