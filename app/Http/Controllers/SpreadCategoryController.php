<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\PreTask;
use App\Models\SpreadCategory;
use App\Models\SpreadCategoryType;
use App\Models\SubCategory;
use App\Models\System;
use App\Models\SystemType;
use App\Models\SystemFile;
use App\Models\SystemSession;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class SpreadCategoryController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->user()->can('all system')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();

        $spreadcategorys = SpreadCategory::with('systemtype', 'system')->get();

        foreach ($spreadcategorys as $spreadcategory) {
            $spreadcategory['status'] = $spreadcategory->status();
        }

        // return json_encode($spreadcategorys);

        return view('backend_app.spreadcategory.index', compact('spreadcategorys'));
    }

    public function create()
    {
        if (!auth()->user()->can('create system')) {
            abort(403, 'Unauthorized Access.');
        }
        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();

        $systemtypes = SystemType::all();
        return view('backend_app.spreadcategory.create', compact('systemtypes'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create system')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'name' => 'required',
            'system_id' => 'required',
        ]);

        $spreadcategory = new SpreadCategory();
        $spreadcategory->name = $request->input('name');
        $spreadcategory->system_id = $request->input('system_id');
        $result = $spreadcategory->save();

        if ($result) {
            return redirect()->route('all-spreadcategory')->with('success', 'Spread Category  Added successfully!');
        }
    }
    public function show(string $id)
    {
        if (!auth()->user()->can('view system')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $spreadcategory = SpreadCategory::where('id', $id)->with('system')->first();
        $included_data_ids = SpreadCategoryType::where('spread_category_id', $spreadcategory->id)->pluck('category_id')->toArray();
        $categories = Category::whereIn('id', $included_data_ids)->with('subcategories')->orderBy('display_id')->get();
        $final_assets = Assets::where('spread_category_id', $spreadcategory->id)->whereNotNull('spread_category_id')->with('tasks')->with('subcategory')->get();

        $spreadcategory['manuals'] = $spreadcategory['manuals'] ? explode('|', $spreadcategory['manuals']) : [];
        $spreadcategory['certificates'] = $spreadcategory['certificates'] ? explode('|', $spreadcategory['certificates']) : [];
        $spreadcategory['data_sheets'] = $spreadcategory['data_sheets'] ? explode('|', $spreadcategory['data_sheets']) : [];

        $assets = [];
        $tasks = [];
        $subcomponents = [];

        foreach ($categories as $cat) {
            foreach ($cat->subcategories as $subcat) {

                $subcomp = [
                    "id" => $subcat->id,
                    "name" => $subcat->name,
                    "status" => $subcat->status(),
                    "asset_count" => $subcat->assetCount2($spreadcategory->id),
                ];
                $subcomponents[] = $subcomp;
            }
        }


        foreach ($final_assets as $asset) {
            $asst = [
                "id" => $asset->id,
                "description" => $asset->description,
                "status" => $asset->status(),
                "asset_count" =>  $asset->taskCount(),
            ];
            $assets[] = $asst;
            foreach ($asset->tasks as $tsk) {
                $tk = [
                    "id" => $tsk->id,
                    "description" => $tsk->description,
                    "status" => $tsk->status()
                ];
                $tasks[] = $tk;
            }
            $subcompt = [
                "id" => $asset->subcategory->id,
                "name" => $asset->subcategory->name,
                "status" => $asset->subcategory->status(),
                "asset_count" => $asset->subcategory->assetCount(),
            ];
            // $subcomponents[] = $subcompt;
        }

        return view('backend_app.spreadcategory.show', compact('spreadcategory', 'subcomponents', 'categories', 'assets', 'tasks', 'current_sys'));
    }

    public function edit(string $id)
    {
        if (!auth()->user()->can('edit system')) {
            abort(403, 'Unauthorized Access.');
        }

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();

        $spreadcategory = SpreadCategory::where('id', $id)->with('systemtype', 'system')->first();


        $spreadcategory['manuals'] = $spreadcategory['manuals'] ? explode('|', $spreadcategory['manuals']) : [];
        $spreadcategory['certificates'] = $spreadcategory['certificates'] ? explode('|', $spreadcategory['certificates']) : [];
        $spreadcategory['data_sheets'] = $spreadcategory['data_sheets'] ? explode('|', $spreadcategory['data_sheets']) : [];


        $included_data_ids = SpreadCategoryType::where('spread_category_id', $spreadcategory->id)->pluck('category_id')->toArray();
        $categories = Category::whereIn('id', $included_data_ids)->with('subcategories')->get();

        $final_assets = Assets::where('spread_category_id', $spreadcategory->id)->whereNotNull('spread_category_id')->with('tasks')->with('subcategory')->get();
        $systemtypes = SystemType::all();

        $assets = [];
        $tasks = [];
        $subcomponents = [];

        foreach ($categories as $cat) {
            foreach ($cat->subcategories as $subcat) {

                $subcomp = [
                    "id" => $subcat->id,
                    "name" => $subcat->name,
                    "status" => $subcat->status(),
                    "asset_count" => $subcat->assetCount(),
                ];
                $subcomponents[] = $subcomp;
            }
        }


        foreach ($final_assets as $asset) {
            $asst = [
                "id" => $asset->id,
                "description" => $asset->description,
                "status" => $asset->status(),
                "asset_count" =>  $asset->taskCount(),
            ];
            $assets[] = $asst;
            foreach ($asset->tasks as $tsk) {
                $tk = [
                    "id" => $tsk->id,
                    "description" => $tsk->description,
                    "status" => $tsk->status()
                ];
                $tasks[] = $tk;
            }
            $subcomp = [
                "id" => $asset->subcategory->id,
                "name" => $asset->subcategory->name,
                "status" => $asset->subcategory->status(),
                "asset_count" => $asset->subcategory->assetCount(),
            ];
            $subcomponents[] = $subcomp;
        }


        return view('backend_app.spreadcategory.edit', compact('spreadcategory', 'subcomponents', 'categories', 'assets', 'tasks', 'current_sys', 'systemtypes'));
    }


    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('edit system')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'name' => 'required',
            'system_id' => 'required',
        ]);

        $spreadcategory = SpreadCategory::findOrFail($id);
        $spreadcategory->name = $request->input('name');
        $spreadcategory->system_id = $request->input('system_id');
        $result = $spreadcategory->update();

        if ($result) {
            return redirect()->route('all-spreadcategory')->with('success', 'Spread Category Updated successfully!');
        }
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete system')) {
            abort(403, 'Unauthorized Access.');
        }

        $spreadcat = SpreadCategory::find($id);

        $assets = Assets::where('spread_category_id', $spreadcat->id)->get();
        foreach ($assets as $asset) {
            $tasks = Task::where('asset_id', $asset->id)->get();
            foreach ($tasks as $task) {
                AuditLog::where('task_id', $task->id)->delete();
                $task->asset_files()->delete();
            }
            Task::where('asset_id', $asset->id)->delete();
        }
        // Assets::where('spread_category_id', $spreadcat->id)->delete();
        foreach ($assets as $asset) {
            $asset->category_id = null;
            $asset->sub_category_id = null;
            $asset->spread_category_id = null;
            $asset->save();
        }


        SpreadCategoryType::where('spread_category_id', $spreadcat->id)->delete();
        $spreadcat->delete();


        return redirect()->route('all-spreadcategory')->with('success', 'Spread Category Deleted successfully!');
    }

    // EXT CODE

    public function searchSystems($id)
    {
        try {
            // $value = System::find($id);
            $value = SystemType::find($id);

            $excludedTaskIds = SpreadCategoryType::leftJoin('spread_category', 'spread_category.id', '=', 'spread_category_types.spread_category_id')
                ->where('system_type_id', $value->id)
                ->pluck('spread_category_types.category_id')->toArray();



            $dataQuery = Category::where('parent_cat_id', $value->id);

            $included_data = SubCategory::whereIn('category_id', $excludedTaskIds)->get();


            $categories = [];
            $cate1 = Category::where('parent_cat_id', $value->id)->whereIn('id', $excludedTaskIds)->get();
            // $cate2 = Category::where('parent_cat_id', $value->id)->whereNotIn('id', $categories_ids)->get();

            foreach ($cate1 as $cat) {
                $cat["checked"] = 1;
                $categories[] = $cat;
            }



            foreach ($included_data as $include) {
                $status = Task::where('sub_category_id', $include->id)->first();
                if ($status) {
                    $endDate = Carbon::parse($status->end_date);
                    $now = Carbon::now();
                    if ($endDate->isFuture()) {
                        $statusLabel = 'Certified';
                    } else {
                        $statusLabel = 'Expired';
                    }
                } else {
                    $statusLabel = 'Incomplete';
                }
                $include["status"] = $statusLabel;
            }



            if (!empty($excludedTaskIds)) {
                $dataQuery->whereNotIn('id', $excludedTaskIds);
            }

            $data = $dataQuery->get();

            foreach ($data as $cat) {
                $cat["checked"] = 0;
                $categories[] = $cat;
            }

            // $system_name = SystemType::where('id', $value->id)->first();

            $response = [
                'data' => $categories,
                'included_data' => $included_data,
                'system' => $value->name
            ];



            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    public function storeSpread(Request $request)
    {
        if (!auth()->user()->can('create system')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'system_id' => 'required',
            'values' => 'required|array',
        ]);


        try {

            $spreadcategory = new SpreadCategory();
            $spreadcategory->system_type_id = $request->input('system_id');
            $spreadcategory->system_description = $request->input('system_description');
            $spreadcategory->manufraturer = $request->input('manufraturer');
            $spreadcategory->class_system = $request->input('class_system');
            $spreadcategory->class_name = $request->input('class_system') == 'yes' ? $request->input('class_name') : '';
            $spreadcategory->model_number = $request->input('model_number');
            $spreadcategory->containerized_system = $request->input('containerized_system');
            $spreadcategory->manufacture_date = $request->input('manufacture_date');
            $spreadcategory->container_number = $request->input('containerized_system') == 'no' ? $request->input('container_number') : $request->input('serial_number');
            // $spreadcategory->container_number =  $request->input('container_number');
            $spreadcategory->purchased_date = $request->input('purchased_date');
            $spreadcategory->size = $request->input('containerized_system') == 'no' ? $request->input('size') : $request->input('onesize');
            $spreadcategory->weight = $request->input('weight');
            $spreadcategory->dimension = $request->input('dimension');
            $spreadcategory->height = $request->input('height');


            if ($request->hasFile('date_sheet_files')) {
                $date_sheets = $request->file('date_sheet_files');
                $sheet = [];
                foreach ($date_sheets as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'uploads/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    $sheet[] = $fileName;
                }
                $spreadcategory->data_sheets = implode('|', $sheet);
            }

            // Handle certificates file upload
            if ($request->hasFile('certificate_files')) {
                $certificates = $request->file('certificate_files');
                $cart = [];
                foreach ($certificates as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'uploads/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    $cart[] = $fileName;
                }
                $spreadcategory->certificates = implode('|', $cart);
            }

            // Handle manual file upload
            if ($request->hasFile('manual_files')) {
                $manuals_files = $request->file('manual_files');
                $manu = [];
                foreach ($manuals_files as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'uploads/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    $manu[] = $fileName;
                }
                $spreadcategory->manuals = implode('|', $manu);
            }


            $result = $spreadcategory->save();
            // $result = 1;

            if ($result) {
                $spreadcategory_id = $spreadcategory->id;

                $categories = $request->input('values', []);
                // $assets = $request->input('assets', []);

                if ($categories !== null) {
                    foreach ($categories as $key => $value) {

                        $spreadCategoryType = new SpreadCategoryType();
                        $spreadCategoryType->spread_category_id = $spreadcategory_id;
                        $spreadCategoryType->category_id = $value;

                        $spreadCategoryType->save();
                    }
                }


                // if ($assets !== null) {
                //     foreach ($assets as  $assetid) {
                //         $asset = Assets::where('id', $assetid)->with('tasks')->first();
                //         $asset->spread_category_id = $spreadcategory_id;
                //         $asset->save();

                //         foreach ($asset->tasks as  $task) {
                //             $task->spread_category_id = $spreadcategory_id;
                //             $task->save();
                //         }
                //     }
                // }
            }

            return redirect()->route('all-spreadcategory')->with('success', 'System created successfully.');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }

    public function updateSpread(Request $request, $id)
    {

        if (!auth()->user()->can('edit spread')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'system_description' => 'required',
        ]);


        try {




            $spreadcategory = SpreadCategory::find($id);

            $spreadcategory->system_description = $request->input('system_description');
            $spreadcategory->manufraturer = $request->input('manufraturer');
            $spreadcategory->class_system = $request->input('class_system');
            $spreadcategory->model_number = $request->input('model_number');
            $spreadcategory->containerized_system = $request->input('containerized_system');
            $spreadcategory->manufacture_date = $request->input('manufacture_date');
            $spreadcategory->container_number = $request->input('containerized_system') == 'no' ? $request->input('container_number') : $request->input('serial_number');
            $spreadcategory->purchased_date = $request->input('purchased_date');
            $spreadcategory->size = $request->input('containerized_system') == 'no' ? $request->input('size') : $request->input('onesize');
            $spreadcategory->weight = $request->input('weight');
            $spreadcategory->dimension = $request->input('dimension');
            $spreadcategory->height = $request->input('height');


            $oldsheets = $spreadcategory->data_sheets ? explode('|', $spreadcategory->data_sheets) : [];
            $newsheet = [];
            $deleteoldsheets = $request->get('sheetselectedfile');
            if ($deleteoldsheets) {
                foreach ($deleteoldsheets as $dos) {
                    $deletefilePath = 'uploads/' . $dos;
                    if (Storage::disk('public')->exists($deletefilePath)) {
                        Storage::disk('public')->delete($deletefilePath);
                    }
                }
                $newsheet = array_values(array_diff($oldsheets, $deleteoldsheets));
            } else {
                $deleteoldsheets = [];
                $newsheet = $oldsheets;
            }
            if ($request->hasFile('date_sheet_files')) {
                $date_sheets = $request->file('date_sheet_files');
                foreach ($date_sheets as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'uploads/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    $newsheet[] = $fileName;
                }
            }
            $spreadcategory->data_sheets = implode('|', $newsheet);



            // Handle certificates file upload
            // if ($request->hasFile('certificate_files')) {
            //     $file = $request->file('certificate_files');
            //     $fileName = time() . '_' . $file->getClientOriginalName();
            //     $filePath = 'uploads/' . $fileName;
            //     Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $spreadcategory->certificates = $fileName;
            // }
            $oldcertificates = $spreadcategory->certificates ? explode('|', $spreadcategory->certificates) : [];
            $newcertificates = [];
            $deleteoldcertificates = $request->get('certificateselectedfile');
            if ($deleteoldcertificates) {
                foreach ($deleteoldcertificates as $dos) {
                    $deletefilePath = 'uploads/' . $dos;
                    if (Storage::disk('public')->exists($deletefilePath)) {
                        Storage::disk('public')->delete($deletefilePath);
                    }
                }
                $newcertificates = array_values(array_diff($oldcertificates, $deleteoldcertificates));
            } else {
                $deleteoldcertificates = [];
                $newcertificates = $oldcertificates;
            }
            if ($request->hasFile('certificate_files')) {
                $certificates = $request->file('certificate_files');
                foreach ($certificates as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'uploads/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    $newcertificates[] = $fileName;
                }
            }
            $spreadcategory->certificates = implode('|', $newcertificates);



            // Handle manual file upload
            // if ($request->hasFile('manual_files')) {
            //     $file = $request->file('manual_files');
            //     $fileName = time() . '_' . $file->getClientOriginalName();
            //     $filePath = 'uploads/' . $fileName;
            //     Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $spreadcategory->manuals = $fileName;
            // }

            $oldmanuals = $spreadcategory->manuals ? explode('|', $spreadcategory->manuals) : [];
            $newmanuals = [];
            $deleteoldmanuals = $request->get('manualselectedfile');
            if ($deleteoldmanuals) {
                foreach ($deleteoldmanuals as $dos) {
                    $deletefilePath = 'uploads/' . $dos;
                    if (Storage::disk('public')->exists($deletefilePath)) {
                        Storage::disk('public')->delete($deletefilePath);
                    }
                }
                $newmanuals = array_values(array_diff($oldmanuals, $deleteoldmanuals));
            } else {
                $deleteoldmanuals = [];
                $newmanuals = $oldmanuals;
            }
            if ($request->hasFile('manual_files')) {
                $manuals = $request->file('manual_files');
                foreach ($manuals as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'uploads/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    $newmanuals[] = $fileName;
                }
            }
            $spreadcategory->manuals = implode('|', $newmanuals);

            $result = $spreadcategory->save();

            // if ($result) {
            //     $spreadcategory_id = $spreadcategory->id;

            //     $values = $request->input('values', []);

            //     if ($values !== null) {

            //         $dlt = SpreadCategoryType::where('spread_category_id', $spreadcategory_id)->pluck('id');


            //         foreach ($values as $key => $value) {

            //             if (SpreadCategoryType::where('value', $value)->exists()) {
            //             } else {
            //                 $spreadCategoryType = new SpreadCategoryType();
            //                 $spreadCategoryType->spread_category_id = $spreadcategory_id;
            //                 $spreadCategoryType->system_id = $request->input('system_id');
            //                 $spreadCategoryType->value = $value;

            //                 if ($request->hasFile('files')) {
            //                     foreach ($request->file('files') as $file) {
            //                         $fileName = time() . '_' . $file->getClientOriginalName();
            //                         $filePath = 'uploads/' . $fileName;
            //                         Storage::disk('public')->put($filePath, file_get_contents($file));
            //                         $spreadCategoryType->file = $fileName;
            //                     }
            //                 }
            //                 $spreadCategoryType->save();
            //             }
            //         }

            //         // return json_encode($dlt);
            //         $sctd = SpreadCategoryType::whereIn('id', $dlt)->get();
            //         // return json_encode($sctd);
            //         foreach ($sctd as $dlted) {
            //             $dlted->delete();
            //         }
            //     }
            // }

            return redirect()->route('all-spreadcategory')->with('success', 'System Updated successfully.');
            //code...
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }



    public function transfersystem($id)
    {

        if (!auth()->user()->can('transfer system')) {
            abort(403, 'Unauthorized Access.');
        }


        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();
        $current_sys = System::where('id', $session->system_id)->first();
        // $sysid->system_type_id


        $spreadcategory = SpreadCategory::where('id', $id)->with('system', 'systemtype')->first();

        $systems = System::where('system_type_id', $spreadcategory->systemtype->id)->with('systemtype')->get();

        // return json_encode($spreadcategory);

        return view('backend_app.spreadcategory.transfer_system', compact('spreadcategory', 'systems', 'current_sys'));
    }
    public function updatetransfersystem(Request $request, $id)
    {

        if (!auth()->user()->can('transfer system')) {
            abort(403, 'Unauthorized Access.');
        }

        $request->validate([
            'system_id' => 'required',
        ]);

        $oldspreadcategory = SpreadCategory::find($id);
        $newSpread = System::find($request->input('system_id'));

        $oldSpread_id = $oldspreadcategory->system_id;

        if ($newSpread->id != $oldspreadcategory->system_id) {


            $oldspreadcategory->system_id = $newSpread->id;
            $oldspreadcategory->save();

            // $spreadcattype = SpreadCategoryType::where('spread_category_id', $oldspreadcategory->id)->get();
            // foreach ($spreadcattype as $sct) {
            //     $sct->system_id = $newSpread->id;
            //     $sct->save();
            // }


            $assets = Assets::where('spread_category_id', $oldspreadcategory->id)->with('tasks')->get();
            foreach ($assets as $asset) {
                $asset->spread_id = $newSpread->id;
                // $asset->category_id = $sct->value;
                $asset->save();

                foreach ($asset->tasks as $task) {
                    $task->system_id = $newSpread->id;
                    $task->save();
                }
            }
            // }
        }
        return redirect()->route('all-spreadcategory')->with('success', 'System Transfer successfully!');
    }

    public function getsystems($new_system_id)
    {
        $systems = SpreadCategory::where('system_type_id', $new_system_id)->where('system_id', null)->get();
        return response()->json($systems);
    }

    public function assignSystem(Request $request)
    {
        try {

            $auth_id = Auth::user()->id;
            $session = SystemSession::where('user_id', $auth_id)->first();
            $sysid = System::where('id', $session->system_id)->first();


            $spreadcategory_id = $request->get('new_system_id');
            $spreadcategory = SpreadCategory::where('id', $spreadcategory_id)->with('assets', 'tasks')->first();

            $spreadcategory->system_id = $sysid->id;
            $spreadcategory->save();

            foreach ($spreadcategory->assets as $asset) {
                $asset->system_id = $request->get('new_system_type_id');
                $asset->spread_id = $sysid->id;
                $asset->save();
            }

            foreach ($spreadcategory->tasks as $task) {
                $task->system_id = $sysid->id;
                $task->save();
            }
            return back()->with('success', "System has been assigned");
        } catch (Exception $e) {
            return back()->with('error', "Something went wrong!");
        }
    }
    public function getUnAssignedAssets(Request $request)
    {
        try {

            $assets = Assets::where('spread_category_id', null)->get();

            return ['success' => 1, 'assets' => $assets];
        } catch (Exception $e) {
            return ['success' => 0];
        }
    }

    public function assignAssetToSystem(Request $request)
    {

        $assetIds = $request->get('assetIds');
        $subcategoryid = $request->input('subcomponentid');
        $spreadcategoryid = $request->input('spreadcategoryid');
        $subcategory = SubCategory::find($subcategoryid);
        $categoryid = $subcategory->category->id;

        $system = SpreadCategory::find($request->input('spreadcategoryid'));

        foreach ($assetIds as $assetid) {


            $asset = Assets::find($assetid);
            $asset->category_id = $categoryid;
            $asset->sub_category_id = $subcategoryid;
            $asset->spread_category_id = $spreadcategoryid;
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

                $task->spread_category_id = $spreadcategoryid;
                $task->frequency = $value->frequency;
                $task->description = $value->description;
                $task->name = $value->name;
                $task->month_year = $value->month_year;
                $task->imca_reference = $value->imca_reference_id;
                $result2 = $task->save();
            }
        }

        return ["success" => 1, "message" => "assigned successfully!"];
    }


    public function unassignSystem(Request $request, $id)
    {
        try {

            $auth_id = Auth::user()->id;
            $session = SystemSession::where('user_id', $auth_id)->first();
            $sysid = System::where('id', $session->system_id)->first();


            $spreadcategory = SpreadCategory::where('id', $id)->with('assets', 'tasks')->first();

            $spreadcategory->system_id = null;
            $spreadcategory->save();

            foreach ($spreadcategory->assets as $asset) {
                $asset->spread_id = null;
                $asset->save();
            }

            foreach ($spreadcategory->tasks as $task) {
                $task->system_id = null;
                $task->save();
            }
            return back()->with('success', "System has been un-assigned");
        } catch (Exception $e) {
            return back()->with('error', "Something went wrong!");
        }
    }
}
