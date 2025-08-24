<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PreTask;
use App\Models\SubCategory;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\SystemType;
use App\Models\TaskType;
use Exception;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PreTaskController extends Controller
{

    public function index()
    {
        if (!auth()->user()->can('all pre define task')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();
        // $pretasks = PreTask::with('tasktype', 'subcategory', 'system_type_name')->get();  

        $tasktypes = TaskType::all();


        return view('backend_app.pretask.index', compact('tasktypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create pre define task')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $data['systemtypes'] = SystemType::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = SubCategory::all();
        $data['tasktypes'] = TaskType::all();
        return view('backend_app.pretask.create', compact('data', 'current_sys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create pre define task')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            // 'system_type' => 'required',
            'component' => 'required|array',
            'component.*.sub-component' => 'required|array'
        ], [
            'component.*.sub-component' => 'At least one Pre Defined task is required',
            // 'system_type' => 'System Type is required',
            'component' => 'At least one Sheet Number is required',
        ]);


        DB::beginTransaction();

        try {


            // $systemtype = $request->input('system_type'); 

            $components = $request->get('component');

            foreach ($components as $key => $com) {
                $sheet_number = $com['sheet_number'];
                $taskType = new TaskType();
                $taskType->name = $sheet_number;
                // $taskType->imca_reference_id = $systemtype;
                $tt = $taskType->save();

                $pretasks = $com['sub-component'];
                foreach ($pretasks as $task) {
                    $name =  $task['task_name'];
                    $description = $task['task_description'];
                    $frequency = $task['task_frequency'];
                    $month_year = $task['month_year'];
                    $expire_date = 0;

                    if ($month_year == "month") {
                        $expire_date = $frequency * 30;
                    } else if ($month_year == "year") {
                        $expire_date = $frequency * 30 * 12;
                    }

                    $pretask = new PreTask();
                    // $pretask->system_type = $systemtype;
                    $pretask->task_type = $taskType->id;
                    $pretask->name = $name;
                    $pretask->description = $description;
                    $pretask->expire_date = $expire_date;
                    $pretask->month_year = $month_year;
                    $pretask->frequency = $frequency;
                    $scr = $pretask->save();
                }
            }

            DB::commit();

            return ['success' => 1, 'message' => 'Predefined Tasks Added successfully!'];
        } catch (Exception $e) {
            DB::rollBack();

            return ["success"=>0, 'message' => 'Something went wrong!'];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('view pre define task')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();


        $tasktype = TaskType::where('id', $id)->with('predefinedtasks')->first();


        return view('backend_app.pretask.show', compact('tasktype', 'current_sys'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('edit pre define task')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();

        $tasktype = TaskType::where('id', $id)->with('predefinedtasks')->first();


        return view('backend_app.pretask.edit', compact('tasktype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // if (!auth()->user()->can('edit pre define task')) {
        //     abort(403, 'Unauthorized Access.');
        // }


        // $pretask = PreTask::findOrFail($id);

        // $month_year = $request->input('month_year');
        // $frequency = $request->input('frequency');
        // $expire_date = 0;

        // if ($month_year == "month") {
        //     $expire_date = $frequency * 30;
        // } else if ($month_year == "year"){
        //     $expire_date = $frequency * 30 * 12;
        // } 


        // $pretask->name = $request->input('name');
        // $pretask->description = $request->input('description');
        // $pretask->frequency = $request->input('frequency');
        // $pretask->month_year = $request->input('month_year');
        // $pretask->expire_date = $expire_date;

        // $result = $pretask->update();

        //  if ($result) {
        //     return redirect()->route('all-pretask')->with('success', 'Pre Task Updated successfully!');
        // }


        if (!auth()->user()->can('edit pre define task')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            // 'system_type' => 'required',
            'component' => 'required|array',
        ], [
            'component' => 'At least one Task is required',
        ]);


        DB::beginTransaction();

        try {

            $tasktype = TaskType::findOrFail($id);
            $tasktype->name = $request->input('sheet_number');
            $tt = $tasktype->save();

            $components = $request->get('component');

            $com_exists = [];
            foreach ($components as $com) {

                $edit = $com['edit'];


                if ($edit == 1) {

                    $name =  $com['name'];
                    $description = $com['description'];
                    $frequency = $com['frequency'];
                    $month_year = $com['month_year'];
                    $expire_date = 0;
                    

                    if ($month_year == "month") {
                        $expire_date = $frequency * 30;
                    } else if ($month_year == "year") {
                        $expire_date = $frequency * 30 * 12;
                    }

                    $pretask_id = $com['pretask_id'];

                    $com_exists[] = $pretask_id;

                    $pre = PreTask::find($pretask_id);
                    $pre->name = $name;
                    $pre->description = $description;
                    $pre->expire_date = $expire_date;
                    $pre->month_year = $month_year;
                    $pre->frequency = $frequency;
                    $scr = $pre->save();
                } else {

                    $name =  $com['name'];
                    $description = $com['description'];
                    $frequency = $com['frequency'];
                    $month_year = $com['month_year'];
                    $expire_date = 0;

                    if ($month_year == "month") {
                        $expire_date = $frequency * 30;
                    } else if ($month_year == "year") {
                        $expire_date = $frequency * 30 * 12;
                    }

                    $pre = new PreTask();
                    $pre->task_type = $tasktype->id;
                    $pre->name = $name;
                    $pre->description = $description;
                    $pre->expire_date = $expire_date;
                    $pre->month_year = $month_year;
                    $pre->frequency = $frequency;
                    $scr = $pre->save();

                    $com_exists[] = $pre->id;

                }
            }


            $deletecom = PreTask::where('task_type', $tasktype->id)->whereNotIn('id', $com_exists)->get();

            foreach ($deletecom as $pretsk) {
                $pretsk->delete();
            }


            DB::commit();

            return redirect()->route('all-pretask')->with('success', 'Predefined Tasks Updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();


            return redirect()->route('all-pretask')->with('error', '1Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete pre define task')) {
            abort(403, 'Unauthorized Access.');
        }
        try {
            $tasktype = TaskType::where('id', $id)->with('predefinedtasks')->first();
            foreach ($tasktype->predefinedtasks as $pre) {
                $pre->delete();
            }
            $tasktype->delete();
            return redirect()->route('all-pretask')->with('success', 'PreTask Deleted successfully!');

        } catch (Exception $e) {
            return redirect()->route('all-pretask')->with('error', 'PreTask can not be Deleted!');
        }

        
    }
}