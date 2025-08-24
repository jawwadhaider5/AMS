<?php

namespace App\Http\Controllers;

use App\Models\IMCAReference;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\TaskType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskTypeController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('all task type')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 


        $tasktypes = TaskType::with('imca')->get(); 
       // dd($tasktypes)
        return view('backend_app.tasktype.index' ,compact('tasktypes', 'current_sys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create task type')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 

        $imca = IMCAReference::all(); 
        return view('backend_app.tasktype.create' , compact('imca', 'current_sys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create task type')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            'task_type' => 'required',
            'imca_reference_id' => 'required',
            'frequency' => 'required',
            'expire_date' => 'required',
        ]);
       
        $tasktype = new TaskType();
        $tasktype->name = $request->input('task_type');
        $tasktype->imca_reference_id = $request->input('imca_reference_id');
        $tasktype->frequency = $request->input('frequency');
        $tasktype->description = $request->input('description');
        $tasktype->expire_date = $request->input('expire_date');
        $result = $tasktype->save();
     
        if ($result) {
            return redirect()->route('all-tasktype')->with('success', 'Task Type  Added successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('view task type')) {
            abort(403, 'Unauthorized Access.');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('edit task type')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 


        $imca = IMCAReference::all(); 
        $tasktype= TaskType::where('id' ,$id)->first();
        return view('backend_app.tasktype.edit', compact('tasktype' ,'imca', 'current_sys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit task type')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'task_type' => 'required',
            'imca_reference_id' => 'required',
            'frequency' => 'required',
            'expire_date' => 'required',
        ]);

        
        $tasktype = TaskType::findOrFail($id);
        $tasktype->name = $request->input('task_type');
        $tasktype->frequency = $request->input('frequency');
        $tasktype->description = $request->input('description');
        $tasktype->expire_date = $request->input('expire_date');
        $tasktype->imca_reference_id = $request->input('imca_reference_id');
        
        $result = $tasktype->update();

         if ($result) {
            return redirect()->route('all-tasktype')->with('success', 'Task Type Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete task type')) {
            abort(403, 'Unauthorized Access.');
        }
        
        try {
            TaskType::where('id', $id)->delete();
        return redirect()->route('all-tasktype')->with('success', 'TaskType Deleted successfully!');
        } catch (Exception $e) { 
        return redirect()->route('all-tasktype')->with('error', 'TaskType can not be deleted!');
        }
    }

}
