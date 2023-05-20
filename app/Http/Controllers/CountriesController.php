<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SMSActivate;
use DataTables;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $SmsApi;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
       // $data = Countries::get();
       // return view('country.list',compact('data'));
        return view('country.country_page');
    }

     public function get_list_country(){
        $data = Countries::where('status',1)->get();
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
                        <a href="'.url('countries/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('countries/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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
      return view('country.add');
        
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
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
           // dd($input);
            $country = Countries::create([
                'status' => $input['status'],
                'title' => $input['title'],
                'ip' => $request->ip(),
                'created_by' => Auth::id(),
                'slug' => Str::slug($input['slug'])
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
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function show(Countries $countries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Countries::find($id);
        if($record)
        {
            return view('country.edit',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Countries $countries)
    {
       $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'title' => 'required | string ',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
           // dd($input);
            $country = Countries::find($request->id);
            $country->update([
                'status' => $input['status'],
                'title' => $input['title'],
                'ip' => $request->ip(),
                'created_by' => Auth::id(),
                'slug' => Str::slug($input['slug'])
            ]);
            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Countries::find($id);
        if ($country) {
            $country->delete();

            return redirect()->back()->with('success', 'Country removed!');
        } else {
            return redirect()->back()->with('error', 'Country not found');
        }
    }
}
