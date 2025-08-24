<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\AuditLog;
use App\Models\Locations;
use App\Models\Project;
use App\Models\SpreadCategoryType;
use App\Models\System;
use App\Models\SystemType;
use App\Models\SystemSession;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{

    public function index()
    {
        if (!auth()->user()->can('all spread')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first(); 
        $systems = System::with('systemtype')->withCount('spreadcategorytype')->with('assets')->get();
 

        $systemtypes = SystemType::all();

        foreach ($systems as $system) {
            if (count($system->assets) > 0) {
                $certified_count = $expired_count = $expiring_count = $incomplete_count = 0;

                foreach ($system->assets as $asset) {
                    // echo json_encode("Assets id: " . $asset->id . "  ===  asset status: " . $asset->status() . '<br>');
                    // $system['status'] = $asset->status() ? $asset->status() : 'Incomplete';

                    if ($asset->status() == 'Certified') {
                        $certified_count++;
                    } else if ($asset->status() == 'Expired') {
                        $expired_count++;
                    } else if ($asset->status() == 'Expiring') {
                        $expiring_count++;
                    } else if ($asset->status() == 'Incomplete') {
                        $incomplete_count++;
                    } else {
                        $incomplete_count++;
                    }
                    $temptask = new Task();
                    $statusLabel = $temptask->statusLabel($certified_count, $expired_count, $expiring_count, $incomplete_count);

                    $system['status'] = $statusLabel;
                }
            } else {
                $system['status'] = 'Incomplete';
            }
        }
        // return json_encode($system);
        // return 0;
        return view('backend_app.system.index', compact('systems', 'systemtypes', 'session', 'current_sys'));
    }


    public function create()
    {
        if (!auth()->user()->can('create spread')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 


        $systemtypes = SystemType::all();
        $locations = Locations::all();
        return view('backend_app.system.create', compact('systemtypes', 'locations', 'current_sys'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create spread')) {
            abort(403, 'Unauthorized Access.');
        }

        //  dd($request->all());
        $request->validate([
            'system_name' => 'required',
            'system_type_id' => 'required',
            // 'system_description' => 'required',
        ]);

        $system = new System();
        $system->system_name = $request->input('system_name');
        $system->system_type_id = $request->input('system_type_id');
        $system->system_description = $request->input('system_description');
        $result = $system->save();

        if ($result) {
            return redirect()->route('all-system')->with('success', 'Spread  Added successfully!');
        }
    }


    public function show(string $id)
    {
        if (!auth()->user()->can('view spread')) {
            abort(403, 'Unauthorized Access.');
        }
    }

    public function edit(string $id)
    {
        if (!auth()->user()->can('edit spread')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 

        $system = System::where('id', $id)->first();
        $systemtypes = SystemType::all();
        $locations = Locations::all();
        return view('backend_app.system.edit', compact('system', 'systemtypes', 'locations', 'current_sys'));
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit spread')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'system_name' => 'required',
            'system_type_id' => 'required',
            // 'system_description' => 'required',
        ]);
        
        $system = System::findOrFail($id);
        $system->system_name = $request->input('system_name');
        $system->system_type_id = $request->input('system_type_id');
        $system->system_description = $request->input('system_description');
        $result = $system->update();

        if ($result) {
            return redirect()->route('all-system')->with('success', 'Spread Updated successfully!');
        }
    }

public function destroy(string $id)
    {
        if (!auth()->user()->can('delete spread')) {
            abort(403, 'Unauthorized Access.');
        }
        // $spread = System::where('id', $id)->with('spreadcategory', 'spreadcategorytype', 'assets', 'projects', 'tasks', 'location', 'systemtype')->get();

        //
        

        try {

            if ($id == 1) {
                return redirect()->route('all-system')->with('error', 'This spread Can not be deleted!');
            }
            $auth_id = Auth::user()->id;
            $session = SystemSession::where('user_id', $auth_id)->first();

            $sessions = SystemSession::all();

            if ($session->system_id == $id) {
                $session->system_id = 1;
                $session->save();
            }
            

            foreach ($sessions as $ses) {
                if ($ses->system_id == $id) {
                    $ses->system_id = 1;
                    $ses->save();
                }
            }

            
            $sys = System::find($id);

            $assets = Assets::where('spread_id', $sys->id)->get();
    
            foreach ($assets as $asset ) { 
                $tasks = Task::where('asset_id', $asset->id)->get();
                foreach ($tasks as $task ) {
                    $task->system_id = null;
                    $task->save();
                    // AuditLog::where('task_id', $task->id)->delete();
                }
                // Task::where('asset_id', $asset->id)->delete(); 
                // $asset->system_id = null;
                $asset->spread_id = null;
                $asset->save();

            }
            // Assets::where('spread_id', $sys->id)->delete();  


            
            foreach ($sys->spreadcategory as $spcat) {
             
                $assets = Assets::where('spread_category_id', $spcat->id)->get();
    
                foreach ($assets as $asset ) { 
                    $tasks = Task::where('asset_id', $asset->id)->get();
                    foreach ($tasks as $task ) {
                        $task->system_id = null;
                        $task->save();
                        // AuditLog::where('task_id', $task->id)->delete();
                    }
                    // Task::where('asset_id', $asset->id)->delete(); 
                    // $asset->system_id = null;
                    $asset->spread_id = null;
                    $asset->save();
                }
                // Assets::where('spread_category_id', $spcat->id)->delete(); 
                // SpreadCategoryType::where('spread_category_id', $spcat->id)->delete();
                $spcat->system_id = null;
                $spcat->save();
            }



            Project::where('spread_id', $sys->id)->delete();
            $sys->delete();


        } catch (Exception $e) {
            
            return redirect()->route('all-system')->with('error', 'This spread Can not be deleted now! First delete its childs'.json_encode($e));
            
        }

        return redirect()->route('all-system')->with('success', 'Spread Deleted successfully!');
    }
}