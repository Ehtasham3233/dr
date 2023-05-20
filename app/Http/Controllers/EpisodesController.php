<?php

namespace App\Http\Controllers;

use App\Models\Episodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DB;
use DataTables;

class EpisodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
       // if(!$id)
       // $data = Episodes::get();
       // else
       // $data = Episodes::where('drama_id',$id)->get();
       // return view('drama.list_episode',compact("data")); 
         return view('drama.episode_page');
    }

    public function get_episode_list(Request $request, $id=null)
    {       

        $id =  $request->input('drama_id');
        if(!$id)
        $data = Episodes::get();
        else
        $data = Episodes::where('drama_id',$id)
        ->orderBy('episodes_no', 'DESC')    
        ->get();
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
                       <a target="_blank" href="'.url('video-watch/'.$data['slug']).'"><i class="ik ik-eye btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Drama"></i></a>    
                        <a href="'.url('episode/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('episode/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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
       return view('drama.add_episode');
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
            'drama_id' => 'required',
            'home_recent' => 'required',
            'home_kshow' => 'required',
            'episodes_no' => 'required',
            'type' => 'required',
            'reff_url' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            if(empty($input['download_url']))
            $downlaod_url = get_download_url($input['reff_url']);
            else
            $downlaod_url = $input['download_url'];
            
            //dd($downlaod_url);

            $createdid = Episodes::insertGetId([
                'status' => $input['status'],
                'drama_id' => $input['drama_id'],
                'title' => $input['title'],
                'slug' => Str::slug($input['slug']),
                'home_recent' => $input['home_recent'],
                'home_kshow' => $input['home_kshow'],
                'episodes_no' => $input['episodes_no'],
                'reff_url' => $input['reff_url'],
                'fetch_status' => 0,
                'type' => $input['type'],
                'date' => $input['date'],
                'download_url' => $downlaod_url,
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'description' => $input['description'],
                'ip' => $request->ip(),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::id()
            ]);

            //$createdid = 1;
            if(count($input['epiv_url'])>0 && !empty($input['epiv_url'][0]))
            {    
                $servervideo = array();
                for ($i=0; $i < count($input['serv_id']) ; $i++) { 
                        
                    $inner = array();
                    $inner['server_id'] = $input['serv_id'][$i];
                    $inner['video_url'] = $input['epiv_url'][$i];
                    $inner['episode_id'] = $createdid;
                    $servervideo[] = $inner;
                }

                // echo "<pre>";
                // print_r($servervideo);
                // die();
                //dd($input['serv_id']);
                if(count($servervideo)>0)
                    DB::table('episode_videos')->insert($servervideo);
            }

            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function show(Episodes $episodes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   

        $record = Episodes::with('videos','server')->find($id);
        if($record)
        {
            return view('drama.edit_episode',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Episodes $episodes)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'title' => 'required | string ',
            'slug' => 'required',
            'home_recent' => 'required',
            'home_kshow' => 'required',
            'episodes_no' => 'required',
            'type' => 'required',
            'download_url' => 'required',
            'reff_url' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
                $episodes = Episodes::find($request->id);
                //dd($episodes);
                $episodes->update([
                'status' => $input['status'],
                'title' => $input['title'],
                'slug' => Str::slug($input['slug']),
                'home_recent' => $input['home_recent'],
                'home_kshow' => $input['home_kshow'],
                'episodes_no' => $input['episodes_no'],
                'reff_url' => $input['reff_url'],
                'type' => $input['type'],
                'date' => $input['date'],
                'download_url' => $input['download_url'],
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'description' => $input['description'],
                'ip' => $request->ip(),
                'updated_at' => now(),
                'created_by' => Auth::id()
            ]);



            //$createdid = 1;
            if(count($input['epiv_url'])>0 && !empty($input['epiv_url'][0]))
            {   
                $servervideo = array();
                for ($i=0; $i < count($input['serv_id']) ; $i++) { 
                      
                    if($input['serv_id'])
                    {
                        $inner = array();
                        $inner['server_id'] = $input['serv_id'][$i];
                        $inner['video_url'] = $input['epiv_url'][$i];
                        $inner['episode_id'] = $request->id;
                        $servervideo[] = $inner;
                    } 
                    
                }

                // echo "<pre>";
                // print_r($servervideo);
                // die();
                //dd($input['serv_id']);
                if(count($servervideo)>0)

                DB::table('episode_videos')->where('episode_id', $request->id)->delete();
                DB::table('episode_videos')->insert($servervideo);
            }


            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episodes = Episodes::find($id);
        if ($episodes) {
            $episodes->delete();

            return redirect()->back()->with('success', 'Episode removed!');
        } else {
            return redirect()->back()->with('error', 'Episode not found');
        }
    }
}
