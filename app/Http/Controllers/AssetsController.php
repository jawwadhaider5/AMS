<?php

namespace App\Http\Controllers;

use App\Models\AllAssetFile;
use App\Models\AssetFile;
use App\Models\Assets;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Customer;
use App\Models\IMCAReference;
use App\Models\Locations;
use App\Models\PreTask;
use App\Models\Project;
use App\Models\Spares;
use App\Models\SpreadCategory;
use App\Models\SubCategory;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\Task;
use App\Models\TaskType;
use PDF;
use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 

class AssetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view asset', ['only' => ['index']]);
        $this->middleware('permission:create asset', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit asset', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete asset', ['only' => ['destroy']]);
    }

    public function index()
    {
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();

        // $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        // $all_assets =  Assets::where(['system_id' => $current_sys->system_type_id, 'spread_id' => $current_sys->id, 'status' => null])->with('category', 'subcategory')->get();
        $all_assets =  Assets::where(['status' => null])->with('category', 'subcategory')->get();

        // $categories = Category::where('parent_cat_id', $current_sys->system_type_id)->get();
        $categories = Category::all();

        $locations = Locations::all();

        // $spreadcategories = DB::select("SELECT sc.id as system_id, sc.system_description as system_name
        //         FROM `spread_category_types` as sct
        //         LEFT JOIN `spread_category` as sc 
        //         ON sc.id = sct.spread_category_id 
        //         GROUP BY sct.spread_category_id");

        // WHERE sct.category_id = $cat_id

        return view('backend_app.all_assets.all', compact('all_assets', 'current_sys', 'categories', 'locations'));
    }

    public function create()
    {
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $categories = Category::where('parent_cat_id', $sysid->system_type_id)->get();
        $subcategories = SubCategory::all();

        $locations = Locations::all();

        $spreadcategories = SpreadCategory::with('system', 'system.systemtype', 'system.location')->where("system_id", null)->get();

        //  echo json_encode($categories);
        return view('backend_app.all_assets.create', compact('categories', 'subcategories', 'locations', 'current_sys', 'spreadcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'manufacturer' => 'required',
            'system_modal' => 'required',
            'description' => 'required',
        ]);

        // if ($validator->fails()) {
        //     return redirect()->route('all-assets')->with('error', 'Please Filled All Asset Field Validations!');
        // }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        // $sysid->system_type_id

        $assets = new Assets();
        $assets->spread_category_id =  $request->input('system_id');
        $assets->category_id =  $request->input('category_id');
        $assets->sub_category_id =  $request->input('sub_category_id');
        $assets->system_id =  $sysid->system_type_id;
        $assets->spread_id =  $sysid->id;
        $assets->description = $request->input('description');
        $assets->manufacturer =  $request->input('manufacturer');
        $assets->system_modal = $request->input('system_modal');
        $assets->serial_no = $request->input('serial_no');
        $assets->location =  $request->input('location');
        $assets->own = $request->input('own');
        $assets->sefety_critical =  $request->input('sefety_critical');
        $assets->system_project =  $request->input('system_project');
        $assets->system_class =  $request->input('system_class');
        $assets->class_code =  $request->input('class_code');
        $assets->status =  $request->input('status');
        $result = $assets->save();

        $subcategory = SubCategory::where('id', $request->input('sub_category_id'))->with('tasktype')->first();

        $predefinetask = PreTask::where('task_type', $subcategory->tasktype->id)->get();

        if ($result) {
            foreach ($predefinetask as $value) {

                $tasktypes = TaskType::where('id', $value->task_type)->first();
                $task =  new Task();
                $task->system_id =  $sysid->id;
                $task->asset_id =  $assets->id;
                $task->category_id =  $request->input('category_id');
                $task->sub_category_id =  $request->input('sub_category_id');
                $task->task_type = $tasktypes->id;
                $task->spread_category_id = $request->input('system_id');

                $task->frequency = $value->frequency;
                $task->description = $value->description;
                // $task->imca_reference = $tasktypes->imca_reference_id;
                $result2 = $task->save();
            }
        }
        return redirect()->back()->with('success', 'Asset Added successfully!');
    }


    public function ajax_add(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'manufacturer' => 'required',
            'system_modal' => 'required',
            'description' => 'required',
        ]);

        // if ($validator->fails()) {
        //     return redirect()->route('all-assets')->with('error', 'Please Filled All Asset Field Validations!');
        // }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        // $sysid->system_type_id

        $spreadcategory = SpreadCategory::where('id', $request->input('system_id'))->first();

        $assets = new Assets();
        $assets->category_id =  $request->input('category_id');
        $assets->sub_category_id =  $request->input('sub_category_id');
        $assets->system_id =  $spreadcategory->system_type_id;
        $assets->spread_id =  $request->input('spread_id');
        $assets->spread_category_id =  $request->input('system_id');
        $assets->description = $request->input('description');
        $assets->manufacturer =  $request->input('manufacturer');
        $assets->system_modal = $request->input('system_modal');
        $assets->serial_no = $request->input('serial_no');
        //$assets->location =  $request->input('location');
        $assets->sefety_critical =  $request->input('sefety_critical');
        $assets->own = $request->input('own');
        //$assets->system_project =  $request->input('system_project');
        // $assets->system_class =  $request->input('system_class');
        //$assets->class_code =  $request->input('class_code'); 
        $assets->location =  $request->input('location');
        $result = $assets->save();

        // return json_encode($request->all());

        // $predefinetask = PreTask::where('sub_category_id', $request->input('sub_category_id'))->get();


        $subcategory = SubCategory::where('id', $request->input('sub_category_id'))->with('sheets')->first();


        foreach ($subcategory->sheets as $sheet) {
            $tasktpe = TaskType::find($sheet->task_type_id);
            $predefinetask = PreTask::where('task_type', $tasktpe->id)->get();
        }
        // else
        // {
        //     $predefinetask = [];
        // }



        // echo json_encode($subcategory);
        // echo "<br>";
        // echo json_encode($subcategory);


        // return 0;




        if ($result) {
            foreach ($predefinetask as $value) {

                $tasktypes = TaskType::where('id', $value->task_type)->first();
                $task =  new Task();

                $task->system_id =  $request->input('spread_id');
                $task->asset_id =  $assets->id;
                $task->category_id =  $request->input('category_id');
                $task->sub_category_id =  $request->input('sub_category_id');
                $task->task_type = $tasktypes->id;

                $task->spread_category_id = $request->input('system_id');
                $task->frequency = $value->frequency;
                $task->description = $value->description;
                $task->name = $value->name;
                $task->month_year = $value->month_year;
                $task->imca_reference = $value->imca_reference_id;
                $result2 = $task->save();
            }
        }
        return redirect()->back()->with('success', 'Asset Added successfully!');
    }


    public function ajax_add_without_system(Request $request)
    {
        $request->validate([
            // 'category_id' => 'required',
            // 'sub_category_id' => 'required',
            'manufacturer' => 'required',
            'system_modal' => 'required',
            'description' => 'required',
        ]);
 

        $assets = new Assets();
        // $assets->category_id =  $request->input('category_id');
        // $assets->sub_category_id =  $request->input('sub_category_id');
        $assets->system_id =  $request->input('spread_type_id');
        $assets->spread_id =  $request->input('spread_id');
        $assets->spread_category_id =  $request->input('system_id');
        $assets->description = $request->input('description');
        $assets->manufacturer =  $request->input('manufacturer');
        $assets->system_modal = $request->input('system_modal');
        $assets->serial_no = $request->input('serial_no');
        $assets->sefety_critical =  $request->input('sefety_critical');
        $assets->own = $request->input('own');
        // $assets->system_class =  $request->input('system_class');
        $assets->location =  $request->input('location');
        $result = $assets->save();

        // if ($request->input('system_id')) {
        //     $subcategory = SubCategory::where('id', $request->input('sub_category_id'))->with('sheets')->first();
        //     $predefinetask = [];

        //     foreach ($subcategory->sheets as $sheet) {
        //         $tasktpe = TaskType::find($sheet->task_type_id);
        //         $predefinetask = PreTask::where('task_type', $tasktpe->id)->get();
        //     }

        //     if ($result) {
        //         foreach ($predefinetask as $value) {

        //             $tasktypes = TaskType::where('id', $value->task_type)->first();
        //             $task =  new Task();

        //             $task->system_id =  $request->input('spread_id');
        //             $task->asset_id =  $assets->id;
        //             $task->category_id =  $request->input('category_id');
        //             $task->sub_category_id =  $request->input('sub_category_id');
        //             $task->task_type = $tasktypes->id;

        //             $task->spread_category_id = $request->input('system_id');
        //             $task->frequency = $value->frequency;
        //             $task->description = $value->description;
        //             $task->name = $value->name;
        //             $task->month_year = $value->month_year;
        //             $task->imca_reference = $value->imca_reference_id;
        //             $result2 = $task->save();
        //         }
        //     }
        // }
        return redirect()->back()->with('success', 'Asset Added successfully!');
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
    public function edit($id)
    {
        $asset = Assets::where('id', $id)->with('subcategory')->first();

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $locations = Locations::all();

        $categories = Category::where('parent_cat_id', $sysid->system_type_id)->with('subcategories')->get();
        $subcategories = [];
        // $categories = Category::all();
        // $subcategories = SubCategory::all();
        if ($asset->spread_category_id) {
            return view('backend_app.all_assets.edit', compact('asset', 'categories', 'subcategories', 'locations', 'current_sys'));
        } else {
            return view('backend_app.all_assets.edit2', compact('asset', 'categories', 'subcategories', 'locations', 'current_sys'));
        }
        

        
    }

    public function assignproject($id)
    {
        $projects = Project::all();
        $assets = Assets::where('id', $id)->first();
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        return view('backend_app.all_assets.assign_project', compact('assets', 'projects', 'current_sys'));
    }

    public function assign(Request $request, $id)
    {
        $category = Assets::findOrFail($id);
        $category->project_id = $request->input('project_id');
        $result = $category->update();
        if ($result) {
            return redirect()->back()->with('success', 'Project Assigned successfully!');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'manufacturer' => 'required',
            'system_modal' => 'required',
            'description' => 'required',
        ]);

        $assets = Assets::findOrFail($id);
        $assets->category_id =  $request->input('category_id');
        $assets->sub_category_id =  $request->input('sub_category_id');
        $assets->description = $request->input('description');
        $assets->manufacturer =  $request->input('manufacturer');
        $assets->system_modal = $request->input('system_modal');
        $assets->serial_no = $request->input('serial_no');
        $assets->location =  $request->input('location');
        $assets->sefety_critical =  $request->input('sefety_critical');
        $assets->own = $request->input('own');
        $assets->system_project =  $request->input('system_project');
        $assets->system_class =  $request->input('system_class');
        $assets->class_code =  $request->input('class_code');
        $result = $assets->update();
        if ($result) {
            return redirect()->back()->with('success', 'Asset updated successfully!');
        }
    }

    public function update2(Request $request, $id)
    {

        $request->validate([ 
            'manufacturer' => 'required',
            'system_modal' => 'required',
            'description' => 'required',
        ]);

        $assets = Assets::findOrFail($id); 
        $assets->description = $request->input('description');
        $assets->manufacturer =  $request->input('manufacturer');
        $assets->system_modal = $request->input('system_modal');
        $assets->serial_no = $request->input('serial_no');
        $assets->location =  $request->input('location');
        $assets->sefety_critical =  $request->input('sefety_critical'); 
        $assets->own = $request->input('own');
        $result = $assets->update();
        if ($result) {
            return redirect()->back()->with('success', 'Asset updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            
            $asset = Assets::find($id);
            AuditLog::where('asset_id', $asset->id)->delete();
            // Task::where('asset_id', $asset->id)->delete();

            $tasks = Task::where('asset_id', $asset->id)->get();
            foreach ($tasks as $task) {
                $task->asset_files()->delete();
            }
            Task::where('asset_id', $asset->id)->delete();
    
            $asset->delete();

            // return redirect('assets/subcategory/' . $subcat_id)->with('success', 'Asset delete successfully!');
            return redirect('assets/all')->with('success', 'Asset delete successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'This Asset can not be deleted now. Please first delete the task associated to it.');
        }
    }
    public function assetcategory($id)
    {

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $asset = Assets::where('id', $id)->first();

        if ($asset->spread_id != $session->system_id) {
            $session = SystemSession::updateOrCreate([
                'user_id'   => Auth::user()->id,
            ], [
                'system_id'   => $asset->spread_id,
            ]);
        }

        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        
        $subcategory_id = $asset->sub_category_id;
        $category_id =  $asset->category_id;
        $tasktypes = TaskType::all();
        $tasks = Task::with('tasktype')->with('asset_files')->with('spares')->where(['category_id' => $category_id, 'sub_category_id' => $subcategory_id, 'asset_id' => $asset->id])->get();

        $data = Assets::with('category', 'subcategory')
            // ->where('system_id', $sysid->system_type_id)
            ->where('spread_id', $sysid->id)
            ->where('sub_category_id', $subcategory_id)
            ->whereNull('status')
            ->whereNotNull('spread_category_id')
            ->get();
        $auditLogs = AuditLog::where(['asset_id' => $id])->with("tasktype")->get();
        $imcas = IMCAReference::all();

        $spares = Spares::where('system_name', $sysid->system_type_id)->get();
        // $assetfiles = AssetFile::where('system_id', $sysid->system_type_id)->get();


        // return json_encode($auditLogs);

        $urlcat = $category_id;
        $urlsubcat = $subcategory_id;


        return view('backend_app.all_assets.assets_category', compact('data', 'tasktypes', 'asset', 'tasks', 'auditLogs', 'imcas', 'spares', 'session', 'current_sys', 'urlcat', 'urlsubcat'));
    }

    public function all_subcategory_asset($id)
    {
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $subcategory = SubCategory::where('id', $id)->with('category')->first();
        $subcat_id = $subcategory->id;
        $cat_id = $subcategory->category->id;

        $spreadcategories = DB::select("SELECT sc.id as system_id, sc.system_description as system_name
                                        FROM `spread_category_types` as sct
                                        LEFT JOIN `spread_category` as sc 
                                        ON sc.id = sct.spread_category_id
                                        WHERE sct.category_id = $cat_id
                                        GROUP BY sct.spread_category_id");

        $locations = Locations::all();

        // echo json_encode($sysid);
        // echo json_encode("sub cat: " . $subcategory->id);
        // echo json_encode("cat: " . $subcategory->category->parent_cat_id);
        // return json_encode($spreadcategories);

        //dd( $session->system_id);
        $all_assets = Assets::where(['sub_category_id' => $id, 'spread_id' => $sysid->id, 'status' => null])->whereNotNull('spread_category_id')->with('category', 'subcategory', 'spreadcategory')->get();
        // $all_assets = Assets::where('spread_id', $sysid->id)->get();
        // echo json_encode($all_assets);
        return view('backend_app.all_assets.index', compact('all_assets', 'current_sys', 'id', 'subcategory', 'subcat_id', 'cat_id', 'spreadcategories', 'locations', 'sysid'));
    }


    public function tasktype($task_type_id)
    {
        // $tasktypes = TaskType::where('id', $task_type_id)->first();

        $tasktypes = PreTask::where('task_type', $task_type_id)->get();
        return response()->json($tasktypes);
    }

    public function storetask(Request $request)
    {
        // $tasktypes = TaskType::where('id' ,$request->input('task_type'))->first(); 

        // $task->task_type = $tasktypes->name;

        $pretasks =  $request->input('pretask');
        foreach ($pretasks as $pre) {
            $id = $pre['id'];
            $description = $pre['description'];
            $frequency = $pre['frequency'];
            $maintenance_notes = $pre['maintenance_notes'];

            $pt = PreTask::find($id);

            $task =  new Task();
            $task->category_id =  $request->input('category_id');
            $task->system_id =  $request->input('system_id');
            $task->asset_id =  $request->input('asset_id');
            $task->sub_category_id =  $request->input('sub_category_id');
            $task->task_type = $pt->task_type;
            $task->name = $pt->name;
            $task->month_year = $pt->month_year;
            $task->frequency = $frequency;
            $task->description = $description;
            $task->notes =  $maintenance_notes;
            $result = $task->save();
        }

        return redirect()->back()->with('success', 'Task Added successfully!');
    }



    public function updatetask(Request $request, $id)
    {
        $task = Task::with('tasktype')->where('id', $id)->first();
        $alreadystarted = $task->start_date ? true : false;
        $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        // $dynamicDays = $task->tasktype->expire_date;
        // $endDate = $startDate->copy()->addDays($dynamicDays);
        // $lastdate = $endDate->toDateString();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));

        // $task->task_type = $task->tasktype->id;
        $task->start_date =  $startDate;
        $task->expire_date =  $endDate;
        $task->frequency = $request->input('override') ? $request->input('frequency') : $task->frequency;
        $task->notes =  $request->input('notes');
        $result = $task->update();
        if ($result && $alreadystarted) {
            AuditLog::create([
                'task_type' => $task->tasktype->id,
                'task_id'   => $id,
                'asset_id'   => $task->asset_id,
                'user_id'  => Auth::user()->id,
                'new_notes' => $request->input('notes'),
            ]);
        }

        return redirect()->back()->with('success', 'Task updated successfully!');
    }
    public function renewtask(Request $request, $id)
    {

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        // $sysid->system_type_id

        //  dd($request->all());
        $task = Task::with('tasktype')->where('id', $id)->first();
        $startDate = Carbon::createFromFormat('Y-m-d', $request->input('renewtask_date'));
        $dynamicDays = 0;
        if ($task->month_year == 'month') {
            $dynamicDays = $task->frequency;
        } else {
            $dynamicDays = $task->frequency * 12;
        }

        // $endDate = $startDate->copy()->addDays($dynamicDays);

        $endDate = Carbon::createFromFormat('Y-m-d', $request->input('renewtask_date'))->addMonths($dynamicDays);
        $lastdate = $endDate->toDateString();

        $task->renew_notes = $request->input('newtask_notes');
        $task->renew_task_date = $request->input('renewtask_date');
        $task->start_date = $request->input('renewtask_date');
        $task->expire_date = $lastdate;
        $result = $task->update();

        if ($request->hasFile('attach_file')) {

            $request->validate([
                'attach_file' => 'required',
            ]);

            $files = $request->file('attach_file');
            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->put($filePath, file_get_contents($file));


                $assetFile = new AssetFile();
                $assetFile->file = $fileName;
                $assetFile->task_id = $task->id;
                $assetFile->save();
            }
        }

        $parts = $request->get('parts');
        if ($parts) {
            foreach ($parts as $part) {

                $newpart = new Spares();
                $newpart->task_id = $task->id;
                $newpart->part_number = $part['part_number'];
                $newpart->description = $part['description'];
                $newpart->supplier = $part['supplier'];
                $newpart->supplier_part_number = $part['supplier_part_number'];
                $newpart->quantity = $part['quantity'];
                $newpart->critical_quantity = $part['critical_quantity'];
                $newpart->save();
            }
        }

        if ($result) {

            AuditLog::create([
                'task_type' => $task->tasktype->id,
                'task_id'   => $id,
                'asset_id'   => $task->asset_id,
                'user_id'  => Auth::user()->id,
                'new_notes' => $request->input('newtask_notes'),
            ]);


            return redirect()->back()->with('success', 'Renew Task updated successfully!');
        }
    }

    public function delete_spare($id)
    {

        $spare = Spares::findOrFail($id);
        $spare->delete();
        return redirect()->back()->with('success', 'Spare Part Delete Successfully!');
    }

    public function uploadfile(Request $request, $id)
    {

        $task = Task::where('id', $id)->first();

        if ($request->hasFile('attach_file2')) {

            $request->validate([
                'attach_file2' => 'required',
            ]);


            // $file = $request->file('attach_file2');
            // $fileName = time() . '_' . $file->getClientOriginalName();
            // $filePath = 'uploads/' . $fileName;
            // Storage::disk('public')->put($filePath, file_get_contents($file));
            // $auth_id = Auth::user()->id;

            // $assetFile = new AssetFile();
            // $assetFile->file = $fileName;
            // $assetFile->task_id = $task->id;
            // $assetFile->save();

            $files = $request->file('attach_file2');
            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->put($filePath, file_get_contents($file));


                $assetFile = new AssetFile();
                $assetFile->file = $fileName;
                $assetFile->task_id = $task->id;
                $assetFile->save();
            }
        }
        return redirect()->back()->with('success', 'File Uploaded successfully!');
    }
    public function alluploadfile(Request $request, $id)
    {

        $asset = Assets::find($id);

        if ($request->hasFile('attach_file2')) {

            $request->validate([
                'attach_file2' => 'required',
            ]);
 

            $files = $request->file('attach_file2');
            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->put($filePath, file_get_contents($file));


                $assetFile = new AllAssetFile();
                $assetFile->file = $fileName;
                $assetFile->asset_id = $asset->id;
                $assetFile->save();
            }
        }
        return redirect()->back()->with('success', 'File Uploaded successfully!');
    }
    public function allfiledelete($id)
    {

        $file = AllAssetFile::findOrFail($id);
        $file->delete();
        return redirect()->back()->with('success', 'File Delete Successfully!');
    }
    public function delete_pdf($id)
    {

        $file = AssetFile::findOrFail($id);
        $file->delete();
        return redirect()->back()->with('success', 'File Delete Successfully!');
    }


    public function search(Request $request)
    {
        if (empty($request->search) && !$request->filled('status')) {
            return redirect()->route('dashboard');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $query = Assets::query();
        if (!empty($request->search)) {
            $query->where('description', 'like', '%' . $request->search . '%')
                ->whereNull('status')
                ->whereNotNull('spread_category_id');
        } else if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $all_assets = $query->get();
        return view('backend_app.all_assets.index', compact('all_assets', 'current_sys'));
    }

    public function qrcode($id)
    {
        $link = "https://assetmanagementsystem.website/assets/category/" . $id;
        return view('backend_app.all_assets.qrcode', compact('link', 'id'));
    }
    public function qrcodepdf($id)
    {
        $link = "https://assetmanagementsystem.website/assets/category/" . $id;
        $pdf = PDF::loadView('backend_app.all_assets.qrcodepdf', compact('link', 'id'));
        return $pdf->stream('generate_pdf');
    }

    public function getSystemModal(Request $request, $assetid)
    {
        $asset = Assets::find($assetid);
        $systems = DB::select("SELECT sc.id as system_id, sc.system_description as system_name
        FROM `spread_category_types` as sct
        LEFT JOIN `spread_category` as sc 
        ON sc.id = sct.spread_category_id 
        WHERE sct.category_id = $asset->category_id
        GROUP BY sct.spread_category_id");

        $session = SystemSession::where('user_id', Auth::user()->id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first(); 
        $categories = Category::where('parent_cat_id', $current_sys->system_type_id)->get();

        return view('backend_app.all_assets.assign_system_modal', compact('asset', 'systems', 'categories'))->render();
    }
    public function assetAssignSystem(Request $request)
    { 
        $assetid = $request->get('selected_asset');
        $system = SpreadCategory::find($request->input('system_id'));
        $asset = Assets::find($assetid);
        $asset->category_id = $request->input('category_id');
        $asset->sub_category_id = $request->input('sub_category_id');
        $asset->spread_category_id = $request->input('system_id');
        $asset->spread_id = $system->system_id;
        $asset->save();

        $subcategory = SubCategory::where('id', $asset->sub_category_id)->with('sheets')->first();
        $predefinetask = [];

        foreach ($subcategory->sheets as $sheet) {
            $tasktpe = TaskType::find($sheet->task_type_id);
            $predefinetask = PreTask::where('task_type', $tasktpe->id)->get();
        }

        foreach ($predefinetask as $value) {

            $tasktypes = TaskType::where('id', $value->task_type)->first();
            $task =  new Task();

            $task->system_id =  $asset->spread_id;
            $task->asset_id =  $asset->id;
            $task->category_id =  $asset->category_id;
            $task->sub_category_id =  $asset->sub_category_id;
            $task->task_type = $tasktypes->id;

            $task->spread_category_id = $request->input('system_id');
            $task->frequency = $value->frequency;
            $task->description = $value->description;
            $task->name = $value->name;
            $task->month_year = $value->month_year;
            $task->imca_reference = $value->imca_reference_id;
            $result2 = $task->save();
        }

        return redirect('assets/all');
    }

    public function assetUnAssignSystem($assetid)
    {  
        $asset = Assets::find($assetid);

        AuditLog::where('asset_id', $asset->id)->delete();
        $tasks = Task::where('asset_id', $asset->id)->get();

        foreach ($tasks as $task) {
            $task->asset_files()->delete();
        }
        Task::where('asset_id', $asset->id)->delete();

        $asset->category_id = null;
        $asset->sub_category_id = null;
        $asset->spread_category_id = null;
        $asset->save();

        return redirect('assets/all');
    }

    public function showAssignProjectForm(Request $request)
    {
        $selectedAssets = $request->input('items');

        $projects = Project::all();
        return view('backend_app.all_assets.assign_project_form', compact('selectedAssets', 'projects'));
    }

    public function assignBulkProject(Request $request)
    {
        $selectedAssets = json_decode($request->input('selected_assets'), true);
        $projectId = $request->input('project_id');

        foreach ($selectedAssets as $assetId) {
            $asset = Assets::find($assetId);
            $asset->project_id = $projectId;
            $asset->save();
        }
        return redirect()->back()->with('success', 'System Asset Added successfully!');
    }

    public function assets_active(Request $request, $id)
    {
        $asset = Assets::where('id', $id)->first();
        $asset->system_status = $request->status;
        $asset->update();
        return redirect()->back()->with('success', 'Asset Status Updated successfully!');
    }

    public function deactivate_task(Request $request, $id)
    {
        $task = Task::find($id);
        $task->active = 0;
        $task->update();
        $logs = auditlog::where('task_id', $task->id)->get();
        foreach ($logs as $log) {
            $log->active = 0;
            $log->save();
        }
        return redirect()->back()->with('success', 'Task Deactivated Successfully!');
    }

    public function reactivate_task(Request $request, $id)
    {
        $task = Task::find($id);
        $task->active = 1;
        $task->update();
        $logs = auditlog::where('task_id', $task->id)->get();
        foreach ($logs as $log) {
            $log->active = 1;
            $log->save();
        }
        return redirect()->back()->with('success', 'Task Re-activated Successfully!');
    }

    public function generate_pdf($id)
    {

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        // $sysid->system_type_id

        $system = System::with('systemtype')->where('system_type_id', $sysid->system_type_id)->first();

        $auditLog = AuditLog::where('id', $id)->with('task', 'asset', 'asset.assetlocation')->first();

        $pdf = PDF::loadView('backend_app.all_assets.generate_pdf', compact('auditLog', 'system'));

        return $pdf->stream('generate_pdf');

        dd($auditLog);
    }

    public function auditlog($id)
    {

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $system = System::with('systemtype')->where('system_type_id', $sysid->system_type_id)->first();

        $auditLog = AuditLog::where('id', $id)->with('task', 'asset', 'asset.assetlocation')->first();

        // return json_encode($auditLog->asset->assetlocation);

        return view('backend_app.all_assets.audit_log', compact('auditLog', 'system', 'current_sys'));
        // $pdf = PDF::loadView('backend_app.all_assets.generate_pdf' ,compact('auditLog' ,'system'));

        // return $pdf->stream('generate_pdf');

        // dd($auditLog);

    }

    public function transferassets($id)
    {
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $systems = System::with('systemtype')->get();

        $assets = Assets::where('id', $id)->with('category', 'subcategory')->first();
        return view('backend_app.all_assets.transfer_asset', compact('assets', 'systems', 'current_sys'));
    }
    public function updatetransferasset(Request $request, $id)
    {

        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'system_id' => 'required',
        ]);


        $asset = Assets::findOrFail($id);
        $tasks = Task::where('asset_id', $asset->id)->get();

        $newsys = System::find($request->input('system_id'));

        if ($newsys->id != $asset->spread_id) {
            $asset->spread_id = $newsys->id;
            $asset->system_id = $newsys->system_type_id;
        }

        foreach ($tasks as $task) {
            $task->system_id = $request->input('system_id');
            $task->category_id = $request->input('category_id');
            $task->sub_category_id = $request->input('sub_category_id');
            $task->save();
        }

        $asset->category_id = $request->input('category_id');
        $asset->sub_category_id = $request->input('sub_category_id');
        $result = $asset->update();

        if ($result) {
            return redirect()->back()->with('success', 'System Transfer successfully!');
        }
    }
}
