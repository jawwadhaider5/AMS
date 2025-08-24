<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SpreadCategory;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\SystemType;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
 
    public function index()
    {

        if (!auth()->user()->can('all sub component')) {
            abort(403, 'Unauthorized Access.');
        }


        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first(); 

        $sysid = System::where('id', $session->system_id)->with('location')->first();

        $categories = []; 

        // $categories = DB::select("SELECT ast.id, ast.category_id, cat.name as com_name,  ast.sub_category_id, systp.name as imca, ast.system_id, ast.spread_id, sys.system_name, ast.spread_category_id, ast.description, subcat.name as sub_com_name
        // FROM `system_assets` as ast
        // LEFT JOIN `sub_categories` as subcat
        // ON subcat.id = ast.sub_category_id
        // LEFT JOIN `categories` as cat 
        // ON cat.id = ast.category_id
        // LEFT JOIN `systems` as sys
        // ON sys.id = ast.spread_id
        // LEFT JOIN `system_types` as systp
        // ON systp.id = cat.parent_cat_id
        // WHERE `spread_id` = $sysid->id
        // GROUP BY subcat.id ORDER BY cat.id");

        $subcategories = DB::select("SELECT subcat.id, subcat.category_id, subcat.name as subcategory_name, cat.parent_cat_id as system_type_id, cat.name as category_name, styp.name as system_type_name, sys.id as spread_id, sys.system_name as spread_name
        FROM `sub_categories` as subcat
        LEFT JOIN `categories` as cat 
        ON cat.id = subcat.category_id
        LEFT JOIN `system_types` as styp
        on styp.id = cat.parent_cat_id
        JOIN `systems` as sys 
        ON sys.system_type_id = styp.id
        WHERE sys.id = $sysid->id"); 
      
        foreach ($subcategories as $subcat) {
            $subcat->location = $sysid->location->name;
            $sbct = SubCategory::find($subcat->id);
            $subcat->status = $sbct->status(); 
        }
        //  return json_encode($subcategories);
        return view('backend_app.subcategory.index' ,compact('subcategories', 'current_sys'));
    }


    public function create()
    { 
 
        if (!auth()->user()->can('create sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first(); 
        $sysid = System::where('id', $session->system_id)->first();
        // $sysid->system_type_id 


        $systemtypes = SystemType::all();
        return view('backend_app.subcategory.create', compact('systemtypes', 'current_sys')); 
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'system_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
        ]);
        $admin_id = Auth::user()->id;

        $category = new SubCategory();
        $category->category_id = $request->input('category_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->added_by = $admin_id;
        $result = $category->save();
     
        if ($result) {
            return redirect()->route('all-subcategory')->with('success', 'SubCategory Added successfully!');
        }
    }

 
    public function show(string $id)
    {
        
    }

    public function edit(Request $request, $id)
    {
        if (!auth()->user()->can('edit sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $current_sys = System::where('id', $session->system_id)->first(); 

        $subcategory= SubCategory::where('id' ,$id)->with('category', 'category.systemtype')->first();
        $categories = Category::all(); 
        $systemtypes = SystemType::all();

        return view('backend_app.subcategory.edit', compact('subcategory','categories', 'systemtypes', 'current_sys'));
    }

 
    public function update(Request $request, string $id)
    {

        if (!auth()->user()->can('edit sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'system_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
        ]);

        $category = SubCategory::findOrFail($id);
        $admin_id = Auth::user()->id;

        $category->category_id = $request->input('category_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->added_by = $admin_id;
        $result = $category->update();

         if ($result) {
            return redirect()->route('all-subcategory')->with('success', 'SubCategory Updated successfully!');
        }
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $subcat = SubCategory::where('id', $id)->with('assets', 'tasks', 'pretasks')->first();

        if (count($subcat->pretasks) > 0) {
            return redirect()->route('all-subcategory')->with('error', 'Can not delete sub component because it has predefined task associated with');
        } else if (count($subcat->tasks) > 0) {
            return redirect()->route('all-subcategory')->with('error', 'Can not delete sub component because it has tasks associated with');
        }else if (count($subcat->assets) > 0) {
            return redirect()->route('all-subcategory')->with('error', 'Can not delete sub component because it has assets associated with');
        }else{
            
            try {
                if ($id == 1) {
                    return redirect()->route('all-subcategory')->with('error', 'Can not delete this sub component');
                }
                else{
                    SubCategory::where('id', $id)->delete();
                }
            } catch (Exception $e ) {
                return redirect()->route('all-subcategory')->with('error', 'Can not delete sub component. Please delete its childs first');
            }
            // 

        } 

        return redirect()->route('all-subcategory')->with('success', 'Sub Category Deleted successfully!');
    }
    
    public function addsubcategory(Request $request)
    {
        if (!auth()->user()->can('create sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'categoryId' => 'required',
            'name' => 'required',
        ]);   
        $admin_id = Auth::user()->id;
        $category = new SubCategory();
        $category->category_id = $request->input('categoryId');
        $category->name = $request->input('name');
        $category->added_by = $admin_id;
        $result = $category->save();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
        
    }


    public function transfersubcategory($id)
    {
        if (!auth()->user()->can('transfer sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first(); 
        $current_sys = System::where('id', $session->system_id)->first(); 
        
        $subcategory = SubCategory::where('id', $id)->with('category')->first();
        $systems = System::with('systemtype')->get();
 
        return view('backend_app.subcategory.transfer_subcategory', compact('subcategory', 'systems', 'sysid','current_sys'));
    }

    public function updatetransfersubcategory(Request $request, $id)
    {

        if (!auth()->user()->can('transfer sub component')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'old_system_id' => 'required',
            'system_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required'
        ]);

        $suboldcategory = SubCategory::find($id);
        $newSpread = System::find($request->input('system_id')); 
        $oldsystemid = $request->input('old_system_id');
        $newcategoryid = $request->input('category_id');
        $newsubcategoryid = $request->input('sub_category_id');

        // return json_encode($newSpread);


        if ($oldsystemid == $request->input('system_id')) { 

            $assets = Assets::where('sub_category_id', $suboldcategory->id)->where('spread_id', $oldsystemid)->with('tasks')->get(); 

            foreach ($assets as $asset) {
                 
                $asset->category_id = $newcategoryid;
                $asset->sub_category_id = $newsubcategoryid; 
                $asset->save();

                foreach ($asset->tasks as $task) {
                    $task->category_id = $newcategoryid;
                    $task->sub_category_id = $newsubcategoryid;
                    $task->save();
                }
                
            } 
        }else if ($oldsystemid != $request->input('system_id')) {
 
            $assets = Assets::where('sub_category_id', $suboldcategory->id)->where('spread_id', $oldsystemid)->with('tasks')->get(); 

            foreach ($assets as $asset) {
                
                $asset->system_id = $newSpread->system_type_id;
                $asset->spread_id = $newSpread->id;
                $asset->category_id = $newcategoryid;
                $asset->sub_category_id = $newsubcategoryid;
                $asset->save();

                foreach ($asset->tasks as $task) {
                    $task->system_id = $newSpread->id;
                    $task->category_id = $newcategoryid;
                    $task->sub_category_id = $newsubcategoryid;
                    $task->save();
                }
                
            } 
        }
        
        return redirect()->route('all-subcategory')->with('success', 'Sub Component Transfer successfully!');
    }
    
}
