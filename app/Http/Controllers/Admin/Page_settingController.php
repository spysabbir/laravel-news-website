<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use App\Models\AboutUs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Page_settingController extends Controller
{
    public function index(){
        $all_pags = PageSetting::all();
        return view('admin.setting.page', compact('all_pags'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $page_setting_data = [
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
                'en' => [
                    'page_name' => $request->input('page_name_en'),
                    'page_slug' => Str::slug($request->page_name_en),
                    'page_description' => $request->input('page_description_en'),
                ],
                'bn' => [
                    'page_name' => $request->input('page_name_bn'),
                    'page_slug' => Str::slug($request->page_name_bn),
                    'page_description' => $request->input('page_description_bn'),
                ],
            ];
            PageSetting::create($page_setting_data);

            return response()->json([
                'status' => 200,
                'message' => 'Page create successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $page_setting = PageSetting::where('id', $id)->first();
        return response()->json([
            'page_id' => $page_setting->id,
            'page_name_en' => $page_setting->translate('en')->page_name,
            'page_description_en' => $page_setting->translate('en')->page_description,
            'page_name_bn' => $page_setting->translate('bn')->page_name,
            'page_description_bn' => $page_setting->translate('bn')->page_description,
        ]);
    }

    public function update(Request $request, $id){
        $page_setting = PageSetting::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{

            $page_setting_data = [
                'updated_by' => Auth::guard('admin')->user()->id,
                'en' => [
                    'page_name' => $request->input('page_name_en'),
                    'page_slug' => Str::slug($request->page_name_en),
                    'page_description' => $request->input('page_description_en'),
                ],
                'bn' => [
                    'page_name' => $request->input('page_name_bn'),
                    'page_slug' => Str::slug($request->page_name_bn),
                    'page_description' => $request->input('page_description_bn'),
                ],
            ];

            $page_setting->update($page_setting_data);

            return response()->json([
                'status' => 200,
                'message' => 'Page update successfully.'
            ]);
        }
    }

    public function destroy($id)
    {
        PageSetting::where('id', $id)->delete();
        return response()->json([
            'message' => 'Page destroy successfully.'
        ]);
    }

    public function status($id)
    {
        $page_setting = PageSetting::where('id', $id)->first();
        if($page_setting->status == "Active"){
            $page_setting->update([
                'status' => "Inactive",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
        }else{
            $page_setting->update([
                'status' =>"Active",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
        }

        $notification = array(
            'message' => 'Page status updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function aboutUs (){
        $about_us = AboutUs::first();
        return view('admin.about_us.index', compact('about_us'));
    }

    public function aboutUsUpdate (Request $request, $id){

        $about_us = AboutUs::where('id', $id)->first();

        $request->validate([
            '*' => 'required',
        ]);

        $about_us_data = [
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
            'en' => [
                'short_description' => $request->short_description_en,
                'long_description' => $request->long_description_en,
                'our_vision' => $request->our_vision_en,
                'our_mission' => $request->our_mission_en,
            ],
            'bn' => [
                'short_description' => $request->short_description_bn,
                'long_description' => $request->long_description_bn,
                'our_vision' => $request->our_vision_bn,
                'our_mission' => $request->our_mission_bn,
            ],
        ];

        $about_us->update($about_us_data);

        $notification = array(
            'message' => 'About us details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

}
