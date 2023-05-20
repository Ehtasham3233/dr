<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Countries;
use App\Models\Dramagenre;
use App\Models\Moviegenre;
use App\Models\Server;
use App\Models\Drama;
use App\Models\Episodes;
use App\Models\Movie;
use App\Models\SiteSettings;
use App\Models\CmsPages;
use App\Models\SitePagesMeta;
use App\Models\Slider;



function get_othername($othername)
{	$other = array();
	foreach ($othername as $key => $value)
		$other[] = $value->name;
	return implode(',', $other);
}
function getsidebardata()
{		
	$site_setting = SiteSettings::first();		
	$ongoing  = Drama::where(['status'=> 1,'drama_status' => 2])->take(20)->get();
	$upcoming  = Drama::where(['status'=> 1,'drama_status' => 1])->take(20)->get();
	$data['ongoing'] = $ongoing;
	$data['upcoming'] = $upcoming;
	$data['settings'] = $site_setting;
	return $data;
}

function getslider()
{
	return  Slider::where(['status'=> 1])->get();
}


function getpages()
{
	// $pages  = CmsPages::where(['status'=> 1)->get();
	// return $pages;
}

function get_server_list($server_id=null)
{	
		
	$selected='';
	$server =   Server::where('status',1)->get();
	$html = '<option value="">Selected Server</option>';
	foreach ($server as $key => $value) {
		if($server_id)
			$selected = $server_id == $value->id?'selected':'';

		// var_dump($selected);
		// die('here');
		$html .= '<option '.$selected.' value="'.$value->id.'">'.$value->title.'</option>';
	}

	return $html;
}

function get_setting()
{
	return $SiteSettings = SiteSettings::find(1);
}
function country_menu()
{
	return  Countries::where('status',1)->get();
}

function genre_menu()
{
	return Dramagenre::groupBy('name')->get();
}

function movie_genre_menu()
{
	return Moviegenre::groupBy('name')->get();
}

function movie_realse_year_menu()
{
	return Movie::where('status',1)->groupBy('release_year')->orderBy('release_year', 'DESC')->get();
}

function realse_year_menu()
{
	return Drama::where('status',1)->groupBy('release_year')->orderBy('release_year', 'DESC')->get();
}

function duplicate_Check($title)
{
		$drama = Drama::where('title',$title)->first();

		if($drama)
		return true;
		else
		return false;
	
}

function duplicate_Check_movie($title)
{
		$drama = Movie::where('title',$title)->first();

		if($drama)
		return true;
		else
		return false;
	
}
function get_country_id($countyname)
{
	$country = Countries::where('title',$countyname)->first();
	if($country)
	{	
		return $country->id;
	}
	else
	{	
		$country = Countries::create([
			'title' 	 => $countyname,
			'slug' 		 =>	Str::slug($countyname),
			'ip' 		 =>  \request()->ip(),
			'status' 	 => 1,
			'created_by' => \Auth::id()
		]);

		return $country->id;
	}
}

function get_drama_status($status)
{

	$drama_status 	= strtolower($status);
	if($drama_status == 'upcoming')
		$this_drama_status 	= 1;
	elseif($drama_status == 'ongoing')
		$this_drama_status 	= 2;
	elseif($drama_status == 'completed')
		$this_drama_status 	= 3;
	else
	$this_drama_status = 0;

	return  $this_drama_status;
}

function drama_status_name($status)
{

	if($status == 1)
	$this_drama_status = 'Upcoming';
	elseif($status == 2)
	$this_drama_status = 'Ongoing';
	elseif($status == 3)
	$this_drama_status = 'Completed';
	else
	$this_drama_status = 'New Drama';

	return  $this_drama_status;
}

function sort_drama($drama_title,$letter=null)
{
	if($letter)
		$first_char = $letter;
	else
	{
		$first_char = substr($drama_title,0,1);
		$first_char = strtolower($first_char);
	}
	$drama_sort = 0;
	if($first_char == 'a'){$drama_sort = 2;}
	elseif($first_char == 'b'){$drama_sort = 3;}
	elseif($first_char == 'c'){$drama_sort = 4;}
	elseif($first_char == 'd'){$drama_sort = 5;}
	elseif($first_char == 'e'){$drama_sort = 6;}
	elseif($first_char == 'f'){$drama_sort = 7;}
	elseif($first_char == 'g'){$drama_sort = 8;}
	elseif($first_char == 'h'){$drama_sort = 9;}
	elseif($first_char == 'i'){$drama_sort = 10;}
	elseif($first_char == 'j'){$drama_sort = 11;}
	elseif($first_char == 'k'){$drama_sort = 12;}
	elseif($first_char == 'l'){$drama_sort = 13;}
	elseif($first_char == 'm'){$drama_sort = 14;}
	elseif($first_char == 'n'){$drama_sort = 15;}
	elseif($first_char == 'o'){$drama_sort = 16;}
	elseif($first_char == 'p'){$drama_sort = 17;}
	elseif($first_char == 'q'){$drama_sort = 18;}
	elseif($first_char == 'r'){$drama_sort = 19;}
	elseif($first_char == 's'){$drama_sort = 20;}
	elseif($first_char == 't'){$drama_sort = 21;}
	elseif($first_char == 'u'){$drama_sort = 22;}
	elseif($first_char == 'v'){$drama_sort = 23;}
	elseif($first_char == 'w'){$drama_sort = 24;}
	elseif($first_char == 'x'){$drama_sort = 25;}
	elseif($first_char == 'y'){$drama_sort = 26;}
	elseif($first_char == 'z'){$drama_sort = 27;}
	else{$drama_sort = 1;}

	return $drama_sort;
}

function file_upload($request,$formFileName,$path)
{
         $fileFinalName = "";
         $fileFinalName = time() . rand(1111,9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
            $request->file($formFileName)->move($path, $fileFinalName);
        return $fileFinalName;
}

function file_upload_drama($request,$formFileName,$path)
{
         $fileFinalName = "";
         $fileFinalName = time() . rand(1111,9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
        Storage::disk('drama')->put($fileFinalName, $request->file($formFileName));
        return $fileFinalName;
}

function file_upload_from_url($url,$path)
{			
			$fileinfo = parse_url($url);
			$ext 	= pathinfo($fileinfo['path'], PATHINFO_EXTENSION);
          $fileFinalName = time() . rand(1111,9999) . '.' . $ext;
          $contents = file_get_contents($url);
          Storage::disk('drama')->put($fileFinalName, $contents);
        	 return $fileFinalName;
}

function file_delete($path,$filename)
{		
	$file = public_path($path.$filename);
	if (file_exists($file))
	    \File::delete($path . $filename);      
}

function get_html_from_url($drama_url)
{
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL,$drama_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, random_user_agent());
		$server_output = curl_exec ($ch);
		if($server_output != '')
		{
			$html = new simple_html_dom;
			return $html->load($server_output);
		}
		else
		{
			return false;
		}
		
}

function get_title_url($html)
{
	if($html->find('h1',0))
	{
		$response['drama_title'] 	  = trim($html->find('h1',0)->innertext);
		$response['drama_title_url'] = pure_clean_title_up($response['drama_title']);
		$response['status'] = true;
		return $response;
	}

	else
	{	
		$response ['status'] = false;
		$response ['msg'] = 'Title Not found In Given Data';
		return $response;
	}
}


function get_icon_url($html)
{	
	if($html->find('meta[property="og:image"]',0))
	{
		$drama_icon = $html->find('meta[property="og:image"]',0)->content;
		$drama_icon = trim($drama_icon);
		$response ['drama_icon'] = $drama_icon;
		$response ['status'] = true;
		return $response;
	}

	else
	{	
		$response ['status'] = false;
		$response ['msg'] = 'Image Not found In Given Data';
		return $response;
	}

	
}


function get_other_names($html)
{	
	if($html->find('p.other_name',0))
	{
		$obj_onames = $html->find('p.other_name',0);		
		foreach($obj_onames->find('a') as $obj_onval)
		{
			$this_other_name = trim($obj_onval->innertext);	
			if($this_other_name != '')
			{
				$other_names[] = $this_other_name;
			}
		}
		$response ['other_names'] = $other_names;
		$response ['status'] = true;
		return $response;
	}
	else
	{	
		$response ['status'] = false;
		$response ['msg'] = 'Other Name Not found In Given Data';
		return $response;
	}

	
}

			
function get_info($html)
{
	if($html->find('div.info',0))
	{	
		$drama_release_date = '0000-00-00';
		$drama_country = '';
		$drama_status = '';
		$drama_release_year ='0000';
		$drama_desc = '';
		$drama_genre = array();


		$info_box = $html->find('div.info',0);	
		if($info_box->find('p',0))
		{
			$info_dsr = 0; 
			$isr = 0;
			foreach($info_box->find('p') as $inp_val)
			{
				$this_ptxt = $inp_val->innertext;
				$this_ptxt = trim($this_ptxt);

				// echo $this_ptxt;
				// echo "<br>";

				if($info_dsr == 2)
				{	
					//dd($info_dsr);
					if(strstr($this_ptxt,'<span>Country:</span>'))
					{
						$this_ptxt = str_replace("<span>Country:</span>","",$this_ptxt);

						$obj_country = new simple_html_dom;
						$obj_country->load($this_ptxt);

						//dd($obj_country);
						if($obj_country->find('a',0))
						{
							$drama_country = $obj_country->find('a',0)->innertext;
							$drama_country = trim($drama_country);
							//dd($drama_country);
						}
					}
					elseif(strstr($this_ptxt,'<span>Status:</span>'))
					{
						$this_ptxt = str_replace("<span>Status:</span>","",$this_ptxt);

						$obj_status = new simple_html_dom;
						$obj_status->load($this_ptxt);

						if($obj_status->find('a',0))
						{
							$drama_status = $obj_status->find('a',0)->innertext;
							$drama_status = trim($drama_status);
						}
					}
					elseif(strstr($this_ptxt,'<span>Released:</span>'))
					{
						$this_ptxt = str_replace("<span>Released:</span>","",$this_ptxt);

						$obj_released = new simple_html_dom;
						$obj_released->load($this_ptxt);

						if($obj_released->find('a',0))
						{
							$drama_release_year = $obj_released->find('a',0)->innertext;
							$drama_release_year = trim($drama_release_year);
						}
					}
					elseif(strstr($this_ptxt,'<span>Genre:</span>'))
					{
						$this_ptxt = str_replace("<span>Genre:</span>","",$this_ptxt);

						$obj_genre = new simple_html_dom;
						$obj_genre->load($this_ptxt);

						if($obj_genre->find('a',0))
						{
							foreach($obj_genre->find('a') as $ogen_val)
							{
								$this_gen = $ogen_val->innertext;
								$this_gen = trim($this_gen);

								if($this_gen != '')
								{
									$drama_genre[] = $this_gen;
								}
							}
						}
					}
					elseif(strstr($this_ptxt,'<span>Airs:</span>'))
					{
						$this_ptxt = str_replace("<span>Airs:</span>","",$this_ptxt);
						$this_ptxt = trim($this_ptxt);
						$drama_release_date = date("Y-m-d",strtotime($this_ptxt));
					}

				}
				elseif($info_dsr == 1)
				{	
					//dd($this_ptxt);
					if($this_ptxt != '')
					{
						// $drama_desc .= '<p>'.$this_ptxt.'</p>';
						$drama_desc .= $this_ptxt;

						$next_child = $isr+1;
						
						$next_ptxt = $info_box->find('p',$next_child)->innertext;
						$next_ptxt = trim($next_ptxt);

						if(strstr($next_ptxt,'<span>'))
						{
							$info_dsr++;
						}
					}
				}
				elseif($info_dsr == 0 and ($this_ptxt == '<span>Description:</span>' || 
					$this_ptxt == '<span>Description</span>'))
				{	
					//dd($this_ptxt);
					$info_dsr++;
				}

				$isr++;
			} ///////foreach End //////////
		} ///////// info_box if end  /////////////


	$response['drama_country'] = $drama_country;
	$response['drama_status'] = $drama_status;
	$response['drama_release_year'] = $drama_release_year;
	$response['drama_genre'] = $drama_genre;
	$response['drama_release_date'] = $drama_release_date;
	$response['drama_desc'] = $drama_desc;
	 
	$response ['status'] = true;
	return $response;

	} // main if end/////////

	else
	{
		$response ['status'] = false;
		$response ['msg'] = 'info Not found In Given Data';
		return $response;
	}
	
}


function get_drama_cast($html)
{
	if($html->find('div.slider-star',0))
	{
		$html_stars = $html->find('div.slider-star',0);
		if($html_stars->find('h3',0))
		{	$drama_cast=''; 
			foreach($html_stars->find('h3') as $obj_stars)
			{
				$this_star = trim($obj_stars->innertext);
				if($this_star != '')
				{
					$drama_cast .= $this_star.', ';
				}
			}
			$drama_cast = rtrim($drama_cast,', ');

			$response['drama_cast'] = $drama_cast;
			$response ['status'] = true;
			return $response;
		}

		$response ['msg'] = 'Cast Not found In Slider Star';
		$response ['status'] = false;
		return $response;
	}

	else
	{
		$response ['status'] = false;
		$response ['msg'] = 'Cast Not found In Given Data';
		return $response;
	}
}


function get_tag($html)
{
	if($html->find('div.tags',0))
	{
		$html_tags = $html->find('div.tags',0);

		if($html_tags->find('a',0))

			

		{	$drama_tags = array();
			foreach($html_tags->find('a') as $obj_tag)
			{	

				
				$this_tag_val = $obj_tag->innertext;
				$this_tag_val = trim($this_tag_val);

				// echo "<pre>";
				// print_r($this_tag_val);
				// die('her12e');
				
				$this_tag_url = $obj_tag->href;

				if($this_tag_val != '')
				{
					$drama_tags[] = $this_tag_val;
				}
			}

			$response['drama_tags'] = $drama_tags;
			$response ['status'] = true;
			return $response;
		}
	}

	else
	{
		$response ['status'] = false;
		$response ['msg'] = 'Tag Not found In Given Data';
		return $response;
	}
}

function drama_trailer_yt($html)
{
	if($html->find('div.trailer',0))
	{
		$html_trailer = $html->find('div.trailer',0);
		if($html_trailer->find('iframe',0))
		{
			$trailer_url = $html_trailer->find('iframe',0)->src;
			if($trailer_url != '')
			{
				$yt_vid_id = get_ytvid_id($trailer_url);
				if($yt_vid_id != '')
				{
					$drama_trailer_yt_url = "https://www.youtube.com/watch?v=".$yt_vid_id;
					$trailer_id = $yt_vid_id;
				}
			}

			$response['drama_trailer_yt_url'] = $drama_trailer_yt_url;
			$response['yt_vid_id'] = $yt_vid_id;
			$response ['status'] = true;
			return $response;	
		}

		$response ['status'] = false;
		$response ['msg'] = 'Trailer Url Not found In iframe Data';
		return $response;
	}
	else
	{
		$response ['status'] = false;
		$response ['msg'] = 'Trailer Url Not found In Given Data';
		return $response;
	}
}


function get_all_episode($drama_url ,$html)
{
	$drama_url_info = parse_url($drama_url);
	$drama_url_base = $drama_url_info['scheme'].'://'.$drama_url_info['host'];

	$drama_pisodes = array();
	if($html->find('ul.all-episode',0))
	{
		$html_episodes = $html->find('ul.all-episode',0);

		if($html_episodes->find('a',0))
		{
			$esr = count($html_episodes->children());

			foreach($html_episodes->find('a') as $obj_epi)
			{
				$this_epi_title = trim($obj_epi->find('h3',0)->innertext);
				$this_epi_type = trim($obj_epi->find('span.type',0)->innertext);
				$this_epi_time = trim($obj_epi->find('span.time',0)->innertext);
				$this_epi_url = trim($obj_epi->href);
				if(!strstr($this_epi_url,$drama_url_base))
				{
					$this_epi_url = $drama_url_base.$this_epi_url;
				}
				if($this_epi_title != '' and $this_epi_url != '')
				{
					$drama_pisodes[$esr]['title'] 		= $this_epi_title;
					$drama_pisodes[$esr]['type'] 		= $this_epi_type;
					$drama_pisodes[$esr]['url'] 		= $this_epi_url;
					$drama_pisodes[$esr]['date'] 		= date("Y-m-d",strtotime($this_epi_time));
					$drama_pisodes[$esr]['date_time'] 	= date("Y-m-d H:i:s",strtotime($this_epi_time));
					$esr--;
				}
			}

			$response['drama_pisodes'] = $drama_pisodes;
			$response ['status'] = true;
			return $response;
		}

		$response ['status'] = false;
		$response ['msg'] = 'Episodes Url Not found In Episode Section';
		return $response;
	}
	else
	{
		$response ['status'] = false;
		$response ['msg'] = 'Episodes Not found In Given Data';
		return $response;
	}

	ksort($drama_pisodes);
}

function getproductdata($html)
{
	echo $html->find('h1',0)->innertext;

	die();
}



function getmetadata($id,$modify=false,$data=null)
{
	$page = SitePagesMeta::where('id',$id)->first();
	if($modify)
	{ 		
			
		$page->meta_title = modifydata($id,$page->meta_title,$data);
		$page->meta_kwd = modifydata($id,$page->meta_kwd,$data);
		$page->meta_desc = modifydata($id,$page->meta_desc,$data);
		return $page;	

	}
	else
	{
		return $page;
	}
	 
}
function modifydata($id,$meta,$data)
{
	$pattern = '/\[.+?\]/';
		$matches = array();
		if (preg_match_all($pattern, $meta, $matches)) 
		{	
			$found = $matches[0];
			if(count($found)>0)
			{
				$parameter = getorignal($id,$found,$data);
				if(count($parameter)>0)
				{
					return str_replace($found,$parameter,$meta,$count);
				}
				else
				return $meta;
			}
			else
			return $meta;

		}
		else
		return $meta;
}

function getorignal($spm_id,$found,$data)
{
	if(isset($spm_id) and ($spm_id == 1 || $spm_id == 16 || $spm_id == 17))
	{		
		$param;
		foreach($found as $index)
		{		
			$index = str_replace(array('[', ']'), '', $index);
			if($index == 'drama_title' || $index == 'movie_title')
			$param[] = $data['title'];
			elseif($index == 'con_title')
			$param[] = isset($data['country']['title'])?$data['country']['title']:'';
			elseif($index == 'show_dstatus')
			$param[] = drama_status_name($data['drama_status']);	
			elseif($index == 'show_other_names')
			$param[] = get_othername($data['othername']);	
			elseif($index == 'show_geners')
			$param[] = get_othername($data['genre']);	
			elseif($index == 'show_tags')
			$param[] = get_othername($data['tags']);	
			elseif($index == 'site_title')
			$param[] = 'Dramacool';	
		}
		return $param;
	}

	if(isset($spm_id) and ($spm_id == 2))
	{		
		$param;
		foreach($found as $index)
		{	
			$index = str_replace(array('[', ']'), '', $index);
			if($index == 'drama_title')
			$param[] = $data['drama']['title'];
			elseif($index == 'epi_title')
			$param[] = $data['title'];	
			elseif($index == 'epi_no')
			$param[] = $data['episodes_no'];	
			elseif($index == 'site_title')
			$param[] = 'Dramacool';	
		}
		return $param;
	}

	if(isset($spm_id) and ($spm_id == 3 || $spm_id == 15 || $spm_id == 4 || $spm_id == 5||$spm_id == 6 ||$spm_id == 7 ||$spm_id == 8||$spm_id == 11 ||$spm_id == 12 ||$spm_id == 13 ||$spm_id == 14))
	{		
		$param;
		foreach($found as $index)
		{		
			$index = str_replace(array('[', ']'), '', $index);
			if($index == 'con_title')
			$param[] = $data;
			elseif($index == 'current_year')
			$param[] = date('Y');
			elseif($index == 'this_year')
			$param[] = $data;	
			elseif($index == 'drama_status')
			$param[] = $data;
			elseif($index == 'movie_status')
			$param[] = $data;
			elseif($index == 'gen_title')
			$param[] = $data;
			elseif($index == 'tag_title')
			$param[] = $data;
			elseif($index == 'show_char')
			$param[] = $data;
			elseif($index == 'site_title')
			$param[] = 'Dramacool';	
		}
		return $param;
	}

}
function getnext($episode)
{		
	return Episodes::where(['episodes_no' => intval($episode['episodes_no'])+1,'drama_id' => $episode['drama_id']])->first();
}	


function getprev($episode)
{		

	$epino = intval($episode['episodes_no'])-1;
	// \DB::connection()->enableQueryLog();
	return Episodes::where(['episodes_no' => $epino,'drama_id' =>$episode['drama_id']])->first();

	// $queries = \DB::getQueryLog();
	// dd($queries);
	// echo "<pre>";
	// var_dump($res);
	// die('here');
}		