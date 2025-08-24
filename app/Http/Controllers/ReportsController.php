<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Spares;
use App\Models\System;
use App\Models\SystemSession;
use App\Models\Task;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
   public function System_summary_report($id)
   {

      $auth_id = Auth::user()->id;
      $session = SystemSession::where('user_id', $auth_id)->first();
      $sysid = System::where('id', $session->system_id)->first();

      $spread =  System::where('id', $sysid->id)->with('tasks', 'tasks.asset', 'systemtype')->where('system_type_id', $id)->first();


      $spares =  Spares::where('system_name', $id)->get();

      $expiretasks = Task::with('category', 'subcategory')->where('system_id', $id)->whereNull('start_date')->get();


      // $certified = 0;
      // $expiring = 0;
      // $expired = 0;
      // $incomplete = 0;
      // $currentDate = Carbon::now();

      // $certified = Task::where('system_id', $id)->whereNull('start_date')->count();
      // $expiring = Task::where('system_id', $id)->whereNotNull('expire_date')->count();
      // $expired = Task::where('system_id', $id)->where('expire_date', '>', $currentDate)->count();
      // $incomplete = Task::where('system_id', $id)->where('expire_date', '<', $currentDate)->count();
      $certified = 0;
      $expiring = 0;
      $expired = 0;
      $incomplete = 0;
      $assets = Assets::where('spread_id', $sysid->id)->whereNotNull('spread_category_id')->get();
      foreach ($assets as $asset) {

         $tasks = Task::where('asset_id', $asset->id)->get();
         foreach ($tasks as $task) {
            if ($task && $task->active==1) {
               if ($task->status() == 'Certified') {
                  $certified++;
               } else if ($task->status() == 'Expired') {
                  $expired++;
               } else if ($task->status() == 'Expiring') {
                  $expiring++;
               } else {
                  $incomplete++;
               }
            }
         }
      }



      //  return view('backend_app.templates.system_summary_report' ,compact('spread' ,'spares', 'certified', 'expiring', 'expired', 'incomplete'));

      $pdf = PDF::loadView('backend_app.templates.system_summary_report', compact('spread', 'spares', 'certified', 'expiring', 'expired', 'incomplete'));
      return $pdf->stream('system_summary_report');
   }
   public function generate_pdf($id)
   {

      // $auth_id = Auth::user()->id;
      // $session = SystemSession::where('user_id', $auth_id)->first();
      // $sysid = System::where('id', $session->system_id)->first(); 

      $system = System::with('systemtype')->where('id', $id)->first();

      $assets = Assets::where('spread_id', $id)->whereNotNull('spread_category_id')->with('tasks')->get();
      // return json_encode($assets);

      $pdf = PDF::loadView('backend_app.dashboard.generate_pdf', compact('assets', 'system'));

      return $pdf->stream($system->system_name . '_work_order.pdf');
   }

   public function expiring_generate_pdf($id)
   {


      $system = System::with('systemtype')->where('id', $id)->first();
      $tasks = [];

      $data = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
        FROM `tasks` as tsk
        LEFT JOIN `system_assets` as assets
        ON assets.id = tsk.asset_id
        LEFT JOIN `categories` as cat 
        ON cat.id = assets.category_id
        WHERE tsk.system_id = $id AND assets.status IS NULL  AND tsk.active = 1 AND tsk.frequency!=0
         AND tsk.expire_date >= CURRENT_DATE 
        AND tsk.expire_date <= CURRENT_DATE + INTERVAL 31 DAY");

      foreach ($data as $task) {
         $tsk = Task::where('id', $task->task_id)->with('asset')->get();
         foreach ($tsk as $tk) {
            $tasks[] = $tk;
         }
      }

      // return json_encode($tasks);

      $pdf = PDF::loadView('backend_app.dashboard.expiring_generate_pdf', compact('tasks', 'system'));

      return $pdf->stream($system->system_name . '_expiring_work_order.pdf');
   }
   public function expired_generate_pdf($id)
   {


      $system = System::with('systemtype')->where('id', $id)->first();
      $tasks = [];

      $data = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
   FROM `tasks` as tsk
   LEFT JOIN `system_assets` as assets
   ON assets.id = tsk.asset_id
   LEFT JOIN `categories` as cat 
   ON cat.id = assets.category_id
   WHERE tsk.system_id = $id AND assets.status IS NULL  AND tsk.active = 1 AND tsk.frequency!=0
   AND tsk.expire_date < CURRENT_DATE ");

      foreach ($data as $task) {
         $tsk = Task::where('id', $task->task_id)->with('asset')->get();
         $tasks[] = $tsk;
      }

      // return json_encode($tasks);

      $pdf = PDF::loadView('backend_app.dashboard.expired_generate_pdf', compact('tasks', 'system'));

      return $pdf->stream($system->system_name . '_expired_work_order.pdf');
   }

   public function incomplete_generate_pdf($id)
   {


      $system = System::with('systemtype')->where('id', $id)->first();
      $tasks = [];

      $data = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
   FROM `tasks` as tsk
   LEFT JOIN `system_assets` as assets
   ON assets.id = tsk.asset_id
   LEFT JOIN `categories` as cat 
   ON cat.id = assets.category_id
   WHERE tsk.system_id = $id AND assets.status IS NULL  AND tsk.active = 1 AND tsk.frequency!=0
   AND tsk.start_date IS NULL");

      foreach ($data as $task) {
         $tsk = Task::where('id', $task->task_id)->with('asset')->first();
         $tasks[] = $tsk;
      }

      // return json_encode($tasks);

      $pdf = PDF::loadView('backend_app.dashboard.expired_generate_pdf', compact('tasks', 'system'));

      return $pdf->stream($system->system_name . '_incomplete_work_order.pdf');


   //    $system = System::with('systemtype')->where('id', $id)->first();
   //    $tasks = [];

   //    $data = DB::select("SELECT tsk.id as task_id, assets.id as asset_id, tsk.system_id as system_id, tsk.task_type, tsk.imca_reference, tsk.description, tsk.start_date, tsk.expire_date, assets.description, assets.status, cat.id as category_id, cat.name
   // FROM `tasks` as tsk
   // LEFT JOIN `system_assets` as assets
   // ON assets.id = tsk.asset_id
   // LEFT JOIN `categories` as cat 
   // ON cat.id = assets.category_id
   // WHERE tsk.system_id = $id AND assets.status IS NULL  AND tsk.active = 1
   // AND tsk.expire_date IS NULL ");

   //    foreach ($data as $task) {
   //       $tsk = Task::where('id', $task->task_id)->with('asset')->get();
   //       $tasks[] = $tsk;
   //    }

   //    // return json_encode($tasks);

   //    $pdf = PDF::loadView('backend_app.dashboard.expired_generate_pdf', compact('tasks', 'system'));

   //    return $pdf->stream($system->system_name . '_expired_work_order.pdf');
   }

   public function System_orders_report()
   {
      $pdf = PDF::loadView('backend_app.templates.system_orders_report');
      return $pdf->stream('generate_pdf');
   }
   public function System_design_report()
   {
      $pdf = PDF::loadView('backend_app.templates.system_design_report');
      return $pdf->stream('generate_pdf');
   }
   public function System_cart_report()
   {
      $pdf = PDF::loadView('backend_app.templates.system_cart_report');
      return $pdf->stream('generate_pdf');
   }
}