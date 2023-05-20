<?php

namespace App\Http\Controllers;


//require_once(app_path().'/Helpers/smsactiveAPI.php');


use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\Countries;
use App\Models\Services;
use App\Models\SMS_History;
use App\Models\Active_Numbers as ActiveNumbers;
use Artisan;
use DB;


use SMSActivate;


class SmsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $SmsApi;

    public function __construct()
    {
        $this->middleware('auth');

        $API_KEY = "4A253679e240d5829A51bf5Aee141f18";
        $this->SmsApi = new SMSActivate($API_KEY);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   

           $country_list = Countries::where('visible',1)->get();

        // $respone = Artisan::call('migrate');
        // print_r($respone);
        // die();

        //$freeSlots = $sms->getNumber('vk',0);

        //$freeSlots = $this->SmsApi->getCountries();




        //Get the number of available numbers for the country of Russia and the tele2 operator


        // echo "<pre>";
        // print_r($freeSlots);
        // die();


        return view('sms',compact('country_list'));
    }

    public function get_number(Request $request)
    {   
        $input = $request->all();
        $sid = $input['service_id'];
        $cid = $input['country_id'];

        $respone = check_balance($sid,$cid);
        
        

        if(!$respone)
        {
            return response([
            'msg' => 'Your Blance Is not Enaugh For this Service Please Recharege Your account',
            'success' => 0,
            ]);
        }
        else
        {

        }


        echo "<pre>";
        print_r($cost);
        die();

        $number_data = $this->SmsApi->getNumber($sid,$cid);

        $an = ActiveNumbers::where('user_id',$user_id)->get();

    }

    public function get_Servicesby_country(Request $request)
    {
        $input = $request->all();

        $country_id = $input['country'];
        
         $services_list = DB::table('services as s')
            ->select(['s.country_id','s.service_id','s.price_usd','name.service_name'], DB::raw('count(*) as total'))
             ->leftJoin('services_names as name', 'name.service_id', '=', 's.service_id')

            ->groupBy('s.service_id')
             ->where('s.country_id',$country_id)
            ->get();

        $html='';
         if(count($services_list)>0)
         {  
            foreach ($services_list as $key => $sr) {               
            $html .= "<option data-rate=".$sr->price_usd." value='".$sr->service_id."'>"
                        .$sr->service_name."</option>";
            }
         }
         else
         {
            $html .= "<option value='' selected>Select a Service</option>";
         }

         echo json_encode($html);
         exit();
    }
}