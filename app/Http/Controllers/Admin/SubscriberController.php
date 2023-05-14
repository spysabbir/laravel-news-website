<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubscriberExport;
use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
    public function allSubscriber (Request $request)
    {
        if ($request->ajax()) {
            $all_subscriber = "";
            $query = Subscriber::select('subscribers.*');

            if($request->status){
                $query->where('subscribers.status', $request->status);
            }

            if($request->created_at){
                $query->where('subscribers.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $all_subscriber = $query->get();

            return Datatables::of($all_subscriber)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
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
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'status', 'action'])
                    ->make(true);
        }
        return view('admin.subscriber.index');
    }

    public function subscriberDelete($id)
    {
        Subscriber::where('id', $id)->delete();
        return response()->json([
            'message' => 'Subscriber delete successfully',
        ]);
    }

    public function subscriberStatus($id)
    {
        $subscriber = Subscriber::where('id', $id)->first();
        if($subscriber->status == "Active"){
            $subscriber->update([
                'status' => "Inactive",
            ]);
            return response()->json([
                'message' => 'Subscriber status inactive',
            ]);
        }else{
            $subscriber->update([
                'status' =>"Active",
            ]);
            return response()->json([
                'message' => 'Subscriber status active',
            ]);
        }
    }

    public function subscriberExport()
    {
        return Excel::download(new SubscriberExport, 'all-subscriber.xlsx');
    }

    public function allNewsletter(Request $request){
        if ($request->ajax()) {
            $newsletters = "";
            $query = Newsletter::select('newsletters.*');

            $newsletters = $query->get();

            return Datatables::of($newsletters)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm viewNewsletterModelBtn" data-bs-toggle="modal" data-bs-target="#viewNewsletterModel">
                        <i class="fa fa-eye"></i>
                        </button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'action'])
                    ->make(true);
        }

        return view('admin.subscriber.newsletter');
    }

    public function sendNewsletter(Request $request)
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
            $newsletter_id = Newsletter::insertGetId([
                'newsletter_subject' => $request->newsletter_subject,
                'newsletter_body' => $request->newsletter_body,
                'created_at' => Carbon::now(),
            ]);

            $newsletter = Newsletter::find($newsletter_id);
            foreach(Subscriber::where('status', 'Active')->get() as $subscriber){
                Mail::to($subscriber->subscriber_email)
                ->send(new NewsletterMail($newsletter));
            }

            return response()->json([
                'status' => 200,
                'message' => 'Newsletter send successfully',
            ]);
        }
    }

    public function viewNewsletter($id)
    {
        $newsletter = Newsletter::where('id', $id)->first();
        return view('admin.subscriber.newsletter-details', compact('newsletter'));
    }
}
