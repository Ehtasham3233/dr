<?php

namespace App\Http\Controllers;

use App\Models\SiteSettings;

use App\Models\Drama;
use App\Models\Episodes;
use App\Models\Dramagenre;
use App\Models\Dramatags;
use App\Models\Dramaothername;
use App\Models\episode_videos;

use App\Models\Movie;
use App\Models\movies_videos;
use App\Models\Moiveothername;
use App\Models\Movietags;
use App\Models\Moviegenre;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $SiteSettings = SiteSettings::find(1);

        return view('sitesetting.site_setting',compact(["SiteSettings"]));
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
            'title' => 'required | string',
            'site_title_sort' => 'required | string ',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   

            $SiteSettings = SiteSettings::find(1);

            $data = array(
                'title' => $input['title'],
                'site_title_sort' => $input['site_title_sort'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'com_type' => $input['com_type'],
                'fb_url' => $input['fb_url'],
                'twtr_url' => $input['twtr_url'],
                'yt_url' => $input['yt_url'],
                'google_url' => $input['google_url'],
                'pin_url' => $input['pin_url'],
                'reddit_url' => $input['reddit_url'],
                'vimeo_url' => $input['vimeo_url'],
                'linkedin_url' => $input['linkedin_url'],
                'ins_url' => $input['ins_url'],
                'tele_url' => $input['tele_url'],
                'footer_text' => $input['footer_text'],
                'befor_head' => $input['befor_head'],
                'after_body' => $input['after_body'],
                'before_body' => $input['before_body'],
                'ip' => $request->ip(),
                'updated_by' => Auth::id());

            if($request->file('admin_dark_logo'))
            {   
                file_delete('storage/site/',$SiteSettings->admin_dark_logo);
                $admin_dark_logo = file_upload($request,'admin_dark_logo','storage/site/');
                $data['admin_dark_logo'] = $admin_dark_logo;
            }
            if($request->file('admin_light_logo'))
            {   
                file_delete('storage/site/',$SiteSettings->admin_light_logo);
                $admin_light_logo = file_upload($request,'admin_light_logo','storage/site/');
                $data['admin_light_logo'] = $admin_light_logo;
            }
            if($request->file('site_logo'))
            {   
                file_delete('storage/site/',$SiteSettings->site_logo);
                $site_logo = file_upload($request,'site_logo','storage/site/');
                $data['site_logo'] = $site_logo;
            }

            if($request->file('logo_mobile'))
            {   
                file_delete('storage/site/',$SiteSettings->logo_mobile);
                $logo_mobile = file_upload($request,'logo_mobile','storage/site/');
                $data['logo_mobile'] = $logo_mobile;
            }
            if($request->file('site_icon'))
            {   
                file_delete('storage/site/',$SiteSettings->site_icon);
                $site_icon = file_upload($request,'site_icon','storage/site/');
                $data['site_icon'] = $site_icon;
            }
            if($request->file('site_img'))
            {   
                file_delete('storage/site/',$SiteSettings->site_img);
                $site_img = file_upload($request,'site_img','storage/site/');
                $data['site_img'] = $site_img;
            }

             //dd($input);
            
            $SiteSettings->update($data);
            return redirect()->back()->with('success', 'Site Information information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function show(SiteSettings $siteSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSettings $siteSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSettings $siteSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSettings $siteSettings)
    {   

        Drama::truncate();
        Dramatags::truncate();
        Dramagenre::truncate();
        Dramaothername::truncate();
        Episodes::truncate();
        episode_videos::truncate();
        Movie::truncate();
        movies_videos::truncate();
        Movietags::truncate();
        Moviegenre::truncate();
        Moiveothername::truncate();

    }
}
