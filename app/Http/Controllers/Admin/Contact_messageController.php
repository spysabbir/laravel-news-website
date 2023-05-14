<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact_message;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Contact_messageController extends Controller
{
    public function allContactMessage(Request $request)
    {
        if ($request->ajax()) {
            $all_contact_message = "";
            $query = Contact_message::select('contact_messages.*');

            if($request->status){
                $query->where('contact_messages.status', $request->status);
            }

            if($request->created_at){
                $query->where('contact_messages.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $all_contact_message = $query->get();

            return Datatables::of($all_contact_message)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == "Read"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            ';
                        }
                    })
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm viewBtn" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'created_at', 'action'])
                    ->make(true);
        }
        return view('admin.contact_message.index');
    }

    public function contactMessageView($id)
    {
        Contact_message::where('id', $id)->update([
            'status' => 'Read',
        ]);
        $contact_message = Contact_message::where('id', $id)->first();
        return view('admin.contact_message.show', compact('contact_message'));
    }

    public function contactMessageDelete($id)
    {
        Contact_message::where('id', $id)->delete();
        return response()->json([
            'message' => 'Contact message delete successfully',
        ]);
    }
}
