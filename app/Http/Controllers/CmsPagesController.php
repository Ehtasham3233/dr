<?php

namespace App\Http\Controllers;

use App\Models\CmsPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;

class CmsPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // $data = CmsPages::get();
         // return view('cmspages.list', compact('data'));
        return view('cmspages.cms_page');
    }

    public function get_list_cms(){
        $data = CmsPages::where('status',1)->get();
        return Datatables::of($data)
                ->addColumn('status', function ($data) {
                    return $data->status==1?'Active':'Inactive';  
                })
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {

                       return '<div class="table-actions">   
                        <a href="'.url('cms-pages/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('cms-pages/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                        </div> ';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cmspages.add');
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
            'page_title' => 'required | string ',
            'title_menu' => 'required | string ',
            'meta_title' => 'required | string ',
            'meta_keyword' => 'required | string ',
            'meta_description' => 'required | string ',
            'content' => 'required | string ',
            'status' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            //dd($input);
            $cmspages = CmsPages::create([
                'status' => $input['status'],
                'page_title' => $input['page_title'],
                'title_menu' => $input['title_menu'],
                'meta_title' => $input['meta_title'],
                'meta_keyword' => $input['meta_keyword'],
                'meta_description' => $input['meta_description'],
                'content' => $input['content'],
                'slug' => Str::slug($input['slug']),
                'ip' => $request->ip(),
                'created_by' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function show(CmsPages $cmsPages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $record = CmsPages::find($id);
        if($record)
        {
            return view('cmspages.edit',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsPages $cmsPages)
    {
       $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'page_title' => 'required | string ',
            'title_menu' => 'required | string ',
            'meta_title' => 'required | string ',
            'meta_keyword' => 'required | string ',
            'meta_description' => 'required | string ',
            'content' => 'required | string ',
            'status' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            //dd($input);
            $cmspages = CmsPages::find($request->id);
            $cmspages->update([
                'status' => $input['status'],
                'page_title' => $input['page_title'],
                'title_menu' => $input['title_menu'],
                'meta_title' => $input['meta_title'],
                'meta_keyword' => $input['meta_keyword'],
                'meta_description' => $input['meta_description'],
                'content' => $input['content'],
                'slug' => Str::slug($input['slug']),
                'ip' => $request->ip(),
                'created_by' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cmspages = CmsPages::find($id);
        if ($cmspages) {
            $cmspages->delete();

            return redirect()->back()->with('success', 'CmsPages removed!');
        } else {
            return redirect()->back()->with('error', 'CmsPages not found');
        }
    }
}
