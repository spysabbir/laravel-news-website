<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = "";
            $query = Category::select('categories.*');

            if($request->status){
                $query->where('categories.status', $request->status);
            }

            $categories = $query->get();

            return Datatables::of($categories)
                    ->addIndexColumn()
                    ->editColumn('category_photo', function($row){
                        return '<img src="'.asset('uploads/category_photo').'/'.$row->category_photo.'" width="40" >';
                    })
                    ->editColumn('category_name_en', function($row){
                        return'
                        '.$row->translate('en')->category_name.'
                        ';
                    })
                    ->editColumn('category_name_bn', function($row){
                        return'
                        '.$row->translate('bn')->category_name.'
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
                    ->editColumn('show_home_screen', function($row){
                        if($row->show_home_screen == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->show_home_screen.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm showHomeScreenBtn"><i class="fa-solid fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->show_home_screen.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm showHomeScreenBtn"><i class="fa-solid fa-check"></i></button>
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
                    ->rawColumns(['category_photo', 'category_name_en', 'category_name_bn', 'status', 'show_home_screen', 'action'])
                    ->make(true);
        }

        return view('admin.category.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name_en' => 'required|unique:category_translations,category_name',
            'category_name_bn' => 'required|unique:category_translations,category_name',
            'category_photo' => 'required|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Category Photo Upload
            $category_photo_name =  "category-photo-".Str::random(5).".". $request->file('category_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/category_photo/").$category_photo_name;
            Image::make($request->file('category_photo'))->resize(150, 100)->save($upload_link);

            $category_data = [
                'category_photo' => $category_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
                'en' => [
                    'category_name' => $request->input('category_name_en'),
                    'category_slug' => Str::slug($request->category_name_en),
                ],
                'bn' => [
                    'category_name' => $request->input('category_name_bn'),
                    'category_slug' => Str::slug($request->category_name_bn),
                ],
            ];
            Category::create($category_data);

            return response()->json([
                'status' => 200,
                'message' => 'Category create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return response()->json([
            'category_id' => $category->id,
            'category_name_en' => $category->translate('en')->category_name,
            'category_name_bn' => $category->translate('bn')->category_name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'category_name_en' => 'required',
            'category_name_bn' => 'required',
            'category_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Category Photo Upload
            if($request->hasFile('category_photo')){
                unlink(base_path("public/uploads/category_photo/").$category->category_photo);
                $category_photo_name =  "category-photo-".Str::random(5).".". $request->file('category_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/category_photo/").$category_photo_name;
                Image::make($request->file('category_photo'))->resize(150, 100)->save($upload_link);
                $category->update([
                    'category_photo' => $category_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $category_data = [
                'updated_by' => Auth::guard('admin')->user()->id,
                'en' => [
                    'category_name' => $request->input('category_name_en'),
                    'category_slug' => Str::slug($request->category_name_en),
                ],
                'bn' => [
                    'category_name' => $request->input('category_name_bn'),
                    'category_slug' => Str::slug($request->category_name_bn),
                ],
            ];

            $category->update($category_data);

            return response()->json([
                'status' => 200,
                'message' => 'Category update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();
        $category->updated_by = Auth::guard('admin')->user()->id;
        $category->deleted_by = Auth::guard('admin')->user()->id;
        $category->save();
        $category->delete();
        return response()->json([
            'message' => 'Category destroy successfully.'
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_categories = "";
            $query = Category::onlyTrashed();
            $trashed_categories = $query->get();

            return Datatables::of($trashed_categories)
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
        Category::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Category::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Category restore successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        unlink(base_path("public/uploads/category_photo/").Category::onlyTrashed()->where('id', $id)->first()->category_photo);
        Category::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Category force delete successfully.'
        ]);
    }

    public function status($id)
    {
        $category = Category::where('id', $id)->first();
        if($category->status == "Active"){
            $category->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Category status inactive.'
            ]);
        }else{
            $category->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Category status active.'
            ]);
        }
    }

    public function showHomeScreen($id)
    {
        $category = Category::where('id', $id)->first();
        if($category->show_home_screen == "Yes"){
            $category->update([
                'show_home_screen' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Category show home screen yes.'
            ]);
        }else{
            $category->update([
                'show_home_screen' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Category show home screen no.'
            ]);
        }
    }
}
