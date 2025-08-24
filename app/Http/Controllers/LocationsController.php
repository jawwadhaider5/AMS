<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use App\Models\Project;
use App\Models\System;
use App\Models\SystemSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationsController extends Controller
{
 
    public function index()
    {
        if (!auth()->user()->can('all location')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $locations = Locations::all(); 
        return view('backend_app.locations.index' ,compact('locations', 'current_sys'));
    }

    public function create()
    {
        if (!auth()->user()->can('create location')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        return view('backend_app.locations.create', compact('current_sys'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create location')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            'name' => 'required',
        ]);
       
        $locations = new Locations();
        $locations->name = $request->input('name');
        $result = $locations->save();
     
        if ($result) {
            return redirect()->route('all-locations')->with('success', 'Locations Added successfully!');
        }
    }

   
    public function show(string $id)
    {
        if (!auth()->user()->can('view location')) {
            abort(403, 'Unauthorized Access.');
        }
    }

    public function edit(string $id)
    {
        if (!auth()->user()->can('edit location')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $locations= Locations::where('id' ,$id)->first();
        return view('backend_app.locations.edit', compact('locations', 'current_sys'));
    }


    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit location')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'name' => 'required',
        ]);

        
        $locations = Locations::findOrFail($id);
        $locations->name = $request->input('name');
        $result = $locations->update();

         if ($result) {
            return redirect()->route('all-locations')->with('success', 'locations Updated successfully!');
        }
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete location')) {
            abort(403, 'Unauthorized Access.');
        }
        // $loc = Locations::where('id',$id)->with('projects')->first(); 
        // return json_encode($loc);
        // if (count($loc->projects) > 0) {
        //     return redirect()->route('all-locations')->with('error', 'You can not delete this location. Some projects are using this location');
        // } else {
        //     Locations::where('id', $id)->delete();
        //     return redirect()->route('all-locations')->with('success', 'locations Deleted successfully!');
        // }

        try {
            Locations::where('id', $id)->delete();
            return redirect()->route('all-locations')->with('success', 'locations Deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('all-locations')->with('error', 'locations can not be deleted!');
        }
        
        
    }
       
}
