<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\Union;
use App\Models\News;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function newsReport(Request $request) {
        if ($request->ajax()) {

            $all_news = "";

            $query = News::leftJoin('admins', 'news.created_by', 'admins.id');

            if($request->status){
                $query->where('news.status', $request->status);
            }
            if($request->news_position){
                $query->where('news.news_position', $request->news_position);
            }
            if($request->branch_id){
                $query->where('news.branch_id', $request->branch_id);
            }
            if($request->country_id){
                $query->where('news.country_id', $request->country_id);
            }
            if($request->division_id){
                $query->where('news.division_id', $request->division_id);
            }
            if($request->district_id){
                $query->where('news.district_id', $request->district_id);
            }
            if($request->upazila_id){
                $query->where('news.upazila_id', $request->upazila_id);
            }
            if($request->union_id){
                $query->where('news.union_id', $request->union_id);
            }

            if($request->created_at_start){
                $query->whereDate('news.created_at', '>=', $request->created_at_start);
            }
            if($request->created_at_end){
                $query->whereDate('news.created_at', '<=', $request->created_at_end);
            }

            $all_news = $query->select('news.*', 'admins.name')->get();

            return Datatables::of($all_news)
                    ->addIndexColumn()
                    ->editColumn('news_thumbnail_photo', function($row){
                        return '<img src="'.asset('uploads/news_thumbnail_photo').'/'.$row->news_thumbnail_photo.'" width="40" >';
                    })
                    ->editColumn('comment_count', function($row){
                        return'
                            <span class="badge bg-info">'.Comment::where('news_id', $row->id)->count().'</span>
                        ';
                    })
                    ->editColumn('created_at', function($row){
                        if(!$row->updated_at){
                            return'
                            <span class="badge bg-success">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->updated_at->format('d-M-Y h:m:s A').'</span>
                            ';
                        }
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Active"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <a href="'.route('admin.news.show', $row->id).'" class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['news_thumbnail_photo', 'comment_count', 'created_at', 'status', 'action'])
                    ->make(true);
        }

        $all_branch = Branch::all();
        $all_country = Country::all();
        $all_division = Division::all();
        $all_district = District::all();
        $all_upazila = Upazila::all();
        $all_union = Union::all();
        return view('admin.report.news', compact('all_branch', 'all_country', 'all_division', 'all_district', 'all_upazila', 'all_union'));
    }
}
