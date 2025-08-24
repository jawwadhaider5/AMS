<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\System;
use App\Models\SystemSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('setting')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();



        $data=Setting::find(1);
        return view('backend_app.setting.index',compact('data', 'current_sys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {


        if (!auth()->user()->can('setting')) {
            abort(403, 'Unauthorized Access.');
        }

        try {
        $check=Setting::where('id',1)->first();
        if($check === null){
            $data=new Setting;

            $data->company_name=$request->name;
            $data->email=$request->email;
            $data->phone_no=$request->phone_no;
            $data->address=$request->address;
            $data->meta_title=$request->meta_title;
            $data->meta_description=$request->meta_description;
            if ($request->hasFile('logo')){
                $image=$request->file('img');
                $imagename=$request->file('img')->getClientOriginalName();
                $destinationpath=public_path('assets/logo/');
                $image->move($destinationpath,$imagename);
                $data->logo=$imagename;
               }
               if ($request->hasFile('fav_icon')){
                $image=$request->file('fav_icon');
                $fav_icon_name=$request->file('fav_icon')->getClientOriginalName();
                $destinationpath=public_path('assets/fav_icon/');
                $image->move($destinationpath,$fav_icon_name);
                $data->fav_icon=$fav_icon_name;
               }
            $data->save();
            return back()->with('success','Setting has been updated successfully');
        }
       else{
        $check->company_name=$request->name;
        $check->email=$request->email;
        $check->phone_no=$request->phone_no;
        $check->address=$request->address;
        $check->meta_title=$request->meta_title;
        $check->meta_description=$request->meta_description;
        if ($request->hasFile('logo')){
            $image=$request->file('logo');
            $imagename=$request->file('logo')->getClientOriginalName();
            $destinationpath=public_path('assets/logo/');
            $image->move($destinationpath,$imagename);
            $check->logo=$imagename;
           }
           if ($request->hasFile('fav_icon')){

            $image=$request->file('fav_icon');
            $fav_icon_name=$request->file('fav_icon')->getClientOriginalName();
            $destinationpath=public_path('assets/fav_icon/');
            $image->move($destinationpath,$fav_icon_name);
            $check->fav_icon=$fav_icon_name;

           }
        $check->save();
        return back()->with('success','Setting has been updated successfully');
    }
        }
       catch (\Throwable $th) {
        return back()->with('error',$th->getMessage());
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
