<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Category;
use App\Models\SpreadCategory;
use App\Models\SubCategory;
use App\Models\SystemSession;
use App\Models\Task;
use App\Models\System;
use App\Models\SystemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Artisan;

class MainController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //      Artisan::call('cache:clear');
        //  Artisan::call('config:cache');
        //  Artisan::call('route:cache');
        //   Artisan::call('view:clear');
        //   return "cleared!";

        if (!auth()->user()->can('view dashboard')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        // $categories = Category::with('subcategories')->get();
        // $tasks = Task::with('category', 'subcategory')->where('system_id', $session->system_id)->whereNotNull('start_date')->paginate(5);

        // $expiretasks = Task::with('category', 'subcategory')->where('system_id', $session->system_id)->whereNull('start_date')->paginate(5);
        // $spreadcategorys = SpreadCategory::with('system', 'system.systemtype', 'system.location')->get();
        $spreads = System::with('systemtype', 'location')->get();

        // Calculate status for each spread using the model method
        foreach ($spreads as $spread) {
            $spread['status'] = $spread->status();
        }

        // return view('backend_app.index', compact('categories', 'tasks', 'expiretasks', 'spreadcategorys', 'spreads', 'session'));

        $certified = 0;
        $expiring = 0;
        $expired = 0;
        $incomplete = 0;
        // $assets = Assets::where('spread_id', $sysid->id)->get();
        $assets = Assets::whereNotNull('spread_category_id')->get();
        foreach ($assets as $asset) {
            $assetStatus = $asset->status(); // Use the enhanced status method

            switch ($assetStatus) {
                case 'Certified':
                    $certified++;
                    break;
                case 'Expired':
                    $expired++;
                    break;
                case 'Expiring':
                    $expiring++;
                    break;
                case 'Incomplete':
                default:
                    $incomplete++;
                    break;
            }
        }

        $chartData = [$certified, $expiring, $expired, $incomplete];

        return view('backend_app.index', compact('spreads', 'chartData', 'current_sys'));
    }
    public function system_dashboard()
    {
        if (!auth()->user()->can('view dashboard')) {
            abort(403, 'Unauthorized Access.');
        }

        $sid = request()->get('sid');

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();
        $systemtypes = SystemType::all();

        if (!$sid) {
            $sid = $session->system_id;
        }


        $categories = Category::with('subcategories')->get();

        // $tasks = Task::with('category', 'subcategory')->where('system_id', $session->system_id)->whereNotNull('start_date')->paginate(5);


        $tasks = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsktp.name as task_type_name, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
        FROM `tasks` as tsk
        LEFT JOIN `task_types` as tsktp
        ON tsktp.id = tsk.task_type
        LEFT JOIN `system_assets` as assets
        ON assets.id = tsk.asset_id
        LEFT JOIN `categories` as cat 
        ON cat.id = assets.category_id
        WHERE tsk.system_id = $sysid->id AND assets.status IS NULL AND tsk.active = 1 AND tsk.frequency!=0 AND tsk.expire_date >= CURRENT_DATE 
        AND tsk.expire_date <= CURRENT_DATE + INTERVAL 31 DAY");

        // return json_encode($tasks);

        // $expiretasks = Task::with('category', 'subcategory')->where('system_id', $session->system_id)->whereNull('start_date')->paginate(5);
        $expiretasks = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsktp.name as task_type_name, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
        FROM `tasks` as tsk
        LEFT JOIN `task_types` as tsktp
        ON tsktp.id = tsk.task_type
        LEFT JOIN `system_assets` as assets
        ON assets.id = tsk.asset_id
        LEFT JOIN `categories` as cat 
        ON cat.id = assets.category_id
        WHERE tsk.system_id = $sysid->id AND assets.status IS NULL AND tsk.active = 1
        AND tsk.expire_date < CURRENT_DATE");

        $incompletetasks = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsktp.name as task_type_name, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
        FROM `tasks` as tsk
        LEFT JOIN `task_types` as tsktp
        ON tsktp.id = tsk.task_type
        LEFT JOIN `system_assets` as assets
        ON assets.id = tsk.asset_id
        LEFT JOIN `categories` as cat 
        ON cat.id = assets.category_id
        WHERE tsk.system_id = $sysid->id AND assets.status IS NULL AND tsk.active = 1 AND tsk.frequency!=0
        AND tsk.expire_date IS NULL");

        $spreadcategorys = SpreadCategory::with('system', 'system.systemtype', 'system.location')->where("system_id", null)->get();

        $spreads = System::with('systemtype', 'location')->get();
        // $sys=System::find($id);

        $asignspread = SpreadCategory::with('system', 'system.systemtype', 'system.location', 'spreadcategorytype')->where('system_id', $session->system_id)->get();

        foreach ($asignspread as $spreadcategory) {
            $spreadcategory['status'] = $spreadcategory->status();
        }

        $spreadlists = System::with('systemtype', 'location')->where('id', $sysid->id)->get();

        // echo json_encode($spreadlists);
        // echo json_encode($sid);
        // return 0;


        $certified = 0;
        $expiring = 0;
        $expired = 0;
        $incomplete = 0;
        $assets = Assets::where('spread_id', $sysid->id)->whereNotNull('spread_category_id')->get();
        foreach ($assets as $asset) {
            $assetStatus = $asset->status(); // Use the enhanced status method
            
            switch ($assetStatus) {
                case 'Certified':
                    $certified++;
                    break;
                case 'Expired':
                    $expired++;
                    break;
                case 'Expiring':
                    $expiring++;
                    break;
                case 'Incomplete':
                default:
                    $incomplete++;
                    break;
            }
        }

        $chartData = [$certified, $expiring, $expired, $incomplete];


        return view('backend_app.dashboard.index', compact(
            'categories',
            'tasks',
            'expiretasks',
            'incompletetasks',
            'spreadcategorys',
            'spreads',
            'session',
            'asignspread',
            'spreadlists',
            'sysid',
            'chartData',
            'current_sys',
            'systemtypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function categoriesupdate(Request $request)
    {

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();

        // $systemtypeId = $request->input('systemtype_id');
        // $sysid = System::where('id', $systemtypeId)->first();


        // $categories = Category::with('subcategories')->where('parent_cat_id', $sysid->system_type_id)->get();


        $categories = DB::select("SELECT cat.name, cat.id
                    FROM categories as cat
                    LEFT JOIN spread_category_types as sct
                    ON sct.category_id = cat.id
                    LEFT JOIN spread_category as sc
                    ON sc.id = sct.spread_category_id
                    WHERE sc.system_id = $sysid->id
                    GROUP BY sct.category_id
                    ORDER BY cat.display_id");


        foreach ($categories as $cat) {
            $subcategories = [];
            $subcategories = SubCategory::where('category_id', $cat->id)->orderBy('display_id')->get();
            foreach ($subcategories as $subcat) {
                $subcat->assetCount = $subcat->assetCount();
            }
            $cat->subcategories = $subcategories;
        }


        return [
            'success' => true,
            'categories' => $categories
        ];
    }

    public function categories_change(Request $request)
    {

        $systemtypeId = $request->input('systemtype_id');
        $categories = Category::with('subcategories')->where('parent_cat_id', $systemtypeId)->get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    public function imca_change(Request $request)
    {


        $systemtypeId = $request->input('systemtype_id');
        $subcategories = SubCategory::leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')->where('categories.parent_cat_id', $systemtypeId)
            ->select('sub_categories.id as id', 'sub_categories.name as name', 'sub_categories.sheet_number as sheet_number')->get();

        return response()->json([
            'success' => true,
            'subcategories' => $subcategories
        ]);
    }

    public function getSystemTypeId(Request $request)
    {
        $systemtypeId = SystemSession::where('user_id', Auth::user()->id)->first();
        //  Log::info('Getting systemtype_id from session: ' . $systemtypeId);
        return response()->json(['systemtype_id' => $systemtypeId->system_id]);
    }

    public function setSystemTypeId(Request $request)
    {
        $newSystemTypeId = $request->input('systemtype_id');
        $newUser = SystemSession::updateOrCreate([
            'user_id'   => Auth::user()->id,
        ], [
            'system_id'   => $newSystemTypeId,
        ]);


        return response()->json(['success' => true]);
    }

    public function saveSystemTypeId(Request $request, $id)
    {
        $newSystemTypeId = $id;
        $newUser = SystemSession::updateOrCreate([

            'user_id'   => Auth::user()->id,
        ], [
            'system_id'   => $newSystemTypeId,
        ]);

        return redirect()->route('system_dashboard');
        //     $auth_id = Auth::user()->id;
        //     $session = SystemSession::where('user_id', $auth_id)->first();

        //     $categories = Category::with('subcategories')->get();
        //     $tasks = Task::with('category','subcategory')->where('system_id' , $session->system_id)->whereNotNull('start_date')->paginate(5); 
        //   // dd($tasks);
        //     $expiretasks = Task::with('category','subcategory')->where('system_id' , $session->system_id)->whereNull('start_date')->paginate(5);
        //     $spreadcategorys = SpreadCategory::with('system' ,'system.systemtype','system.location')->get(); 

        //     $spreads = System::with('systemtype','location')->get(); 
        //     $sys=System::find($id);

        //     $asignspread = SpreadCategory::with('system' ,'system.systemtype','system.location' ,'spreadcategorytype')->where('system_id', $session->system_id)->get(); 
        //     $spreadlists = System::with('systemtype','location')->get();

        //      return view('backend_app.dashboard.index' ,compact('categories','tasks','expiretasks' ,'spreadcategorys' ,'spreads' ,'session' ,'asignspread','sys','spreadlists'));


        //end ch change 
    }
}
