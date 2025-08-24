<?php

namespace App\Http\Controllers;

use App\Models\Spares;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\SystemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SparesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('all spare')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 

        $spares = Spares::with('system')->get(); 
        return view('backend_app.spares.index' ,compact('spares', 'current_sys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create spare')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 

        $systems = System::all(); 
        return view('backend_app.spares.create' ,compact('systems', 'current_sys'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create spare')) {
            abort(403, 'Unauthorized Access.');
        }
        $validator = Validator::make($request->all(), [
            'system_name' => 'required',
            'part_number' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please Filled All spares Field Validations!');
        }
        $spares = new Spares();
        $spares->system_name = $request->input('system_name');
        $spares->part_number = $request->input('part_number');
        $spares->description = $request->input('description');
        $spares->supplier = $request->input('supplier');
        $spares->supplier_part_number = $request->input('supplier_part_number');
        $spares->quantity = $request->input('quantity');
        $spares->critical_quantity =$request->input('critical_quantity');
        $result = $spares->save();
     
        if ($result) {
            return redirect()->route('all-spares')->with('success', 'Spares Added successfully!');
        }
    }


    public function ajax_add(Request $request, $id)
    {
        if (!auth()->user()->can('create spare')) {
            abort(403, 'Unauthorized Access.');
        }
        $validator = Validator::make($request->all(), [ 
            'part_number' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please Filled All spares Field Validations!');
        }
        $spares = new Spares();
        $spares->system_name = $request->input('system_name');
        $spares->part_number = $request->input('part_number');
        $spares->description = $request->input('description');
        $spares->supplier = $request->input('supplier');
        $spares->supplier_part_number = $request->input('supplier_part_number');
        $spares->quantity = $request->input('quantity');
        $spares->critical_quantity =$request->input('critical_quantity');
        $result = $spares->save();

       
 
        return redirect()->back()->with('success', 'Asset Added successfully!');
    }


    public function show(string $id)
    {
        if (!auth()->user()->can('view spare')) {
            abort(403, 'Unauthorized Access.');
        }
        
    }

    public function edit(Request $request, $id)
    {
        if (!auth()->user()->can('edit spare')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 

        $spare= Spares::where('id' ,$id)->first();
        $systems= System::all(); 
        return view('backend_app.spares.edit', compact('spare','systems', 'current_sys'));
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit spare')) {
            abort(403, 'Unauthorized Access.');
        }

        $validator = Validator::make($request->all(), [
            'system_name' => 'required',
            'part_number' => 'required',
            'description' => 'required',
        ]);

        $spares = Spares::findOrFail($id);
        $spares->system_name = $request->input('system_name');
        $spares->part_number = $request->input('part_number');
        $spares->description = $request->input('description');
        $spares->supplier = $request->input('supplier');
        $spares->supplier_part_number = $request->input('supplier_part_number');
        $spares->quantity = $request->input('quantity');
        $spares->critical_quantity =$request->input('critical_quantity');
        $result = $spares->update();

         if ($result) {
            return redirect()->route('all-spares')->with('success', 'Spares Updated successfully!');
        }
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete spare')) {
            abort(403, 'Unauthorized Access.');
        }
        Spares::where('id', $id)->delete();
        return redirect()->route('all-spares')->with('success', 'Spares Deleted successfully!');
    }
    

}