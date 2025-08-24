<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Category;
use App\Models\SpreadCategory;
use App\Models\SpreadCategoryType;
use App\Models\SubCategory;
use App\Models\SystemType;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        if (!auth()->user()->can('all component')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();


        $categories = Category::with('systemtype')->where('parent_cat_id',$sysid->system_type_id)->get();
        return view('backend_app.category.index', compact('categories', 'current_sys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create component')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();

        $components = Category::where('parent_cat_id', $sysid->system_type_id)->get();


        // $systemtypes = System::with('systemtype', 'location')->groupBy('system_type_id')->get();
        // $systemtypes = System::with('systemtype', 'location')->groupBy('system_type_id')->get();
        $systemtypes = SystemType::all();
        return view('backend_app.category.create', compact('systemtypes', 'components', 'session', 'current_sys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create component')) {
            abort(403, 'Unauthorized Access.');
        }
        $request->validate([
            'parent_cat_id' => 'required',
            'name' => 'required'
        ]);
        $admin_id = Auth::user()->id;


        $category = new Category();
        $category->parent_cat_id = $request->input('parent_cat_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->added_by = $admin_id;
        $result = $category->save();

        if ($result) {
            return redirect()->route('all-category')->with('success', 'Component Added successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('view component')) {
            abort(403, 'Unauthorized Access.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if (!auth()->user()->can('edit component')) {
            abort(403, 'Unauthorized Access.');
        }
 

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();

        $category = Category::where('id', $id)->first();
        $components = Category::where('parent_cat_id', $category->parent_cat_id)->get();



        $systemtypes = SystemType::all();
        return view('backend_app.category.edit', compact('category', 'systemtypes', 'session', 'components', 'current_sys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit component')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'parent_cat_id' => 'required',
            'name' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $admin_id = Auth::user()->id;

        $category->parent_cat_id = $request->input('parent_cat_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->added_by = $admin_id;
        $result = $category->update();

        if ($result) {
            return redirect()->route('all-category')->with('success', 'Category Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete component')) {
            abort(403, 'Unauthorized Access.');
        } 

        $cat = Category::where('id', $id)->with('assets', 'tasks', 'pretasks')->first();

        if (count($cat->pretasks) > 0) {
            return redirect()->route('all-category')->with('error', 'Can not delete component because it has predefined task associated with');
        } else if (count($cat->tasks) > 0) {
            return redirect()->route('all-category')->with('error', 'Can not delete component because it has tasks associated with');
        }else if (count($cat->assets) > 0) {
            return redirect()->route('all-category')->with('error', 'Can not delete component because it has assets associated with');
        }else{
            try {
                if ($id == 1) {
                    return redirect()->route('all-category')->with('error', 'Can not delete this component');
                } else {
                    Category::where('id', $id)->delete();
                } 
            } catch (Exception $e ) {
                return redirect()->route('all-category')->with('error', 'Can not delete component. Please delete it childs first');
            }
            

        } 

        return redirect()->route('all-category')->with('success', 'Category Deleted successfully!');
    }

    public function getcategories($system_id)
    {
        $system = System::where('id', $system_id)->first();

        $categories = Category::where('parent_cat_id', $system->system_type_id)->get();
        return response()->json($categories);
    }
    public function getcategoriess($system_id)
    { 
        $categories = Category::where('parent_cat_id', $system_id)->get();
        return response()->json($categories);
    }
    public function getSubcategories2($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->pluck('name', 'id');
        return response()->json($subcategories);
    }
    public function getSystems($category_id)
    {
        $spreadcategories = DB::select("SELECT sc.id as system_id, sc.system_description as system_name
                FROM `spread_category_types` as sct
                LEFT JOIN `spread_category` as sc 
                ON sc.id = sct.spread_category_id 
                WHERE sct.category_id = $category_id
                GROUP BY sct.spread_category_id"); 

        return response()->json($spreadcategories);
    }

    public function ajaxCategory($id)
    {
        try {

            $data = SubCategory::where('category_id', $id)->get();
            $spread = SpreadCategoryType::where('spread_category_id', $id)->first();
            $response = [];
            $statusLabel = "";
            foreach ($data as $key => $value) {
                $status = Task::where('sub_category_id', $value->id)->first();
                if ($status) {
                    // Assuming end_date is stored in the database as a date string or Carbon date instance
                    $endDate = Carbon::parse($status->end_date);
                    $now = Carbon::now();

                    if ($endDate->isFuture()) {
                        // The end_date is in the future
                        $statusLabel = 'Certified';
                    } else {
                        // The end_date is in the past
                        $statusLabel = 'Expired';
                    }
                } else {
                    // Handle case when task is not found
                    $statusLabel = 'N/A';
                }

                $response[] = [
                    'sub_category_name' => $value->name,
                    'status' => $statusLabel
                ];
            }


            return response()->json($response, 200);

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function shift_component()
    {
        try {
            $excludedTaskIds = request()->get('data');
            $included_data = SubCategory::whereIn('category_id', $excludedTaskIds)->get();
            foreach ($included_data as $include) {
                // $task = Task::where('sub_category_id', $include->id)->get();
                // if ($status) {
                //     $endDate = Carbon::parse($status->end_date);
                //     $now = Carbon::now();
                //     if ($endDate->isFuture()) {
                //         $statusLabel = 'Certified';
                //     } else {
                //         $statusLabel = 'Expired';
                //     }
                // } else {
                //     $statusLabel = 'Incomplete';
                // }
                $include["status"] = $include->status();
                $include["asset_count"] = $include->assetCount();
            }
            return response()->json($included_data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function shift_sub_component()
    {
        try {
            $subCategoryIds = request()->get('sub_components_ids');
            $included_assets = Assets::whereIn('sub_category_id', $subCategoryIds)->with('subcategory')->orderBy('category_id')->get();

            $assets = [];
            // return json_encode($included_assets);
            foreach ($included_assets as $include) {

                if (!$include->spread_category_id || $include->spread_category_id == '') {
                    $asset = [
                        "id" => $include->id,
                        "description" => $include->subcategory->name . ' - ' . $include->description,
                        "status" => $include->status(),
                        "task_count" => $include->taskCount(),
                        "spread_category_id" => $include->spread_category_id
                    ];
                    $assets[] = $asset;
                }
               

            }
            return response()->json($assets, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function shift_assets()
    {
        try {
            $assetsIds = request()->get('assets_ids');
            $included_tasks = Task::whereIn('asset_id', $assetsIds)->with('subcategory')->with('asset')->orderBy('category_id')->get();

            $tasks = [];
            // return json_encode($included_tasks);

            foreach ($included_tasks as $include) {

                if (!$include->spread_category_id || $include->spread_category_id == '') {
                $task = [
                    "id" => $include->id,
                    "description" =>  $include->subcategory->name . ' - ' .  $include->asset->description . ' - ' . $include->description,
                    "status" => $include->status(),
                    "spread_category_id" => $include->spread_category_id
                ];
                $tasks[] = $task;
            }

            }
            return response()->json($tasks, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }



    public function transfercategory($id)
    {
        if (!auth()->user()->can('transfer component')) {
            abort(403, 'Unauthorized Access.');
        } 

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first();
        
        $category = Category::where('id', $id)->with('systemtype')->first();
        $systems = System::with('systemtype')->get();
        return view('backend_app.category.transfer_category', compact('category', 'systems', 'sysid', 'current_sys'));
    }

    public function updatetransfercategory(Request $request, $id)
    {

        if (!auth()->user()->can('transfer component')) {
            abort(403, 'Unauthorized Access.');
        } 

        $request->validate([
            'old_system_id' => 'required',
            'system_id' => 'required'
        ]);

        $oldcategory = Category::find($id);
        $newSpread = System::find($request->input('system_id')); 
        $oldsystemid = $request->input('old_system_id');


        if ($newSpread->id != $oldcategory->system_id) {
 
            // $subcategories = $oldcategory->subcategories()->with('assets')->get();
            // $subcategories_ids = $oldcategory->subcategories()->pluck('id');

            $assets = Assets::where('category_id', $oldcategory->id)->where('spread_id', $oldsystemid)->with('tasks')->get();
            // update spread_id to new one

            foreach ($assets as $asset) {
                
                $asset->spread_id = $newSpread->id;
                $asset->save();

                foreach ($asset->tasks as $task) {
                    $task->system_id = $newSpread->id;
                    $task->save();
                }
                
            }

            // $oldcategory->system_id = $newSpread->id;
            // $oldcategory->save();

            // $spreadCatTypes = SpreadCategoryType::where('spread_category_id', $oldcategory->id)->get();
            // foreach ($spreadCatTypes as $sct) {
            //     $sct->system_id = $newSpread->id;
            //     $sct->save();

            //     $assets = Assets::where('category_id', $sct->value)->get();
            //     foreach ($assets as $asset) {
            //         $asset->spread_id = $newSpread->id;
            //         $asset->save();
            //     }
            // }
        }
        return redirect()->route('all-spreadcategory')->with('success', 'Component Transfer successfully!');
    }

}
