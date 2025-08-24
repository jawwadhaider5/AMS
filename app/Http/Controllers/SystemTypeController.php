<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Project;
use App\Models\SpreadCategory;
use App\Models\SpreadCategoryType;
use App\Models\SubCategory;
use App\Models\SubSheet;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\SystemType;
use App\Models\Task;
use App\Models\TaskType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SystemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!auth()->user()->can('all spread type')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();


        $systemtypes = SystemType::all();
        // return json_encode($systemtypes);

        return view('backend_app.systemtype.index', compact('systemtypes', 'current_sys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create spread type')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();
        $sheets = TaskType::all();
        // ->pluck('id', 'name');


        return view('backend_app.systemtype.create', compact('current_sys', 'sheets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create spread type')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            'system_type' => 'required|unique:system_types,name',
            'component' => 'required|array',
            'component.*.sub-component' => 'required|array'
        ], [
            'component.*.sub-component' => 'At least one sub component is required',
            'system_type' => 'System Type is required',
            'system_type.unique' => 'System Type already exists',
            'component' => 'At least one component is required',
        ]);


        DB::beginTransaction();

        try {


            $systemtype = new SystemType();
            $systemtype->name = $request->input('system_type');
            $sr = $systemtype->save();

            $components = $request->get('component');

            foreach ($components as $key => $com) {
                $comid = $com['id'];
                $comname = $com['name'];

                $category = new Category();
                $category->parent_cat_id = $systemtype->id;
                $category->name = $comname;
                $category->display_id = $comid;
                $category->description = "";
                $category->added_by = Auth::user()->id;
                $cr = $category->save();


                $subcomponents = $com['sub-component'];
                foreach ($subcomponents as $sub) {
                    $subid =  $sub['id'];
                    $subname = $sub['name'];
                    $sheet_numbers = $sub['sheet_number'];

                    
 
                    $subcategory = new SubCategory();
                    $subcategory->category_id = $category->id;
                    $subcategory->name = $subname;
                    // $subcategory->sheet_number = $sheet_number;
                    $subcategory->display_id = $subid;
                    $subcategory->description = "";
                    $subcategory->added_by = Auth::user()->id;
                    $scr = $subcategory->save();

                    foreach ($sheet_numbers as $sheet) {

                        $newsheet = new SubSheet();
                        $newsheet->task_type_id = $sheet;
                        $newsheet->sub_category_id = $subcategory->id;
                        $newsheet->save();
                        // SubSheet::create($newsheet);
                    }
                }
            }

            DB::commit();
 
            return ['success' => 1, 'message' => 'System Type  Added successfully!'];
        } catch (Exception $e) {
            DB::rollBack();

            return ['success' => 0, 'message' => 'Something went wrong!'.json_encode($e)];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        if (!auth()->user()->can('edit spread type')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();


        $systemtype = SystemType::where('id', $id)->with('categories', 'categories.subcategories', 'categories.subcategories.sheets', 'categories.subcategories.sheets.tasktype')->first();

       

        return view('backend_app.systemtype.show', compact('systemtype', 'current_sys'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('edit spread type')) {
            abort(403, 'Unauthorized Access.');
        }


        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();
        $sheets = TaskType::all();


        $systemtype = SystemType::where('id', $id)->with('categories', 'categories.subcategories', 'categories.subcategories.sheets', 'categories.subcategories.sheets.tasktype')->first();
        foreach ($systemtype->categories as $cat ) {
            foreach ($cat->subcategories as $subcat ) {
                $subcat['selectedSheets'] = SubSheet::where('sub_category_id', $subcat->id)->pluck('task_type_id')->toArray();
            }
        }

        // return json_encode($systemtype);

        return view('backend_app.systemtype.edit', compact('systemtype', 'current_sys', 'sheets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { 
        if (!auth()->user()->can('edit spread type')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            'system_type' => 'required',
            'component' => 'required|array',
            'component.*.sub-component' => 'required|array'
        ], [
            'component.*.sub-component' => 'At least one sub component is required',
            'system_type' => 'System Type is required', 
            'component' => 'At least one component is required',
        ]);

        


        DB::beginTransaction();

        try {


            $systemtype = SystemType::findOrFail($id);
            $systemtype->name = $request->input('system_type');
            $result = $systemtype->save();

            $components = $request->get('component');
 
            $com_exists = [];


            foreach ($components as $key => $com) {
                
                $edit = $com['edit'];

                
                $sub_com_exists = [];

                if ($edit == 1) {

                    $component_id = $com['component_id'];
                    $display_id = $com['id'];
                    $comname = $com['name'];

                    $com_exists[] = $component_id;
                    
                    $category = Category::find($component_id);
                    $category->parent_cat_id = $systemtype->id;
                    $category->name = $comname;
                    $category->display_id = $display_id;
                    $category->description = "";
                    $category->added_by = Auth::user()->id;
                    $cr = $category->save();
               
                    $subcomponents = $com['sub-component'];
 

                    foreach ($subcomponents as $sub) {

                        
                        $subedit = $sub['edit'];

                        if ($subedit == 1) { 

                            $subdisplay_id =  $sub['id'];
                            $subname = $sub['name'];
                            $sheet_numbers = $sub['sheet_number']; 
                            $sub_component_id = $sub['sub_component_id'];  

                            $sub_com_exists[] = $sub_component_id;
                            
                            $subcategory = SubCategory::find($sub_component_id); 
                            $subcategory->name = $subname;
                            // $subcategory->sheet_number = $sheet_number;
                            $subcategory->display_id = $subdisplay_id; 
                            $scr = $subcategory->save();

                            foreach ($sheet_numbers as $sheet) {
                                $exists = SubSheet::where('task_type_id', $sheet)->where('sub_category_id', $subcategory->id)->first();
                                if (!$exists) {
                                    $newsheet = new SubSheet();
                                    $newsheet->task_type_id = $sheet;
                                    $newsheet->sub_category_id = $subcategory->id;
                                    $newsheet->save(); 
                                }
                            }

                            $deletesubsheet = SubSheet::where('sub_category_id', $subcategory->id)->whereNotIn('task_type_id', $sheet_numbers)->get();

                            foreach ($deletesubsheet as $dss) {
                                $dss->delete();
                            }


                        } else {
                            
                            $subdisplay_id =  $sub['id'];
                            $subname = $sub['name'];
                            $sheet_numbers = $sub['sheet_number'];  

                            $subcategory = new SubCategory();
                            $subcategory->category_id = $category->id;
                            $subcategory->name = $subname;
                            // $subcategory->sheet_number = $sheet_number;
                            $subcategory->display_id = $subdisplay_id;
                            $subcategory->description = "";
                            $subcategory->added_by = Auth::user()->id;
                            $scr = $subcategory->save();

                            foreach ($sheet_numbers as $sheet) {

                                $newsheet = new SubSheet();
                                $newsheet->task_type_id = $sheet;
                                $newsheet->sub_category_id = $subcategory->id;
                                $newsheet->save(); 
                            }

                            $sub_com_exists[] = $subcategory->id;
 
                        }  
                    }


                    $deletesubcom = SubCategory::where('category_id', $category->id)->whereNotIn('id', $sub_com_exists)->get();

                    foreach ($deletesubcom as $subcategorydelete) {
                        $subcategorydelete->delete();
                    }



                } else {
 
                    $display_id = $com['id'];
                    $comname = $com['name'];

                    $category = new Category();
                    $category->parent_cat_id = $systemtype->id;
                    $category->name = $comname;
                    $category->display_id = $display_id;
                    $category->description = "";
                    $category->added_by = Auth::user()->id;
                    $cr = $category->save();

                    $com_exists[] = $category->id;

                    $subcomponents = $com['sub-component'];
  
                    foreach ($subcomponents as $sub) {

                        $subdisplay_id =  $sub['id'];
                        $subname = $sub['name'];
                        $sheet_numbers = $sub['sheet_number'];  
                         
                        $subcategory = new SubCategory();
                        $subcategory->category_id = $category->id;
                        $subcategory->name = $subname;
                        // $subcategory->sheet_number = $sheet_number;
                        $subcategory->display_id = $subdisplay_id;
                        $subcategory->description = "";
                        $subcategory->added_by = Auth::user()->id;
                        $scr = $subcategory->save(); 

                        foreach ($sheet_numbers as $sheet) {

                            $newsheet = new SubSheet();
                            $newsheet->task_type_id = $sheet;
                            $newsheet->sub_category_id = $subcategory->id;
                            $newsheet->save(); 
                        }

                    }
                }
            }


            $deletecom = Category::where('parent_cat_id', $systemtype->id)->whereNotIn('id', $com_exists)->with('categories')->get();

            foreach ($deletecom as $categorydelete) {

                foreach ($categorydelete->categories as $subcategorydelete) {
                    $subcategorydelete->delete();
                }

                $categorydelete->delete();
            }



            DB::commit();

            return redirect()->route('all-systemtype')->with('success', 'System Type  Updated successfully!');
        } catch (Exception $e) {
            DB::rollBack(); 

            return redirect()->route('all-systemtype')->with('error', 'Something went wrong!'.json_encode($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete spread type')) {
            abort(403, 'Unauthorized Access.');
        }
       try {

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $session->system_id = 1;
        $session->save();





        $st = SystemType::where('id', $id)->with('categories', 'spreadcategories', 'system')->first();

        foreach ($st->categories as $cat) {
             
            $assets = Assets::where('category_id', $cat->id)->get();

            foreach ($assets as $asset ) { 
                $tasks = Task::where('asset_id', $asset->id)->get();
                foreach ($tasks as $task ) {
                    AuditLog::where('task_id', $task->id)->delete();
                }
                Task::where('asset_id', $asset->id)->delete(); 
            }
            Assets::where('category_id', $cat->id)->delete();
            SubCategory::where('category_id', $cat->id)->delete();
        }

        

        foreach ($st->spreadcategories as $spcat) {
             
            $assets = Assets::where('spread_category_id', $spcat->id)->get();

            foreach ($assets as $asset ) { 
                $tasks = Task::where('asset_id', $asset->id)->get();
                foreach ($tasks as $task ) {
                    AuditLog::where('task_id', $task->id)->delete();
                }
                Task::where('asset_id', $asset->id)->delete(); 
            }
            Assets::where('spread_category_id', $spcat->id)->delete(); 
            SpreadCategoryType::where('spread_category_id', $spcat->id)->delete();
            $spcat->delete();
        }

        foreach ($st->system as $system) {
             
            $assets = Assets::where('spread_id', $system->id)->get();

            foreach ($assets as $asset ) { 
                $tasks = Task::where('asset_id', $asset->id)->get();
                foreach ($tasks as $task ) {
                    AuditLog::where('task_id', $task->id)->delete();
                }
                Task::where('asset_id', $asset->id)->delete(); 
            }
            Assets::where('spread_id', $system->id)->delete();  
            $sessions = SystemSession::where('system_id', $system->id)->get();
  
            foreach ($sessions as $ses) {
                $ses->system_id = 1;
                $ses->save();
            }


            

            // // spread category delete
            // $spreadcategoriess = SpreadCategory::where('system_id', $system->id)->get();
            // foreach ($spreadcategoriess as $spcat) { 
            //     $assets = Assets::where('spread_category_id', $spcat->id)->get(); 
            //     foreach ($assets as $asset ) { 
            //         $tasks = Task::where('asset_id', $asset->id)->get();
            //         foreach ($tasks as $task ) {
            //             AuditLog::where('task_id', $task->id)->delete();
            //         }
            //         Task::where('asset_id', $asset->id)->delete(); 
            //     }
            //     Assets::where('spread_category_id', $spcat->id)->delete(); 
            //     SpreadCategoryType::where('spread_category_id', $spcat->id)->delete();
            // }

            Project::where('spread_id', $system->id)->delete();
            $system->delete();


        }

        foreach ($st->categories as $cat) {
            Category::find($cat->id)->delete();
        }
        $st->delete(); 

        return redirect()->route('all-systemtype')->with('success', 'SystemType Deleted successfully!');
       } catch (Exception $e) {
        return redirect()->back()->with('error', 'SystemType Can not be Deleted! First Delete the childs'.json_encode($e));
       }
    }
}