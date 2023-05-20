<?php

namespace App\Http\Controllers;

use App\Models\Drama;
use App\Models\Countries;
use App\Models\Episodes;
use App\Models\Dramagenre;
use App\Models\Dramatags;
use App\Models\CmsPages;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Torann\LaravelMetaTags\Facades\MetaTag;

class FrontendController extends Controller
{

	public function index()
	{	

		// \DB::connection()->enableQueryLog();	


		// $chats = Message::with('sender','recipient')
		// ->where('toId',$id)
		// ->whereRaw('id IN (select MAX(id) FROM episodes GROUP BY drama_id)')
		// ->orderBy('createdAt','desc')
		// ->paginate(10)



		$episode = Episodes::with(['drama'])->where(['fetch_status' => 1])

		->whereRaw('updated_at IN (select MAX(updated_at) FROM episodes  GROUP BY drama_id)')
		->groupBy('drama_id')
		->orderBy('updated_at', 'DESC')
		->take(28)
		->get();

		// $queries = \DB::getQueryLog();
		// dd($queries);

		$kshow_drama = Episodes::with(['drama'])->whereHas('drama', function($q) {
    $q->where('is_kshow', 1);
		})

		->whereRaw('updated_at IN (select MAX(updated_at) FROM episodes  GROUP BY drama_id)')
		->groupBy('drama_id')
		->orderBy('updated_at', 'DESC')
		->take(28)->get();

		$videos = Movie::where(['fetch_status' => 1])->take(28)
		->orderBy('updated_at', 'DESC')
		->get();

		$popular = Drama::where(['status'=> 1])
			->orderBy('views', 'DESC')
			->orderBy('release_year', 'DESC')
			 ->take(20)
			 ->get();

		$sidebar = getsidebardata();
			$meta =	getmetadata(20);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);

		return view('frontend.home', compact(["episode","videos","kshow_drama","sidebar","popular"]));

	}

	public function drama_by_genre($genre)
	{			
				$dramas;
				$genries = Dramagenre::select("drama_id")->where('name',$genre)->get();
				$ids = array();
				foreach ($genries as $key => $row) 
				$ids[] = 	$row->drama_id;
				if(count($ids)>0)
				$dramas  = Drama::whereIn('id', $ids)->paginate(20);
				$sidebar = getsidebardata();
				//$meta =	getmetadata(20,true,$genre);
				$meta =	getmetadata(6,true,$genre);
				// Meta Tags
				MetaTag::set('title', $meta->meta_title);
				MetaTag::set('description', strip_tags($meta->meta_desc));
				MetaTag::set('keywords', $meta->meta_kwd);
				return view('frontend.drama_episode',compact("dramas","sidebar"));
	}

	public function drama_by_tags($tag)
	{			
				$dramas;
				$tags = Dramatags::select("drama_id")->where('name',$tag)->get();
				$ids = array();
				foreach ($tags as $key => $row) 
				$ids[] = 	$row->drama_id;
				if(count($ids)>0)
				$dramas  = Drama::whereIn('id', $ids)->paginate(20);
				$sidebar = getsidebardata();
				$meta =	getmetadata(7,true,$tag);
				// Meta Tags
				MetaTag::set('title', $meta->meta_title);
				MetaTag::set('description', strip_tags($meta->meta_desc));
				MetaTag::set('keywords', $meta->meta_kwd);
				return view('frontend.drama_episode',compact("dramas","sidebar"));
	}
	public function drama_list($order= null)
	{	

		 		$kshow = \Request::segment(1);
        
        $query = ['status' => 1];
        if($kshow == 'kshow')
        {
            $query = ['status' => 1, 'is_kshow' => 1];
    
        }
        else
        {
            $query = ['status' => 1]; 
        }


		$sidebar = getsidebardata();
		
		

		if($order)
		{
			$sort_data = explode('-', $order);
			if(count($sort_data)>0)
				 $order = $sort_data[count($sort_data)-1];
			$sort_by = sort_drama('',$order);
			$dramas = Drama::where(['status'=> 1,'sort' => $sort_by])->paginate(20);
			$meta =	getmetadata(8,true,$order);	
		}
		else
		{	
			$meta =	getmetadata(9);	
			 $dramas = Drama::with(['genre'])->where($query)
			->orderBy('first_char', 'ASC')
			->orderBy('release_year', 'DESC')
			 ->get()

                    ->groupBy('first_char')->map(function ($group) {
                          return $group->map(function ($value) {
                                return [
                                 "id" => $value->id,
                                 "title" => $value->title,
                                 "slug" => $value->slug,
                                 "year" => $value->release_year,
                                 "country" => $value->country_id,
                                 "status" =>$value->drama_status,
                                 "genre" =>$value->genre->map(function ($genre){

                                 	return $genre->name;
                        
                                 }),
                             ];
                          })->take(6);
                     });

            	
        
        // Meta Tags
				MetaTag::set('title', $meta->meta_title);
				MetaTag::set('description', strip_tags($meta->meta_desc));
				MetaTag::set('keywords', $meta->meta_kwd);
        return view('frontend.drama_list', compact("dramas","sidebar"));
			//$dramas = Drama::where(['status'=> 1])->paginate(20);
		}
		
		
		 // Meta Tags
				MetaTag::set('title', $meta->meta_title);
				MetaTag::set('description', strip_tags($meta->meta_desc));
				MetaTag::set('keywords', $meta->meta_kwd);

		return view('frontend.drama_episode',compact("dramas","sidebar"));
	}

	public function movie_list($order= null)
	{	

		$sidebar = getsidebardata();
		$meta =	getmetadata(10);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);

		if($order)
		{
			$sort_data = explode('-', $order);
			if(count($sort_data)>0)
				 $order = $sort_data[count($sort_data)-1];
			$sort_by = sort_drama('',$order);
			$dramas = Movie::where(['status'=> 1,'sort' => $sort_by])->paginate(20);
		}
		else
		{	

			 $dramas = Movie::with(['genre'])->where(['status'=> 1])
			->orderBy('first_char', 'ASC')
			->orderBy('release_year', 'DESC')
			 ->get()

                    ->groupBy('first_char')->map(function ($group) {
                          return $group->map(function ($value) {
                                return [
                                 "id" => $value->id,
                                 "title" => $value->title,
                                 "slug" => $value->slug,
                                 "year" => $value->release_year,
                                 "country" => $value->country_id,
                                 "status" =>$value->movie_status,
                                 "genre" =>$value->genre->map(function ($genre){

                                 	return $genre->name;
                        
                                 }),
                             ];
                          })->take(6);
                     });

                    
            // echo "<pre>";        
            // print_r($dramas);
            // die('here');  

            return view('frontend.movie_list', compact("dramas","sidebar"));
			//$dramas = Drama::where(['status'=> 1])->paginate(20);
		}
		$datatype = 'movie';
		return view('frontend.drama_episode',compact("dramas","sidebar","datatype"));
	}
	public function all_drama_country($country)
	{		
			$country_data = explode('-', $country);
			$page;
			if(count($country_data)>2)
			{	
				$datatype = $country_data['2'];
				array_splice( $country_data, -1 );
				$slug = implode( "-", $country_data );
			}
			else
			{
				$slug 	 = 	$country_data['0'];
				$datatype = $country_data['1'];
			}
			
			
			$country = Countries::where(['status'=> 1,'slug' => $slug])->first();
			if($datatype == 'drama')
			{	
				$page = 3;
				$dramas  = Drama::where(['status'=> 1,'country_id' => $country->id])->paginate(20);
			}
			
			else
			{
				$dramas  = Movie::where(['status'=> 1,'country_id' => $country->id])->paginate(20);
				$page = 15;
			}
			

			$sidebar = getsidebardata();
		$meta =	getmetadata($page,true,$slug);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);


			return view('frontend.drama_episode',compact("dramas","sidebar","datatype"));
	}

	public function all_drama_status($status)
	{
			$status = explode('-', $status);
			$status 	 = 	$status['0'];
			if($status == 'completed')
				$status_id = 3;
			else if($status == 'ongoing')
				$status_id = 2;
			else if($status == 'upcoming')
				$status_id = 1;
			else
				die('Status Not Found');


			// $dramas  = Drama::where(['status'=> 1,'drama_status' => $status_id])->get();

			$dramas  = Drama::where(['status'=> 1,'drama_status' => $status_id])->paginate(20);

			$sidebar = getsidebardata();
			$meta =	getmetadata(5,true,$status);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd); 
	
			return view('frontend.drama_episode',compact("dramas","sidebar"));
	}

	public function mostpopular()
	{
		$dramas = Drama::with(['genre'])->where(['status'=> 1])
			->orderBy('views', 'DESC')
			->orderBy('release_year', 'DESC')
			 ->paginate(20);

			 $sidebar = getsidebardata();
			 $meta =	getmetadata(23);
			// Meta Tags
			MetaTag::set('title', $meta->meta_title);
			MetaTag::set('description', strip_tags($meta->meta_desc));
			MetaTag::set('keywords', $meta->meta_kwd);
			return view('frontend.drama_episode',compact("dramas","sidebar"));
	}

	public function mostrecently($type)
	{	
		$datatype = 'drama';

		if($type == 'drama')
		{	
			$dramas = Episodes::with(['drama'])->where(['fetch_status' => 1])
				->whereRaw('updated_at IN (select MAX(updated_at) FROM episodes  GROUP BY drama_id)')
				->groupBy('drama_id')
				->orderBy('updated_at', 'DESC')
				->paginate(20);


			// $dramas = Drama::where(['status'=> 1])
			// ->orderBy('created_at', 'DESC')
			// ->orderBy('release_year', 'DESC')
			//  ->paginate(20);
		}
		else if($type == 'movie')
		{	
			$dramas = Movie::where(['fetch_status' => 1])
			->orderBy('updated_at', 'DESC')
			->orderBy('release_year', 'DESC')
			->paginate(20);


			 $datatype = 'movie';
		}
		else if($type == 'kshow')
		{	

			$dramas = Episodes::with(['drama'])->whereHas('drama', function($q) {
	    $q->where('is_kshow', 1);
			})
		->whereRaw('updated_at IN (select MAX(updated_at) FROM episodes  GROUP BY drama_id)')
		->groupBy('drama_id')
		->orderBy('updated_at', 'DESC')
		->paginate(20);


			//\DB::enableQueryLog();
			// $dramas = Drama::where(['status'=> 1,'is_kshow' =>1])
			// ->orderBy('created_at', 'DESC')
			// ->orderBy('release_year', 'DESC')
			//  ->paginate(20);

			// dd(\DB::getQueryLog());
		}
		else
		die('Not Correct Parameter');	

			$sidebar = getsidebardata();
			return view('frontend.recently_added',compact("dramas","sidebar","datatype"));
	}
	public function drama_details($slug)
	{	

		$ongoing  = Drama::where(['status'=> 1,'drama_status' => 2])->take(10)->get();
		$upcoming  = Drama::where(['status'=> 1,'drama_status' => 1])->take(10)->get();
		$drama = Drama::with(['country','episodes','genre','tags','othername'])->where(['status'=> 1,'slug' => $slug])->first();
		$drama->views = intval($drama->views)+1;
		$drama->save();

		$sidebar = getsidebardata(); 
		$meta =	getmetadata(1,true,$drama);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);
		return view('frontend.drama_details',compact(["drama","sidebar"]));
	}


	public function movie_details($slug)
	{	
		$drama = Movie::with(['country','genre','tags','othername'])->where(['status'=> 1,'slug' => $slug])->first();
		$drama->views = intval($drama->views)+1;
		$drama->save(); 

		$sidebar = getsidebardata(); 
		$meta =	getmetadata(16,true,$drama);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);
		return view('frontend.movie_details',compact("drama","sidebar"));
	}

	public function drama_episode()
	{
		return view('frontend.drama_episode');
	}

	public function actors_list()
	{
		return view('frontend.actors_list');
	}

	public function actors_details()
	{
		return view('frontend.actors_details');
	}

	public function released_in($year)
	{		
		$dramas = Drama::where(['status'=> 1,'release_year'=> $year])
			->orderBy('created_at', 'DESC')
			->orderBy('release_year', 'DESC')
			 ->paginate(20);
			 
			$sidebar = getsidebardata();
			$meta =	getmetadata(4,true,$year);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);
			return view('frontend.drama_episode',compact("dramas","sidebar"));

	}
	public function episode_detail($slug)
	{		
		
		$episode = Episodes::with(['drama','videos'])->where(['fetch_status' => 1, 'slug' => $slug])->first();

		if($episode)
		{
			$drama_id = $episode['drama']['id'];
			$all_episode = Episodes::where(['fetch_status' => 1, 'drama_id' => $drama_id])->where('slug' , '<>', $slug)
				->orderBy('episodes_no', 'DESC')
			->get();

				$sidebar = getsidebardata();
				$meta =	getmetadata(2,true,$episode);
			// Meta Tags
			MetaTag::set('title', $meta->meta_title);
			MetaTag::set('description', strip_tags($meta->meta_desc));
			MetaTag::set('keywords', $meta->meta_kwd);

			return view('frontend.episode_detail', compact(['episode','all_episode','sidebar']));
		}
		else
		{
			return redirect('/');
		}
		
	}

	public function movie_watch($slug)
	{		

		$episode = Movie::with(['videos'])->where(['fetch_status' => 1, 'slug' => $slug])->first();

		if($episode)
		{
			$sidebar = getsidebardata();
			$meta =	getmetadata(17,true,$episode);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);
			return view('frontend.movie_watch', compact(['episode','sidebar']));
		}
		else
		{
			return redirect('/');
		}
		
	}


	public function search(Request $request)
	{	
		$input = $request->all();
		$input['type'];
		$keyword = $input['keyword'];
		if($input['type'] == 'drama')
		$dramas = Drama::where(['status'=> 1])->Where('title', 'like', '%'.$keyword.'%')->paginate(20);
		else
		$dramas = Drama::where(['status'=> 1])->paginate(20);
		$meta =	getmetadata(22);
		// Meta Tags
		MetaTag::set('title', $meta->meta_title);
		MetaTag::set('description', strip_tags($meta->meta_desc));
		MetaTag::set('keywords', $meta->meta_kwd);

		return view('frontend.search',compact("dramas"));



	}
	public function cms_pages($slug)
	{	
		$data = CmsPages::where('slug',$slug)->first();
		if($data)
		{		
				$sidebar = getsidebardata();
				// Meta Tags
				MetaTag::set('title', $data->meta_title);
				MetaTag::set('description', strip_tags($data->meta_description));
				MetaTag::set('keywords', $data->meta_keyword);
				return view('frontend.pages', compact(['data','sidebar']));
		}
		
		else
		{	
			return redirect('/');
			return view('404');
		}

		
	}

  }