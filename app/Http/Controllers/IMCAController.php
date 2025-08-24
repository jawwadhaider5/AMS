<?php

namespace App\Http\Controllers;

use App\Models\IMCAReference;
use App\Models\System;
use App\Models\SystemSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IMCAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('all imca reference')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();


        $imcas = IMCAReference::all();
        return view('backend_app.imcareference.index', compact('imcas', 'current_sys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create imca reference')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        return view('backend_app.imcareference.create', compact('current_sys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create imca reference')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            'name' => 'required',
        ]);
        $imca = new IMCAReference();
        $imca->name = $request->input('name');
        $result = $imca->save();

        if ($result) {
            return redirect()->route('all-imca')->with('success', 'IMCA Reference Added successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('view imca reference')) {
            abort(403, 'Unauthorized Access.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('edit imca reference')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $imca = IMCAReference::where('id', $id)->first();
        return view('backend_app.imcareference.edit', compact('imca', 'current_sys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit imca reference')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'name' => 'required',
        ]);

        
        $imca = IMCAReference::findOrFail($id);
        $imca->name = $request->input('name');
        $result = $imca->update();

        if ($result) {
            return redirect()->route('all-imca')->with('success', 'IMCA Reference Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete imca reference')) {
            abort(403, 'Unauthorized Access.');
        }
        try {
            IMCAReference::where('id', $id)->delete();
            return redirect()->route('all-imca')->with('success', 'IMCA Reference Deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('all-imca')->with('error', 'IMCA Reference can not be deleted!');
        }
    }
}
