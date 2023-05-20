<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Tags;
use App\Models\Moviegenre;
use App\Models\Movietags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DB;
use DataTables;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Movie::get();
        // return view('movies.list', compact('data'));

        return view('movies.movies_page');
    }


    public function get_movie_list($value='')
    {   
        $data = Movie::where('status',1)->get();
        return Datatables::of($data)
                ->addColumn('image', function ($data) {
                    $img = $data->icon;
                    if ($img) {

                    return '<img  width="70px" height="50px" src="'.asset('storage/drama/'.$img).'">';
                    }

                    return '';
                })
                ->addColumn('drama_status_2', function ($data) {
                    $status = $data->movie_status;
                    return drama_status_name($status);
                })
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {

                       return '<div class="table-actions">
                        <a target="_blank" href="'.url('movie-detail/'.$data['slug']).'"><i class="ik ik-eye btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Drama"></i></a>    
                        <a href="'.url('movies/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('movies/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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
        $data = Movie::get();
        return view('movies.add', compact("data","tags","genre"));
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
            'genre' => 'required',
            'tags' => 'required',
            'title' => 'required | string',
            'slug' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   $movies = '';
            if($request->file('icon'))
            {   
                $movies = file_upload($request,'icon','storage/drama/');
            }

           //dd($input);
            $movie = Movie::insertGetId([
                'status' => $input['status'],
                'title' => $input['title'],
                'country_id' => $input['country_id'],
                'slug' => Str::slug($input['slug']),
                'movie_sub' => $input['movie_sub'],
                'movie_status' => $input['movie_status'],
                'release_year' => $input['release_year'],
                'release_date' => $input['release_date'],
                'trailer_yt_url' => $input['trailer_yt_url'],
                'reff_url' => $input['reff_url'],
                'cast' => $input['cast'],
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'description' => $input['description'],
                'first_char' => $input['first_char'],
                'sort'  => sort_drama($input['title']),
                'reff_url_detail' => $input['reff_url_detail'],
                'movie_download_url' => $input['movie_download_url'],
                'ip' => $request->ip(),
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
                'icon' => $movies
            ]);
            //$movie->id;

            if(count($input['genre'])>0)
            {   $genres = array();
                foreach ($input['genre'] as $key => $row) {
                    $inner = array();
                    $inner['movie_id'] = $movie;
                    $inner['name'] = $row;
                    $genres[] = $inner;
                }

                Moviegenre::insert($genres);
            }

            if(count($input['tags'])>0)
            {   $tags = array();
                foreach ($input['tags'] as $key => $row) {
                    $inner = array();
                    $inner['movie_id'] = $movie;
                    $inner['name'] = $row;
                    $tags[] = $inner;
                }

                Movietags::insert($tags);
            }
            if(count($input['epiv_url'])>0 && !empty($input['epiv_url'][0]))
            {   
                $servervideo = array();
                for ($i=0; $i < count($input['serv_id']) ; $i++) { 
                        
                    $inner = array();
                    $inner['server_id'] = $input['serv_id'][$i];
                    $inner['video_url'] = $input['epiv_url'][$i];
                    $inner['movie_id'] = $movie;
                    $servervideo[] = $inner;
                }

                // echo "<pre>";
                // print_r($servervideo);
                // die();
                //dd($input['serv_id']);
                if(count($servervideo)>0)
                    DB::table('movies_videos')->insert($servervideo);
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
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genre = Genre::get();
        $tags = Tags:: get();
        $movie = Movie::with(['genre','tags','videos'])->find($id);

        // echo "<pre>";
        // print_r($movie);
        // die('herer');
        if($movie)
        {
            return view('movies.edit',compact("movie","tags","genre" ));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'title' => 'required | string',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            $movie = Movie::find($request->id);
            $movie_icon = '';
            if($request->file('icon'))
            {   
                file_delete('storage/drama/',$movie->icon);
                $movie_icon = file_upload($request,'icon','storage/drama/');
            }
            $movie = Movie::find($request->id);
           // dd($input);

            $data = array(
                'status' => $input['status'],
                'title' => $input['title'],
                'country_id' => $input['country_id'],
                'slug' => Str::slug($input['slug']),
                'movie_sub' => $input['movie_sub'],
                'movie_status' => $input['movie_status'],
                'release_year' => $input['release_year'],
                'release_date' => $input['release_date'],
                'trailer_yt_url' => $input['trailer_yt_url'],
                'reff_url' => $input['reff_url'],
                'cast' => $input['cast'],
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'description' => $input['description'],
                'first_char' => $input['first_char'],
                'reff_url_detail' => $input['reff_url_detail'],
                'movie_download_url' => $input['movie_download_url'],
                'ip' => $request->ip(),
                'updated_at'=>now(),
                'created_by' => Auth::id()
            );

            if($movie_icon != '')
            $data['icon'] = $movie_icon;
            $movie->update($data);
            $movie->id;

            if(count($input['genre'])>0)
            {   $genres = array();
                foreach ($input['genre'] as $key => $row) {
                    $inner = array();
                    $inner['movie_id'] = $movie->id;
                    $inner['name'] = $row;
                    $genres[] = $inner;
                }
                Moviegenre::where('movie_id', $movie->id)->delete();
                Moviegenre::insert($genres);
            }

            if(count($input['tags'])>0)
            {   $tags = array();
                foreach ($input['tags'] as $key => $row) {
                    $inner = array();
                    $inner['movie_id'] = $movie->id;
                    $inner['name'] = $row;
                    $tags[] = $inner;
                }
                Movietags::where('movie_id', $movie->id)->delete();
                Movietags::insert($tags);
            }
            if(count($input['epiv_url'])>0 && !empty($input['epiv_url'][0]))
            {   
                $servervideo = array();
                for ($i=0; $i < count($input['serv_id']) ; $i++) { 
                        
                    $inner = array();
                    $inner['server_id'] = $input['serv_id'][$i];
                    $inner['video_url'] = $input['epiv_url'][$i];
                    $inner['movie_id'] = $movie->id;
                    $servervideo[] = $inner;
                }

                // echo "<pre>";
                // print_r($servervideo);
                // die();
                //dd($input['serv_id']);
                if(count($servervideo)>0)
                    DB::table('movies_videos')->where('movie_id', $movie->id)->delete();
                    DB::table('movies_videos')->insert($servervideo);
            }

            return redirect()->back()->with('success', 'Movie information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if ($movie) {
            DB::table('movies_videos')->where('movie_id', $id)->delete();
            Movietags::where('movie_id', $id)->delete();
            Moviegenre::where('movie_id', $id)->delete();
            $movie->delete();

            return redirect()->back()->with('success', 'Movie removed!');
        } else {
            return redirect()->back()->with('error', 'Movie not found');
        }
    }

    public function list_video($id=null)
    {
        if(!$id)
       $data = Movie::get();
       else
       $data = Movie::where('id',$id)->get();
       return view('movies.list_video',compact("data"));
    }

    public function edit_video()
    {
       //  $data = Movie::get();
       // return view('movies.edit_video',compact('data'));
    }

    public function fetch_videos()
    {    
         $data = Movie::where('fetch_status',0)->where('movie_status' ,'!=',1)->take(15)->get();
         if(count($data)>0)
         {  
             $responsedata = fetch_videos_from_url($data);
          
             return view('drama.episode',compact("responsedata"));

         }
         else
         {  
           
            return view('drama.episode')->with('error', 'All Episodes Fatch No More Episodes Found To Update!');
         }
    }

    public function fetch()
    {
         return view('movies.fetch');
    }

    public function fetch_movie(Request $request)
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
        if($html)
        {   
            $drama_details = array();
            $title_and_url  = get_title_url($html);


            $duplicate = duplicate_Check_movie($title_and_url['drama_title']);

            if($duplicate)
                return redirect()->back()->withInput()->with('error', 'Movie Already Added Try Other One!');
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

                // echo "<pre>";
                // print_r($drama_details);
                // die('herer');

                return view('movies.fetch',compact(['drama_details','drama_url']));
            }
            else
            {

            }
            
        }
    }



    public function save_movie(Request $request)
    {   
        //die('here');
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
            //$filename = '16430161284906.png';
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
                    $drama['movie_status'] = $status;
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


           if($data['get_episodes']['status'])
            {   
                $url =  $data['get_episodes']['drama_pisodes'][1]['url'];
                $type = $data['get_episodes']['drama_pisodes'][1]['type'];
                $drama['reff_url_detail'] = $url;       
                $drama['movie_sub'] = $type == 'SUB'? 1 : 0;          
            }

            $drama['created_by'] = Auth::id();
            $drama['created_at'] = now();
            $drama['updated_at'] = now();
            $drama['ip'] = $request->ip();

            // echo "<pre>";
            // print_r($drama);
            // die();
            try
            {   
               $drama_id = Movie::insertGetId($drama);

            if($drama_id)
            {   
                
                 if($data['other_names']['status'])
                   {    $other_name = array(); 
                        foreach ($data['other_names']['other_names'] as $key => $name) {
                            $inner = array();
                            $inner['name'] = $name;
                            $inner['movie_id'] = $drama_id;
                            $other_name[] = $inner;
                        } 
                        DB::table('movie_other_name')->insert($other_name);
                   }
                   if(count($data['getinfo']['drama_genre'])>0)
                    {
                            $drama_genre = array(); 
                            foreach ($data['getinfo']['drama_genre'] as $key => $name) {
                            $inner = array();
                            $inner['name'] = $name;
                            $inner['movie_id'] = $drama_id;
                            $drama_genre[] = $inner;
                        } 
                        DB::table('movie_genre')->insert($drama_genre);
                    }
                    if(count($data['get_tag']['drama_tags'])>0)
                    {
                            $drama_tags = array(); 
                            foreach ($data['get_tag']['drama_tags'] as $key => $name) {
                            $inner = array();
                            $inner['name'] = $name;
                            $inner['movie_id'] = $drama_id;
                            $drama_tags[] = $inner;
                        } 
                        DB::table('movie_tags')->insert($drama_tags);
                    }


                return redirect()->back()->with('success', 'Movie insert succesfully!');
            }
            else
            {
                return redirect()->back()->with('error', 'Movie Not insert!');
            }


            } catch (\Exception $e) {
                $bug = $e->getMessage();

                return redirect()->back()->withInput()->with('error', $bug);
            }

            
    }
}
