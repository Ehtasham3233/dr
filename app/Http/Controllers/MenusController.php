<?php

namespace App\Http\Controllers;

use App\Models\menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = menus::get();
        return view('menu.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $menues = menus::where('status',1)->get();

        return view('menu.add', compact('menues'));
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
            'type' => 'required',
            'title' => 'required | string ',
            'slug' => 'required',
            'is_parent' => 'required'

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {   
            //dd($input);
            $menu = menus::create([
                'is_parent' => $input['is_parent'],
                'status' => $input['status'],
                'type' => $input['type'],
                'title' => $input['title'],
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
     * @param  \App\Models\menus  $menus
     * @return \Illuminate\Http\Response
     */
    public function show(menus $menus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\menus  $menus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = menus::find($id);
        if($record)
        {
            return view('menu.edit',compact("record"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\menus  $menus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, menus $menus)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'type' => 'required',
            'title' => 'required | string ',
            'slug' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try
        {   
           // dd($input);
            $menu = menus::find($request->id);
            $menu->update([
                'status' => $input['status'],
                'type' => $input['type'],
                'title' => $input['title'],
                'slug' => Str::slug($input['slug']),
                'ip' => $request->ip(),
                'updated_by' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'menus information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\menus  $menus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = menus::find($id);
        if ($menu) {
            $menu->delete();

            return redirect()->back()->with('success', 'menu removed!');
        } else {
            return redirect()->back()->with('error', 'menu not found');
        }
    }
}
