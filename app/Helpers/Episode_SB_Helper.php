<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\episode_videos as EpisodeVideos;
use App\Models\Countries;
use App\Models\Dramagenre;
use App\Models\Drama;
use App\Models\Episodes;
use App\Models\Movie;
use App\Models\Server;

function fetch_episodes_from_url($data)
{	
	$responsedata = array();
	foreach ($data as $key => $value) {
		$html = get_html_from_url($value['reff_url']);
        if($html)
        {
            $epi_download_url 	= '';
			if($html->find('li.download',0))
			$epi_download_url = trim($html->find('li.download',0)->find('a',0)->href);
				$epi_videos = get_episdoe_videos($html);
				if(count($epi_videos)>0)
					$response  = save_episode_videos($epi_videos,$value['id']);
				if($response['status'])
				{	
					Episodes::where("id", $value["id"])
						->update([
		                'fetch_status' => 1,
		                'status' => 1,
		                'download_url' => $epi_download_url,
		                'ip' => \request()->ip(),
		                'updated_by' => \Auth::id()
		            	]);

		            $epidata['episode_title']	 = $value['title'];
		            $epidata['episode_server']	 = $response['data'];
		            $responsedata[] = $epidata;   	
				}	
        }	
	}

	return $responsedata;
}



function get_episdoe_videos($html)
{	
	$epi_videos = array();
	if($html->find('div.anime_muti_link',0))
	{
		$html_links = $html->find('div.anime_muti_link',0);
		if($html_links->find('li',0))
		{
			$srv_sr = 0;
			foreach($html_links->find('li') as $obj_links)
			{
				$this_serv_title = $obj_links->innertext;
				$this_serv_title = str_replace("<span>Choose this server</span>","",$this_serv_title);
				$this_serv_title = trim($this_serv_title);
				$this_serv_url   = $obj_links->{'data-video'};
				if($this_serv_title != '' and $this_serv_url != '')
				{
					$srv_sr++;
					$epi_videos[$srv_sr]['title'] 	= $this_serv_title;
					$epi_videos[$srv_sr]['url'] 	= $this_serv_url;
				}
			}
		}
	}

	return $epi_videos;
}


function save_episode_videos($epi_videos,$episode_id)
{	
	$allvideos = array();
	$respdata = array();
	foreach ($epi_videos as $key => $episode) {

		$serv_title = $episode['title'];
		$vid_url 	= $episode['url'];
		$server_id = get_server_id($serv_title);

		if($server_id>0)
		{	$server_data = array();
			$server_data['episode_id'] = $episode_id;
			$server_data['server_id'] = $server_id;
			$server_data['video_url'] = $vid_url;
			$allvideos[] = $server_data;
 
			$respdata[] =  $serv_title;
		}
	}
		if(count($allvideos)>0)
		{	
			\DB::table('episode_videos')->insert($allvideos);

			$data['data'] = $respdata;
			$data['status'] = true; 
			return $data;
		}
		else
		{	
			$data['data'] = $respdata;
			$data['status'] = false; 
			return $data;
		}
}



function save_movie_videos($epi_videos,$episode_id)
{	
	$allvideos = array();
	$respdata = array();
	foreach ($epi_videos as $key => $episode) {

		$serv_title = $episode['title'];
		$vid_url 	= $episode['url'];
		$server_id = get_server_id($serv_title);

		if($server_id>0)
		{	$server_data = array();
			$server_data['movie_id'] = $episode_id;
			$server_data['server_id'] = $server_id;
			$server_data['video_url'] = $vid_url;
			$allvideos[] = $server_data;
 
			$respdata[] =  $serv_title;
		}
	}
		if(count($allvideos)>0)
		{	
			\DB::table('movies_videos')->insert($allvideos);

			$data['data'] = $respdata;
			$data['status'] = true; 
			return $data;
		}
		else
		{	
			$data['data'] = $respdata;
			$data['status'] = false; 
			return $data;
		}
}

function get_server_id($servername)
{
	$server = Server::where('title',$servername)->first();
	if($server)
	{	
		return $server->id;
	}
	else
	{	
		$server = Server::create([
			'title' 	 => $servername,
			'slug' 		 =>	Str::slug($servername),
			'ip' 		 =>  \request()->ip(),
			'status' 	 => 1,
			'added_by' => \Auth::id()
		]);

		return $server->id;
	}
}



function fetch_videos_from_url($data)
{	
	$responsedata = array();
	foreach ($data as $key => $value) {
		$html = get_html_from_url($value['reff_url_detail']);
        if($html)
        {	
            $epi_download_url 	= '';
			if($html->find('li.download',0))
			$epi_download_url = trim($html->find('li.download',0)->find('a',0)->href);
				$epi_videos = get_episdoe_videos($html);

				// echo "<pre>";
				// print_r($epi_videos);
				// die();
				if(count($epi_videos)>0)
					$response  = save_movie_videos($epi_videos,$value['id']);
				if($response['status'])
				{	
					Movie::where("id", $value["id"])
						->update([
		                'fetch_status' => 1,
		                'status' => 1,
		                'movie_download_url' => $epi_download_url,
		                'ip' => \request()->ip(),
		                'updated_by' => \Auth::id()
		            	]);

		            $epidata['episode_title']	 = $value['title'];
		            $epidata['episode_server']	 = $response['data'];
		            $responsedata[] = $epidata;   	
				}	
        }	
	}

	return $responsedata;
}

function get_download_url($reffurl)
{
	$html = get_html_from_url($reffurl);
        if($html)
        {	
            $epi_download_url 	= '';
			if($html->find('li.download',0))
			$epi_download_url = trim($html->find('li.download',0)->find('a',0)->href);

			return $epi_download_url;
		}
		else
			return false;
}
function get_list_server($url)
{
	return $url;
}