<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //  $data = Publisher::get();
       // return view('publisher.list', compact('data'));
        return view('publisher.publisher_page');
    }
    public function get_publisher_list()
    {
       $data = Publisher::where('status',1)->get();
        return Datatables::of($data)
               ->addColumn('status', function ($data) {
                    return $data->status==1?'Active':'Inactive';  
                })
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }

                    if (Auth::user()->can('manage_user')) {

                       return '<div class="table-actions">   
                        <a href="'.url('publisher/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('publisher/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                        </div> ';
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
        return view('publisher.add');
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
            'status' => 'required',
            'title' => 'required | string ',
            'main_heading' => 'required | string ',
            'meta_title' => 'required | string ',
            'meta_keywords' => 'required | string ',
            'meta_description' => 'required | string ',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
           // dd($input);
            $publisher = Publisher::create([
                'status' => $input['status'],
                'title' => $input['title'],
                'main_heading' => $input['main_heading'],
                'meta_title' => $input['meta_title'],
                'meta_keywords' => $input['meta_keywords'],
                'meta_description' => $input['meta_description'],
                'slug' => Str::slug($input['slug']),
                'ip' => $request->ip(),
                'created_by' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Publisher::find($id);
        if($record)
        {
            return view('publisher.edit',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'title' => 'required | string ',
            'main_heading' => 'required | string ',
            'meta_title' => 'required | string ',
            'meta_keywords' => 'required | string ',
            'meta_description' => 'required | string ',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
           // dd($input);
            $publisher = Publisher::find($request->id);
            $publisher->update([
                'status' => $input['status'],
                'title' => $input['title'],
                'main_heading' => $input['main_heading'],
                'meta_title' => $input['meta_title'],
                'meta_keywords' => $input['meta_keywords'],
                'meta_description' => $input['meta_description'],
                'slug' => Str::slug($input['slug']),
                'ip' => $request->ip(),
                'created_by' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'Publisher information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publisher = Publisher::find($id);
        if ($publisher) {
            $publisher->delete();

            return redirect()->back()->with('success', 'Publisher removed!');
        } else {
            return redirect()->back()->with('error', 'Publisher not found');
        }
    }
}
