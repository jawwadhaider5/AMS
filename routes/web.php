<?php

use App\Http\Controllers\AssetsController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryViewsController; 
use App\Http\Controllers\MainController; 
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\IMCAController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\MaintenaceController;
use App\Http\Controllers\PreTaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QurantineController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SparesController;
use App\Http\Controllers\SpreadCategoryController;  
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\SystemController; 
use App\Http\Controllers\SystemTypeController;
use App\Http\Controllers\TaskTypeController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
 

use Illuminate\Support\Facades\Artisan; 
 
 
Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
 
    return "Cleared!";
 
 });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
Route::get('/dashboard',[MainController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard_system',[MainController::class,'system_dashboard'])->middleware(['auth', 'verified'])->name('system_dashboard');

// Route::get('/dashboard_all',[MainController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/dashboard',[MainController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/categories-update', [MainController::class, 'categoriesupdate']);
Route::post('/categories-change', [MainController::class, 'categories_change']);
Route::post('/imca-change', [MainController::class, 'imca_change']);
Route::get('/get-systemtype-id', [MainController::class, 'getSystemTypeId']);
Route::post('/set-systemtype-id', [MainController::class, 'setSystemTypeId']);

Route::get('/save-systemtype-id/{id}', [MainController::class, 'saveSystemTypeId'])->name('save-systemtype-id');
Route::get('/maintenace',[MaintenaceController::class,'index'])->middleware(['auth', 'verified'])->name('maintenace');
Route::get('/maintenace/update/{id}',[MaintenaceController::class,'maintence_move'])->name('move-maintenace');
Route::put('assign/maintenace/{id}',[MaintenaceController::class,'assetsupdate'])->name('maintenance-asset-update');
Route::get('maintenace/generete/pdf/{id}', [MaintenaceController::class, 'generate_pdf'])->name('maintenace-generate-pdf');

Route::get('/qurantine',[QurantineController::class,'index'])->middleware(['auth', 'verified'])->name('qurantine');
Route::get('qurantine/{id}',[QurantineController::class,'edit'])->name('edit-qurantine');
// User
Route::get('edit-profile',[ProfileController::class,'edit_profile'])->name('edit_profile');
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::POST('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('update-password',[ProfileController::class,'update_password'])->name('update-password');

//Assets
Route::prefix('assets')->group(function(){
Route::get('all',[AssetsController::class,'index'])->name('all-assets');
Route::get('add',[AssetsController::class,'create'])->name('add-assets');
Route::get('/ajax_add', [AssetsController::class, 'ajax_add'])->name('asset-ajax-add');
Route::get('/ajax_add/withoutsystem', [AssetsController::class, 'ajax_add_without_system'])->name('asset-ajax-add-without-system');
Route::post('store',[AssetsController::class,'store'])->name('store-asset');
Route::get('edit/{id}',[AssetsController::class,'edit'])->name('edit-asset');
Route::get('assign/{id}',[AssetsController::class,'assignproject'])->name('assign-asset');

Route::get('transfer/{id}',[AssetsController::class,'transferassets'])->name('tranfer-asset');
Route::put('assign/project/{id}',[AssetsController::class,'assign'])->name('project-asset');
Route::put('transfer/asset/{id}',[AssetsController::class,'updatetransferasset'])->name('transfer-asset');
Route::put('update2/{id}',[AssetsController::class,'update2'])->name('update-asset2');
Route::put('update/{id}',[AssetsController::class,'update'])->name('update-asset');
Route::get('delete/{id}',[AssetsController::class,'destroy'])->name('delete-asset'); 
Route::get('active/{id}',[AssetsController::class,'assets_active'])->name('asset-active');

Route::get('deactivate/{id}',[AssetsController::class,'deactivate_task'])->name('deactivate-task');
Route::get('reactivate/{id}',[AssetsController::class,'reactivate_task'])->name('reactivate-task');
////// search assets on name
Route::post('/search', [AssetsController::class, 'search'])->name('asset-search');

Route::get('/qrcode/{id}', [AssetsController::class, 'qrcode'])->name('asset-qrcode');
Route::get('/qrcodepdf/{id}', [AssetsController::class, 'qrcodepdf'])->name('asset-qrcode-pdf');

///asset file upload 
Route::post('file/',[AssetsController::class,'asset_file_upload'])->name('asset-file');

//// show assets when click on asset id on the base of category and sub category id 
Route::get('category/{id}',[AssetsController::class,'assetcategory'])->name('asset-category-edit');


Route::post('taskstore',[AssetsController::class,'storetask'])->name('asset-store-task');
Route::get('/generete/pdf/{id}', [AssetsController::class, 'generate_pdf'])->name('generate-pdf');
Route::get('/auditlog/{id}', [AssetsController::class, 'auditlog'])->name('audit-log');
Route::get('subcategory/{id}',[AssetsController::class,'all_subcategory_asset'])->name('asset-subcategory-edit');

///// edit and update
Route::put('assign/taskupdate/{id}',[AssetsController::class,'updatetask'])->name('update-asset-task');
Route::put('renewtaks/{id}',[AssetsController::class,'renewtask'])->name('renewtask-asset');
Route::put('uploadfile/{id}',[AssetsController::class,'uploadfile'])->name('uploadfile-asset');
Route::get('maintenance/{id}',[MaintenaceController::class,'edit'])->name('edit-maintenance');

});

Route::get('/alluploadfile/delete/{id}',[AssetsController::class,'allfiledelete'])->name('delete-allfile');
Route::put('alluploadfile/{id}',[AssetsController::class,'alluploadfile'])->name('alluploadfile-asset');

Route::get('asset-tasktype/{task_type_id}', [AssetsController::class,'tasktype']);

Route::post('/assign-bulk-project-form', [AssetsController::class, 'showAssignProjectForm'])->name('assign-bulk-project-form');
Route::put('/assign-bulk-project', [AssetsController::class, 'assignBulkProject'])->name('assign-bulk-project');
Route::get('/get-system-modal/{asset_id}', [AssetsController::class, 'getSystemModal']);
Route::post('/asset-system', [AssetsController::class, 'assetAssignSystem'])->name('asset-assign-system');
Route::get('/unassign/{id}',[AssetsController::class,'assetUnAssignSystem'])->name('unassign-asset');

// Category Views

Route::get('category-all',[CategoryViewsController::class,'index'])->name('categoryview-all');
Route::get('category-add',[CategoryViewsController::class,'create'])->name('categoryview-add');
Route::get('category-edit/{id}',[CategoryViewsController::class,'edit'])->name('categoryview-edit');
Route::get('category-update/{id}',[CategoryViewsController::class,'update'])->name('categoryview-update');
Route::get('category-show/{id}',[CategoryViewsController::class,'show'])->name('show-categoryview');

//Category Pages
Route::prefix('category')->group(function(){
    Route::get('all',[CategoryController::class,'index'])->name('all-category');
    Route::get('add',[CategoryController::class,'create'])->name('add-category');
    Route::post('store',[CategoryController::class,'store'])->name('store-category');
    Route::get('edit/{id}',[CategoryController::class,'edit'])->name('edit-category');
    Route::put('update/{id}',[CategoryController::class,'update'])->name('update-category');
    Route::get('delete/{id}',[CategoryController::class,'destroy'])->name('delete-category');

    Route::get('transfer/{id}',[CategoryController::class,'transfercategory'])->name('transfer-category'); 
    Route::put('transfer/category/{id}',[CategoryController::class,'updatetransfercategory'])->name('update-transfer-category');

});
Route::get('/get-system-categories/{system_id}', [CategoryController::class, 'getcategories']);
Route::get('/get-categories/{system_id}', [CategoryController::class, 'getcategoriess']);
Route::get('/get-subcategories2/{category_id}', [CategoryController::class, 'getSubcategories2']);

Route::get('/get-subcategories/{category_id}', [CategoryController::class, 'getSubcategories']);
Route::get('/get-systems/{category_id}', [CategoryController::class, 'getSystems']);

//spares routes 
Route::prefix('spares')->group(function(){
    Route::get('all',[SparesController::class,'index'])->name('all-spares');
    Route::get('add',[SparesController::class,'create'])->name('add-spares');
    Route::post('store',[SparesController::class,'store'])->name('store-spares');
    Route::get('edit/{id}',[SparesController::class,'edit'])->name('edit-spares');
    Route::put('update/{id}',[SparesController::class,'update'])->name('update-spares');
    Route::get('delete/{id}',[SparesController::class,'destroy'])->name('delete-spares');
    Route::post('/ajax_add_spare', [SparesController::class, 'ajax_add'])->name('add-spare-ajax');
});
//sub categories
Route::prefix('subcategory')->group(function(){
    Route::get('all',[SubCategoriesController::class,'index'])->name('all-subcategory');
    Route::get('add',[SubCategoriesController::class,'create'])->name('add-subcategory');
    Route::post('store',[SubCategoriesController::class,'store'])->name('store-subcategory');
    Route::get('edit/{id}',[SubCategoriesController::class,'edit'])->name('edit-subcategory');
    Route::put('update/{id}',[SubCategoriesController::class,'update'])->name('update-subcategory');
    Route::get('delete/{id}',[SubCategoriesController::class,'destroy'])->name('delete-subcategory');

    Route::get('transfer/{id}',[SubCategoriesController::class,'transfersubcategory'])->name('transfer-sub-category'); 
    Route::put('transfer/subcategory/{id}',[SubCategoriesController::class,'updatetransfersubcategory'])->name('update-transfer-sub-category');


    });
    
    Route::post('addsubcategory',[SubCategoriesController::class,'addsubcategory']);

    Route::prefix('project')->group(function(){
        Route::get('all',[ProjectController::class,'index'])->name('all-projects');
        Route::get('add',[ProjectController::class,'create'])->name('add-project');
        Route::post('store',[ProjectController::class,'store'])->name('store-project');
        Route::get('edit/{id}',[ProjectController::class,'edit'])->name('edit-project');
        Route::put('update/{id}',[ProjectController::class,'update'])->name('update-project');
        Route::get('delete/{id}',[ProjectController::class,'destroy'])->name('delete-project');

        Route::get('start/{id}',[ProjectController::class,'start'])->name('start-project'); 
        Route::get('close/{id}',[ProjectController::class,'close'])->name('close-project');
        });

    Route::prefix('systemtype')->group(function(){
        Route::get('all',[SystemTypeController::class,'index'])->name('all-systemtype');
        Route::get('add',[SystemTypeController::class,'create'])->name('add-systemtype');
        Route::post('store',[SystemTypeController::class,'store'])->name('store-systemtype');
        Route::get('show/{id}',[SystemTypeController::class,'show'])->name('show-systemtype');
        Route::get('edit/{id}',[SystemTypeController::class,'edit'])->name('edit-systemtype');
        Route::put('update/{id}',[SystemTypeController::class,'update'])->name('update-systemtype');
        Route::get('delete/{id}',[SystemTypeController::class,'destroy'])->name('delete-systemtype');
    });

    Route::prefix('locations')->group(function(){
        Route::get('all',[LocationsController::class,'index'])->name('all-locations');
        Route::get('add',[LocationsController::class,'create'])->name('add-locations');
        Route::post('store',[LocationsController::class,'store'])->name('store-locations');
        Route::get('edit/{id}',[LocationsController::class,'edit'])->name('edit-locations');
        Route::put('update/{id}',[LocationsController::class,'update'])->name('update-locations');
        Route::get('delete/{id}',[LocationsController::class,'destroy'])->name('delete-locations');
    });

        Route::prefix('spreadcategory')->group(function(){
            Route::get('all',[SpreadCategoryController::class,'index'])->name('all-spreadcategory');
            Route::get('add',[SpreadCategoryController::class,'create'])->name('add-spreadcategory');
            Route::post('store',[SpreadCategoryController::class,'store'])->name('store-spreadcategory');
            Route::get('show/{id}',[SpreadCategoryController::class,'show'])->name('show-spreadcategory');
            Route::get('edit/{id}',[SpreadCategoryController::class,'edit'])->name('edit-spreadcategory');
            Route::put('update/{id}',[SpreadCategoryController::class,'update'])->name('update-spreadcategory');
            Route::get('delete/{id}',[SpreadCategoryController::class,'destroy'])->name('delete-spreadcategory');
            Route::get('search-systems/{id}',[SpreadCategoryController::class,'searchSystems'])->name('search-systems');
            Route::post('store-spread',[SpreadCategoryController::class,'storeSpread'])->name('store.Spread');
            Route::PUT('update-spread/{id}',[SpreadCategoryController::class,'updateSpread'])->name('update.Spread');

            Route::get('transfer/{id}',[SpreadCategoryController::class,'transfersystem'])->name('transfer-system'); 
            Route::put('transfer/system/{id}',[SpreadCategoryController::class,'updatetransfersystem'])->name('update-transfer-system');


            Route::get('/get-systems/{new_system_type_id}', [SpreadCategoryController::class, 'getSystems']);
            Route::get('/assign-system', [SpreadCategoryController::class, 'assignSystem']);
            Route::get('/unassign-system/{id}', [SpreadCategoryController::class, 'unassignSystem'])->name('un-assign-system');
            Route::get('/get-all-unassigned-assets', [SpreadCategoryController::class, 'getUnAssignedAssets']);
            Route::get('/assign-asset-to-system', [SpreadCategoryController::class, 'assignAssetToSystem']);
            Route::get('/get-subcomponents-by-category', [SpreadCategoryController::class, 'getSubcomponentsByCategory']);


        });

    Route::prefix('tasktype')->group(function(){
        Route::get('all',[TaskTypeController::class,'index'])->name('all-tasktype');
        Route::get('add',[TaskTypeController::class,'create'])->name('add-tasktype');
        Route::post('store',[TaskTypeController::class,'store'])->name('store-tasktype');
        Route::get('edit/{id}',[TaskTypeController::class,'edit'])->name('edit-tasktype');
        Route::put('update/{id}',[TaskTypeController::class,'update'])->name('update-tasktype');
        Route::get('delete/{id}',[TaskTypeController::class,'destroy'])->name('delete-tasktype');
        });
//   predefine task added
        Route::prefix('pretask')->group(function(){
            Route::get('all',[PreTaskController::class,'index'])->name('all-pretask');
            Route::get('add',[PreTaskController::class,'create'])->name('add-pretask');
            Route::post('store',[PreTaskController::class,'store'])->name('store-pretask');
            Route::get('show/{id}',[PreTaskController::class,'show'])->name('show-pretask');
            Route::get('edit/{id}',[PreTaskController::class,'edit'])->name('edit-pretask');
            Route::put('update/{id}',[PreTaskController::class,'update'])->name('update-pretask');
            Route::get('delete/{id}',[PreTaskController::class,'destroy'])->name('delete-pretask');
            });

        Route::prefix('imca')->group(function(){
            Route::get('all',[IMCAController::class,'index'])->name('all-imca');
            Route::get('add',[IMCAController::class,'create'])->name('add-imca');
            Route::post('store',[IMCAController::class,'store'])->name('store-imca');
            Route::get('edit/{id}',[IMCAController::class,'edit'])->name('edit-imca');
            Route::put('update/{id}',[IMCAController::class,'update'])->name('update-imca');
            Route::get('delete/{id}',[IMCAController::class,'destroy'])->name('delete-imca');
        });

        Route::prefix('system')->group(function(){
            Route::get('all',[SystemController::class,'index'])->name('all-system');
            Route::get('add',[SystemController::class,'create'])->name('add-system');
            Route::post('store',[SystemController::class,'store'])->name('store-system');
            Route::get('edit/{id}',[SystemController::class,'edit'])->name('edit-system');
            Route::put('update/{id}',[SystemController::class,'update'])->name('update-system');
            Route::get('delete/{id}',[SystemController::class,'destroy'])->name('delete-system');
            });

   });

Route::group(['middleware' => ['role:super-admin|admin']], function() {
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
    Route::get('user/{userId}', [App\Http\Controllers\UserController::class, 'show'])->name('user-detail');
    Route::get('setting',[SettingController::class,'index'])->name('setting');
    Route::POST('update-setting',[SettingController::class,'update'])->name('update-setting');

});

Route::prefix('reports')->group(function(){
    Route::get('system/summary/{id}',[ReportsController::class,'System_summary_report'])->name('system-summary'); 
    Route::get('workorder/pdf/{id}', [ReportsController::class, 'generate_pdf'])->name('work-order-pdf');
    Route::get('expiring-workorder/pdf/{id}', [ReportsController::class, 'expiring_generate_pdf'])->name('expiring-work-order-pdf');
    Route::get('expired-workorder/pdf/{id}', [ReportsController::class, 'expired_generate_pdf'])->name('expired-work-order-pdf');
    Route::get('incomplete-workorder/pdf/{id}', [ReportsController::class, 'incomplete_generate_pdf'])->name('incomplete-work-order-pdf');
    Route::get('system/orders',[ReportsController::class,'System_orders_report'])->name('system-orders'); 
    Route::get('system/design',[ReportsController::class,'System_design_report'])->name('system-design'); 
    Route::get('system/cart',[ReportsController::class,'System_cart_report'])->name('system-cart'); 

});

Route::get('/ajax-subcategories/{id}',[CategoryController::class,'ajaxCategory'])->name('ajaxCategory');
Route::get('/shift-component',[CategoryController::class,'shift_component'])->name('shiftComponent');
Route::get('/shift-sub-component',[CategoryController::class,'shift_sub_component'])->name('shiftSubComponent');
Route::get('/shift-assets',[CategoryController::class,'shift_assets'])->name('shiftAssets');


Route::get('/spare/delete/{spare}',[AssetsController::class,'delete_spare'])->name('delete-spare');
Route::get('/pdf/delete/{filename}',[AssetsController::class,'delete_pdf'])->name('delete-pdf');

Route::get('/pdf/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);

    if (!FIle::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('open-pdf');

Route::get('/allasset/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);

    if (!FIle::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('open-allasset');


require __DIR__.'/auth.php';