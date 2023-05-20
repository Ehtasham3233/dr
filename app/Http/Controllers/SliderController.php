<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\Server;
use Auth;
use DataTables;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Slider::get();
        // return view('slider.list', compact('data'));
        return view('slider.slider_page');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.add');
    }

    public function get_sider_list()
    {
        $data = Slider::where('status',1)->get();
        return Datatables::of($data)
               ->addColumn('status', function ($data) {
                    return $data->status==1?'Active':'Inactive';  
                })
                ->addColumn('image', function ($data) {
                    $img = $data->img;
                    if ($img) {

                    return '<img  width="130px" height="auto" src="'.asset('storage/slider/'.$img).'">';
                    }

                    return '';
                })
                
                ->addColumn('action', function ($data) {
                    if ($data->title == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {

                       return '<div class="table-actions"> 
                        <a href="'.url('slider/edit/'.$data['id']).'"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        <a href="'.url('slider/delete/'.$data['id']).'"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                        </div> ';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['image','action'])
                ->make(true);
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
            'heading' => 'required | string ',
            'slug' => 'required',
            'target' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            $slider_img = '';
            if($request->file('img'))
            {   
                $slider_img = file_upload($request,'img','storage/slider/');
            }
           // dd($input);
            $slider = Slider::create([
                'status' => $input['status'],
                'slug' => Str::slug($input['slug']),
                'heading' => $input['heading'],
                'target' => $input['target'],
                'ip' => $request->ip(),
                'created_by' => Auth::id(),
                'img' => $slider_img
            ]);
            return redirect()->back()->with('success', 'Slider information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Slider::find($id);
        if($record)
        {
            return view('slider.edit',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'heading' => 'required | string ',
            'target' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            $slider = Slider::find($request->id);
            $filename = '';
            if($request->file('img'))
            {   
                file_delete('storage/slider/',$slider->img);
                $filename = file_upload($request,'img','storage/slider/');
            }

            $slider = Slider::find($request->id);
            $data = array(
                'status' => $input['status'],
                'slug' => Str::slug($input['slug']),
                'heading' => $input['heading'],
                'target' => $input['target'],
                'ip' => $request->ip(),
                'created_by' => Auth::id()
            );
            if($filename !='')
            $data['img'] = $filename;

            $slider->update($data);
            return redirect()->back()->with('success', 'Slider information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        if ($slider) {
            file_delete('uploads/slider/',$slider->img);
            $slider->delete();

            return redirect()->back()->with('success', 'Slider removed!');
        } else {
            return redirect()->back()->with('error', 'Slider not found');
        }
    }
}
