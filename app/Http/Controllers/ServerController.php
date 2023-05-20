<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\Server;



class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
       //  $data = Server::get();
       // return view('servers.list',compact('data'));
        return view('servers.server_page');
    }

    public function get_server_list()
    {   
        $data = Server::where('status',1)->get();
        return Datatables::of($data)
                ->addColumn('status', function ($data) {
                    return $data->status==1?'Active':'Inactive';  
                })
                ->addColumn('image', function ($data) {
                    $img = $data->img;
                    if ($img) {

                    return '<img  width="70px" height="50px" src="'.asset('storage/servers/'.$img).'">';
                    }

                    return '';
                })
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {

                       return '<div class="table-actions">    
                        <a href="'.url('servers/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('servers/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                        </div> ';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['image','action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servers.add');
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
            'title' => 'required | string '
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            $filename = '';
            if($request->file('img'))
            {   
                $filename = file_upload($request,'img','storage/servers/');
            }
            
            //dd($filename);
            $servers = Server::create([
                'status' => $input['status'],
                'title' => $input['title'],
                'ip' => $request->ip(),
                'added_by' => Auth::id(),
                'img' => $filename
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
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Server::find($id);
        if($record)
        {
            return view('servers.edit',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
       $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'title' => 'required | string '
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            $servers = Server::find($request->id);
            $filename = '';
            if($request->file('img'))
            {   
                            file_delete('storage/servers/',$servers->img);
                $filename = file_upload($request,'img','storage/servers/');
            }
            $servers->update([
                'status' => $input['status'],
                'title' => $input['title'],
                'ip' => $request->ip(),
                'added_by' => Auth::id(),
                'img' => $filename
            ]);
            return redirect()->back()->with('success', 'Server information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Server::find($id);
        if ($server) {
            file_delete('uploads/servers/',$server->img);
            $server->delete();

            return redirect()->back()->with('success', 'Server removed!');
        } else {
            return redirect()->back()->with('error', 'Server not found');
        }
    }
}
