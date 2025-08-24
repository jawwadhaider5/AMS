<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use App\Models\Project ;
use App\Models\System;
use App\Models\SystemSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {

        if (!auth()->user()->can('all project')) {
            abort(403, 'Unauthorized Access.');
        } 
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $allprojects = Project::with('system', 'locationdata', 'assets')->whereNull('start_date')->get(); 


        $liveprojects = Project::with('system', 'locationdata', 'assets')->whereNotNull('start_date')->whereNull('end_date')->get(); 
        $closedprojects = Project::with('system', 'locationdata', 'assets')->whereNotNull('start_date')->whereNotNull('end_date')->get(); 
         

        return view('backend_app.project.index' ,compact('allprojects', 'liveprojects' ,'closedprojects', 'current_sys'));
    }

    public function create()
    {
        if (!auth()->user()->can('create project')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();
         
        $systems = System::where('system_type_id', $sysid->system_type_id)->with('systemtype')->get(); 
        $locations = Locations::all();

        // $systems= System::with('systemtype')->get(); 
        return view('backend_app.project.create' ,compact('systems', 'locations', 'current_sys'));
    }

    public function store(Request $request)
    {

        if (!auth()->user()->can('create project')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
            'system_id' => 'required', 
            'location_id' => 'required',
        ]);
        $project = new Project();
        $project->project_name = $request->input('project_name');
        $project->spread_id = $request->input('system_id');
        $project->client_name = $request->input('client_name');
        // $project->start_date = $request->input('start_date');
        // $project->end_date = $request->input('end_date');
        $project->location = $request->input('location_id');
        $project->description = $request->input('description');
        $result = $project->save();
        if ($result) {
            return redirect()->route('all-projects')->with('success', 'Project  Added successfully!');
        }
    }

    public function show(string $id)
    {
        if (!auth()->user()->can('view project')) {
            abort(403, 'Unauthorized Access.');
        }

        
    }

    public function edit(string $id)
    {

        if (!auth()->user()->can('edit project')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();
         
        $systems = System::where('system_type_id', $sysid->system_type_id)->with('systemtype')->get(); 
        $locations = Locations::all();
  
        $project= Project::where('id' ,$id)->first();
        return view('backend_app.project.edit', compact('project' , 'systems', 'locations', 'current_sys'));
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit project')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
            'system_id' => 'required', 
            'location_id' => 'required',
        ]);
        

        $project = Project::findOrFail($id);
        $project->project_name = $request->input('project_name');
        $project->spread_id = $request->input('system_id');
        $project->client_name = $request->input('client_name');
        // $project->start_date = $request->input('start_date');
        // $project->end_date = $request->input('end_date');
        $project->location = $request->input('location_id');
        $project->description = $request->input('description');
        $result = $project->save();
        $result = $project->update();

         if ($result) {
            return redirect()->route('all-projects')->with('success', 'project Updated successfully!');
        }
    }


    public function start(Request $request, string $id)
    {
        if (!auth()->user()->can('edit project')) {
            abort(403, 'Unauthorized Access.');
        } 

        $project = Project::findOrFail($id); 
        $project->start_date = now(); 
        $result = $project->save(); 

         if ($result) {
            return redirect()->route('all-projects')->with('success', 'project Started successfully!');
        }
    }

    public function close(Request $request, string $id)
    {
        if (!auth()->user()->can('edit project')) {
            abort(403, 'Unauthorized Access.');
        } 

        $project = Project::findOrFail($id); 
        $project->end_date = now(); 
        $result = $project->save(); 

         if ($result) {
            return redirect()->route('all-projects')->with('success', 'project Closed successfully!');
        }
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete project')) {
            abort(403, 'Unauthorized Access.');
        }

        // $pro = Project::where('id', $id)->with('assets')->first();

        // return json_encode(count($pro->assets));
        // if (count($pro->assets) > 0) {
        //     return redirect()->route('all-projects')->with('error', 'You can not delete this project. Some Assets are using this project');
        // }else
        // {
        //     Project::where('id', $id)->delete();
        //     return redirect()->route('all-projects')->with('success', 'Project Deleted successfully!');
        // }

        try {
            Project::where('id', $id)->delete();
            return redirect()->route('all-projects')->with('success', 'Project Deleted successfully!');
        } catch (Exception $e ) { 
            return redirect()->route('all-projects')->with('error', 'Project can not be deleted');
        }
        
    }

}
