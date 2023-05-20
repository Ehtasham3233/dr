<?php

namespace App\Http\Controllers;

use App\Models\contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //  $data = contactus::get();
       // return view('view_msg.list', compact('data'));
        return view('view_msg.list_msg');
    }

    public function get_msg_list()
    {
         $data = contactus::get();
        return Datatables::of($data)
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {


                       return '<button type="button" onclick="showmesg('.$data->body.');" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalLong">View Massage</button>';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            //dd($input);
            $contact = contactus::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'subject' => $input['subject'],
                'body' => $input['body'],
                'ip' => $request->ip()
            ]);
            return redirect()->back()->with('success', 'Your massages updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function show(contactus $contactus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function edit(contactus $contactus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contactus $contactus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function destroy(contactus $contactus)
    {
        //
    }
}
