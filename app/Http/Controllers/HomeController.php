<?php

namespace App\Http\Controllers;
use App\Models\Drama;
use App\Models\Episodes;
use App\Models\Movie;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {   

        $totaldrama =  Drama::count();
        $totalmovie =  Movie::count();
        $totalepisode =  Episodes::count();
        $total_unfetch_episode =  Episodes::where('fetch_status',0)->count();


        $todaydrama =  Drama::where('created_at', '>=', Carbon::today())->count();
        $todaymovie =  Movie::where('created_at', '>=', Carbon::today())->count();
        $todayepisode =  Episodes::where('created_at', '>=', Carbon::today())->count();
         
        return view('pages.dashboard',compact([
            "totaldrama",
            "totalmovie",
            "total_unfetch_episode",
            "totalepisode",
            "todaydrama",
            "todaymovie",
            "todayepisode"
        ])); 
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('optimize');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');

        return view('clear-cache');
    }
}
