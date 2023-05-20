<?php

namespace App\Http\Controllers;

use App\Models\SitePagesMeta;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SitePagesMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SitePagesMeta::get();
        return view('site_pages_meta.view_site_pages',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\SitePagesMeta  $sitePagesMeta
     * @return \Illuminate\Http\Response
     */
    public function show(SitePagesMeta $sitePagesMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SitePagesMeta  $sitePagesMeta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = SitePagesMeta::find($id);
        if($record)
        {
            return view('site_pages_meta.edit_site_pages',compact("record"));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SitePagesMeta  $sitePagesMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SitePagesMeta $sitePagesMeta)
    {
        $input = $request->all();
        
     //dd($input);
        try
        {   
           // dd($input);
            $site_page = SitePagesMeta::find($request->id);
            $site_page->update([
                'page_name' => $input['page_name'],
                'page_title' => $input['page_title'],
                'meta_title' => $input['meta_title'],
                'meta_kwd' => $input['meta_kwd'],
                'meta_desc' => $input['meta_desc'],
                'page_text_top' => $input['page_text_top'],
                'page_text_bottom' => $input['page_text_bottom'],
                'ip' => $request->ip(),
                'updated_by' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'Site Pages information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SitePagesMeta  $sitePagesMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(SitePagesMeta $sitePagesMeta)
    {
        //
    }
}
