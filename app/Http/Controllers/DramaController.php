<?php

namespace App\Http\Controllers;

use App\Models\Drama;
use App\Models\Episodes;
use App\Models\Countries;
use App\Models\Genre;
use App\Models\Dramagenre;
use App\Models\Dramatags;
use App\Models\Dramaothername;
use App\Models\Tags;
use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class DramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // $data = Drama::where('status',1)->get();
        // return view('drama.list',compact("data"));

       return view('drama.drama_page');
         

    }


    public function get_drama_list()
    {     
         $data = Drama::where('status',1)->get(); 
             
         return Datatables::of($data)
                ->addColumn('image', function ($data) {
                    $img = $data->icon;
                    if ($img) {

                    return '<img  width="70px" height="50px" src="'.asset('storage/drama/'.$img).'">';
                    }

                    return '';
                })
                ->addColumn('drama_status_2', function ($data) {
                    $status = $data->drama_status;
                    return drama_status_name($status);
                })
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {

                       return '<div class="table-actions">
                        <a href="'.url('episode/list/'.$data['id']).'"><i class="fa fa-eye btn btn-info" data-toggle="tooltip" data-placement="top" title="View Episodes"></i></a>
                        <a href="'.url('episode/add/'.$data['id']).'"><i class="fa fa-plus btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add Episode"></i></a>
                        <a target="_blank" href="'.url('drama-detail/'.$data['slug']).'"><i class="ik ik-eye btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Drama"></i></a>    
                        <a href="'.url('drama/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('drama/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                        </div> ';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['drama_status_2','image','action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $genre = Genre::where('status',1)->get();
        $tags = Tags::where('status',1)->get();
        $data = Drama::get();

        return view('drama.add', compact(["data","genre","tags"]));
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
            'is_kshow' => 'required',
            'title' => 'required | string ',
            'slug' => 'required',
            'icon' => 'required',
            
        ]);
        
        //dd($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
            {
            $drama_img = '';
            if($request->file('icon'))
            {   
            $drama_img = file_upload($request,'icon','storage/drama/');
            }
            $drama = Drama::create([
                'country_id' => $input['country_id'],
                'title' => $input['title'],
                'sort'  => sort_drama($input['title']),
                'first_char' => $input['first_char'],
                'is_kshow' => $input['is_kshow'],
                'slug' => Str::slug($input['slug']),
                'description' => $input['description'],
                'icon' => $drama_img,
                'release_year' => $input['release_year'],
                'release_date' => $input['release_date'],
                'cast' => $input['cast'],
                'trailer_yt_url' => $input['trailer_yt_url'],
                'drama_status' => $input['drama_status'],
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'reff_url' => $input['reff_url'],
                'status' => $input['status'],
                'ip' => $request->ip(),
                'created_at' => now(),
                'created_by' => Auth::id()
            ]);

            $drama->id;

            if(count($input['genre'])>0)
            {   $genres = array();
                foreach ($input['genre'] as $key => $row) {
                    $inner = array();
                    $inner['drama_id'] = $drama->id;
                    $inner['name'] = $row;
                    $genres[] = $inner;
                }

                Dramagenre::insert($genres);
            }

            if(count($input['tags'])>0)
            {   $tags = array();
                foreach ($input['tags'] as $key => $row) {
                    $inner = array();
                    $inner['drama_id'] = $drama->id;
                    $inner['name'] = $row;
                    $tags[] = $inner;
                }

                Dramatags::insert($tags);
            }
              //  echo "<pre>";
              // print_r($input['other_names']);
              // die('herere');  
            $othername22 = explode(',', $input['other_names']);
            if(count($othername22)>0)
            {   $othername = array();
                foreach ($othername22 as $key => $row) {
                    $inner = array();
                    $inner['drama_id'] = $drama->id;
                    $inner['name'] = $row;
                    $othername[] = $inner;
                }

                Dramaothername::insert($othername);
            }

            return redirect()->back()->with('success', 'Drama Added Succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drama  $drama
     * @return \Illuminate\Http\Response
     */
    public function show(Drama $drama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drama  $drama
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = Tags::get();
       $genre = Genre::get();
       $record = Drama::with(['genre','tags','othername'])->find($id);
        if($record)
        {
            return view('drama.edit',compact("record","genre","tags"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drama  $drama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drama $drama)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'is_kshow' => 'required',
            'title' => 'required | string ',
            'slug' => 'required',
            'first_char' => 'required',
            
        ]);
        //dd($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
            {

            $drama = Drama::find($request->id);
            $drama_img = '';
            // echo "<pre>";
            // print_r($request->file('icon'));
            // die('sdshere');
            if($request->file('icon'))
            {   
                //die('here');
                file_delete('storage/drama/',$drama->icon);
                $drama_img = file_upload($request,'icon','storage/drama/');
            }
            $drama = Drama::find($request->id);

            $data = array(
                'country_id' => $input['country_id'],
                'title' => $input['title'],
                'first_char' => $input['first_char'],
                'is_kshow' => $input['is_kshow'],
                'slug' => Str::slug($input['slug']),
                'description' => $input['description'],
                'release_year' => $input['release_year'],
                'release_date' => $input['release_date'],
                'cast' => $input['cast'],
                'trailer_yt_url' => $input['trailer_yt_url'],
                'drama_status' => $input['drama_status'],
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'reff_url' => $input['reff_url'],
                'status' => $input['status'],
                'ip' => $request->ip(),
                'created_by' => Auth::id(),
                'updated_at' => now(),

            );

            if($drama_img != '')
            $data['icon'] = $drama_img;

            $drama->update($data);
            $drama->id;

            if(count($input['genre'])>0)
            {   $genres = array();
                foreach ($input['genre'] as $key => $row) {
                    $inner = array();
                    $inner['drama_id'] = $drama->id;
                    $inner['name'] = $row;
                    $genres[] = $inner;
                }

                if(count($genres)>0){
                    Dramagenre::where('drama_id', $drama->id)->delete();
                    Dramagenre::insert($genres);
                }
                
            }

            if(count($input['tags'])>0)
            {   $tags = array();
                foreach ($input['tags'] as $key => $row) {
                    $inner = array();
                    $inner['drama_id'] = $drama->id;
                    $inner['name'] = $row;
                    $tags[] = $inner;
                }
                Dramatags::where('drama_id', $drama->id)->delete();
                Dramatags::insert($tags);
            }
            
            $othername22 = explode(',', $input['other_names']);

            // print_r($othername22);
            // die('here');
            if(count($othername22)>0)
            {   $othername = array();
                foreach ($othername22 as $key => $row) {
                    $inner = array();
                    $inner['drama_id'] = $drama->id;
                    $inner['name'] = $row;
                    $othername[] = $inner;
                }
                Dramaothername::where('drama_id', $drama->id)->delete();
                Dramaothername::insert($othername);
            }
            return redirect()->back()->with('success', 'Drama updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drama  $drama
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drama = Drama::find($id);
        if ($drama) {

            Episodes::where('drama_id', $id)->delete();
            Dramaothername::where('drama_id', $id)->delete();
            Dramatags::where('drama_id', $id)->delete();
            Dramagenre::where('drama_id', $id)->delete();
            $drama->delete();

            return redirect()->back()->with('success', 'drama removed!');
        } else {
            return redirect()->back()->with('error', 'drama not found');
        }
    }


    public function fetch_episodes()
    {    
         $data = Episodes::where('fetch_status',0)->take(15)->get();
         if(count($data)>0)
         {
             $responsedata = fetch_episodes_from_url($data);
             return view('drama.episode',compact("responsedata"));

         }
         else
         {  
           
            return view('drama.episode')->with('error', 'All Episodes Fatch No More Episodes Found To Update!');
         }
    }

    public function fetch()
    {
         return view('drama.fetch');
    }

    public function fetch_drama(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'url' => 'required|url',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        $drama_url = $input['url'];
        $html = get_html_from_url($drama_url);


       

        //getproductdata($html);

        if($html)
        {   
            $drama_details = array();
            $title_and_url  = get_title_url($html);

            $duplicate = duplicate_Check($title_and_url['drama_title']);

            if($duplicate)
                return redirect()->back()->withInput()->with('error', 'Drama Already Added Try Other One!');
            if($title_and_url['drama_title'] != '')
            {   
                $drama_details['title_and_url']  = $title_and_url;
                $drama_details['drama_icon']     = get_icon_url($html);
                $drama_details['other_names']    = get_other_names($html);
                $drama_details['getinfo']        = get_info($html);
                $drama_details['drama_cast']     = get_drama_cast($html);
                $drama_details['get_tag']        = get_tag($html);
                $drama_details['drama_trailer']  = drama_trailer_yt($html);
                $drama_details['get_episodes']   = get_all_episode($drama_url,$html);

                ksort($drama_details['get_episodes']['drama_pisodes']);
                // echo "<pre>";
                // print_r($drama_details['get_episodes']);
                // die('herer');

                return view('drama.fetch',compact(['drama_details','drama_url']));
            }
            else
            {

            }
            
        }
    }


    public function save_drama(Request $request)
    {
           $input = $request->all();
           $data =  json_decode($input['drama_data'],true);
           if(!empty($data['title_and_url']))
           {    

                $drama['title'] = $data['title_and_url']['drama_title'];
                $drama['slug']  = $data['title_and_url']['drama_title_url'];
                $drama['sort']  = sort_drama($data['title_and_url']['drama_title']);

                if($drama['sort'] == 1)
                    $drama['first_char'] = '#';
                else
                $drama['first_char']  =  substr($drama['title'],0,1);
                $drama['reff_url']  = $input['reff_url'];
                
           }
           if($data['drama_icon']['status'])
           {        
                $filename = file_upload_from_url($data['drama_icon']['drama_icon'],'public/uploads/drama/');
                $drama['icon'] = $filename;
           }
           if($data['getinfo']['status'])
           {    
                if($data['getinfo']['drama_country']){
                    $country_id = get_country_id($data['getinfo']['drama_country']);
                    $drama['country_id'] = $country_id;
                }
                if($data['getinfo']['drama_status']){
                    $status = get_drama_status($data['getinfo']['drama_status']);
                    $drama['drama_status'] = $status;
                }

                if($data['getinfo']['drama_release_year']){
                    $drama['release_year'] = $data['getinfo']['drama_release_year'];
                }

                if(!$data['getinfo']['drama_release_date'] == "0000-00-00"){
                    $drama['release_date'] = $data['getinfo']['drama_release_date'];
                }

                if($data['getinfo']['drama_desc']){
                    $drama['description'] = $data['getinfo']['drama_desc'];
                } 


           }

           if($data['drama_cast']['status'])
           { 
                $drama['cast'] = $data['drama_cast']['drama_cast'];
           }

           if($data['drama_trailer']['status'])
           { 
                $drama['trailer_yt_url'] = $data['drama_trailer']['drama_trailer_yt_url'];
           }

            $drama['created_by'] = Auth::id();

            $drama['created_at'] = now();
            $drama['ip'] = $request->ip();
            try
            {   
               $drama_id = Drama::insertGetId($drama);

            if($drama_id)
            {   
                if($data['get_episodes']['status'])
                   {    
                        $episodes = array(); 
                        foreach ($data['get_episodes']['drama_pisodes'] as $key => $episode) {
                            $inner = array();
                            $inner['episodes_no'] = $key;
                            $inner['title'] = $episode['title'];
                            $inner['reff_url'] = $episode['url'];
                            $inner['slug'] = Str::slug($episode['title']);
                            $inner['type'] = $episode['type'] == 'SUB'? 1 : 0;
                            $inner['date'] = $episode['date'];
                            $inner['drama_id'] = $drama_id;
                            $inner['created_at'] = now();
                            $inner['updated_at'] = now();
                            $episodes[] = $inner;
                        } 
                        DB::table('episodes')->insert($episodes);
                   }
                 if($data['other_names']['status'])
                   {    $other_name = array(); 
                        foreach ($data['other_names']['other_names'] as $key => $name) {
                            $inner = array();
                            $inner['name'] = $name;
                            $inner['drama_id'] = $drama_id;
                            $other_name[] = $inner;
                        } 
                        DB::table('drama_other_name')->insert($other_name);
                   }
                   if(count($data['getinfo']['drama_genre'])>0)
                    {
                            $drama_genre = array(); 
                            foreach ($data['getinfo']['drama_genre'] as $key => $name) {
                            $inner = array();
                            $inner['name'] = $name;
                            $inner['drama_id'] = $drama_id;
                            $drama_genre[] = $inner;
                        } 
                        DB::table('drama_genre')->insert($drama_genre);
                    }
                    if(count($data['get_tag']['drama_tags'])>0)
                    {
                            $drama_tags = array(); 
                            foreach ($data['get_tag']['drama_tags'] as $key => $name) {
                            $inner = array();
                            $inner['name'] = $name;
                            $inner['drama_id'] = $drama_id;
                            $drama_tags[] = $inner;
                        } 
                        DB::table('drama_tags')->insert($drama_tags);
                    }


                return redirect()->back()->with('success', 'Drama insert succesfully!');
            }
            else
            {
                return redirect()->back()->with('error', 'Drama Not insert!');
            }


            } catch (\Exception $e) {
                $bug = $e->getMessage();

                return redirect()->back()->withInput()->with('error', $bug);
            }

            
    }
}
