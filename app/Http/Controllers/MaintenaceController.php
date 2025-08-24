<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class MaintenaceController extends Controller
{
    public function index(){

        if (!auth()->user()->can('all maintenance')) {
            abort(403, 'Unauthorized Access.');
        } 
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        
        $all_assets = Assets::with('category','subcategory')->where('status','maintenance')->whereNotNull('spread_category_id')->get();
        return view('backend_app.maintenace.index' ,compact('all_assets', 'current_sys'));
    }

    public function edit($id){

        if (!auth()->user()->can('edit maintenance')) {
            abort(403, 'Unauthorized Access.');
        } 
       
        $assets = Assets::findOrFail($id);
        $assets->status = 'maintenance';
        $assets->update();
        return redirect()->back()->with('success', 'Qurantine Asset Move to Maintenance Assets!');
    }
    public function maintence_move($id){

        if (!auth()->user()->can('edit maintenance')) {
            abort(403, 'Unauthorized Access.');
        } 
       
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();
         
        $systems = System::with('systemtype')->get(); 
     
        $assets= Assets::where('id' ,$id)->with('category', 'subcategory')->first();
 
        return view('backend_app.maintenace.move_maintenance' , compact('assets','systems', 'current_sys'));
        
    } 

    public function assetsupdate(Request $request, $id)
    {

        $request->validate([
            'system_id' => 'required', 
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]); 

        $asset = Assets::findOrFail($id);
        $tasks = Task::where('asset_id', $asset->id)->get(); 

        $newsys = System::find($request->input('system_id')); 

        if ($newsys->id != $asset->spread_id) { 
            $asset->spread_id = $newsys->id;
            $asset->system_id = $newsys->system_type_id; 
        } 

        foreach ($tasks as $task) {
            $task->system_id = $newsys->id;
            $task->category_id = $request->input('category_id');
            $task->sub_category_id = $request->input('sub_category_id');
            $task->save();
        } 
        
        $asset->category_id = $request->input('category_id');
        $asset->sub_category_id = $request->input('sub_category_id');
        $asset->status = null;
        $result = $asset->update();


         if ($result) {
            return redirect()->route('maintenace')->with('success', 'Asset Transfer From maintenance successfully!');
        }
 
    }

    public function generate_pdf($id){

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 

        $system = System::with('systemtype')->where('system_type_id', $sysid->system_type_id)->first();

        $asset = Assets::where('id', $id)->whereNotNull('spread_category_id')->with('tasks')->first();
        $pdf = PDF::loadView('backend_app.maintenace.generate_pdf' ,compact('asset' ,'system'));
        
        return $pdf->stream('generate_pdf');
        
    }

}
