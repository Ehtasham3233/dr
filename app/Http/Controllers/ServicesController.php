<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Artisan;
use SMSActivate;
class ServicesController extends Controller
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
        //Create class instance SMSActivate
        $API_KEY = "4A253679e240d5829A51bf5Aee141f18";
        $this->SmsApi = new SMSActivate($API_KEY);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {       

         // $respone = Artisan::call('migrate');
         // print_r($respone);
         // die();

        $Services = $this->SmsApi->getTopCountriesByService();
        $all_services = array();
        foreach ($Services as $serivce_key => $service) 
        {   
            
            foreach ($service as $key => $row) 
            {   
                    $inner = array();
                    $inner['service_id'] = $serivce_key;
                    $inner['country_id'] = $row['country'];
                    $inner['price'] = $row['price'];
                    $inner['count'] = $row['count'];
                    $inner['created_at'] = now();
                    $all_services[] = $inner;
            }
           
        }
        if(count($all_services)>0)
        Services::insert($all_services);
            
        // echo "<pre>";
        // print_r($all_services);
        // die();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }
}
