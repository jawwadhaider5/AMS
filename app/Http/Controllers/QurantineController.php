<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\System;
use App\Models\SystemSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QurantineController extends Controller
{
    public function index(){
        if (!auth()->user()->can('all qurantine')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $all_assets = Assets::with('category','subcategory')->where('status','qurantine')->whereNotNull('spread_category_id')->get();
        return view('backend_app.qurantine.index' ,compact('all_assets', 'current_sys'));
    }
    public function edit($id){
        if (!auth()->user()->can('edit qurantine')) {
            abort(403, 'Unauthorized Access.');
        }
        $assets = Assets::findOrFail($id);
        $assets->status = 'qurantine';
        $assets->update();
        return redirect()->route('all-assets')->with('success', 'Asset sent into Qurantine successfully!');
    }

}
