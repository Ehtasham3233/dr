<?php

namespace App\Http\Controllers;

use App\Models\Drama;
use App\Models\Countries;
use App\Models\Episodes;
use App\Models\Dramagenre;
use App\Models\Dramatags;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Watson\Sitemap\Facades\Sitemap;

class SitemapController extends Controller
{
	public function index()
	{
		dd('herer');

		return view('frontend.sitemap');
	}


	public function site($countryCode = null)
	{
		Sitemap::addSitemap(url('/sitemap/drama.xml'));
		Sitemap::addSitemap(url('/sitemap/movie.xml'));
		Sitemap::addSitemap(url('/sitemap/episodes.xml'));
		Sitemap::addSitemap(url('/sitemap/movie-watch.xml'));
		return Sitemap::index();
	}

	public function mapdramadate($date)
	{	
		$date = explode('-', $date);
		$dramas = Drama::where(['status'=> 1])
		->whereYear('created_at', '=', $date[0])
        ->whereMonth('created_at', '=', $date[1])
        ->get();
        if(count($dramas)>0)
		{
			foreach($dramas as $row) {
            Sitemap::addTag(url('drama-detail/'.$row['slug']), $row->updated_at, 'daily', '0.7');
        	}	
		}
		return Sitemap::render();
	}
	public function mapepisodesdate($date)
	{
		$date = explode('-', $date);
		$dramas = Episodes::where(['status'=> 1])
		->whereYear('created_at', '=', $date[0])
        ->whereMonth('created_at', '=', $date[1])
        ->get();
        if(count($dramas)>0)
		{
			foreach($dramas as $row) {
            Sitemap::addTag(url('video-watch/'.$row['slug']), $row->updated_at, 'daily', '0.7');
        	}	
		}
		return Sitemap::render();
	}

	public function mapmoviewatchdate($date)
	{
		$date = explode('-', $date);
		$dramas = Movie::where(['status'=> 1,'fetch_status' => 1])
		->whereYear('created_at', '=', $date[0])
        ->whereMonth('created_at', '=', $date[1])
        ->get();

        if(count($dramas)>0)
		{
			foreach($dramas as $row) {
            Sitemap::addTag(url('movie-watch/'.$row['slug']), $row->updated_at, 'daily', '0.7');
        	}	
		}
		return Sitemap::render();
	}

	public function mapmoviedate($date)
	{	

	// \DB::connection()->enableQueryLog();	

		$date = explode('-', $date);
		$dramas = Movie::where(['status'=> 1,'fetch_status' => 1])
		->whereYear('created_at', '=', $date[0])
        ->whereMonth('created_at', '=', $date[1])
        ->get();
        if(count($dramas)>0)
		{
			foreach($dramas as $row) {
            Sitemap::addTag(url('movie-detail/'.$row['slug']), $row->updated_at, 'daily', '0.7');
        	}	
		}
		return Sitemap::render();

  		// $queries = \DB::getQueryLog();
		// dd($queries);

	}

	public function drama($countryCode = null)
	{	
		$dramas = Drama::where(['status'=> 1])->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

		if(count($dramas)>0)
		{
			foreach($dramas as $row) {

				$date = $row['year'].'-'.$row['month'];
				Sitemap::addSitemap(url('/sitemap/drama/'.$date.'.xml'));
        	}	
		}
		return Sitemap::index();
	}

	public function movie($countryCode = null)
	{	
		$movie = Movie::where(['status'=> 1,'fetch_status' => 1])->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
		if(count($movie)>0)
		{
			foreach($movie as $row) {
			$date = $row['year'].'-'.$row['month'];
			Sitemap::addSitemap(url('/sitemap/movie/'.$date.'.xml'));
        	}	
		}
		return Sitemap::index();
	}


	public function episodes($countryCode = null)
	{	
		$episodes = Episodes::where(['fetch_status'=> 1])->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

		if(count($episodes)>0)
		{
			foreach($episodes as $row) {
			$date = $row['year'].'-'.$row['month'];
			Sitemap::addSitemap(url('/sitemap/episodes/'.$date.'.xml'));
        	}	
		}
		return Sitemap::index();
	}

	public function movie_watch($countryCode = null)
	{	
		$movie = Movie::where(['status'=> 1,'fetch_status' => 1])->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

		if(count($movie)>0)
		{
			foreach($movie as $row) {
			$date = $row['year'].'-'.$row['month'];
			Sitemap::addSitemap(url('/sitemap/movie-watch/'.$date.'.xml'));
        	}	
		}
		return Sitemap::index();
	}
}

?>