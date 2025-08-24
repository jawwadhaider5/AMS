@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">
   include('backend_app.layouts.nav')

   <div class="content-wrapper"> -->

@section('head')
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">All Tasks</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Tasks</a></li>
               <li class="breadcrumb-item active">Details</li>
            </ol>
         </div>
      </div>
   </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">

   <div class="row mb-3">
      <div class="col-12">
         <div class="card p-1">
            <div class="table-responsive text-nowrap" style="max-height: 250px;overflow-y:scroll;">
               <table class="table">
                  <thead>
                     <tr class="text-nowrap">
                        <!-- <td><input type="checkbox" name="items[]"></td> -->
                        <th class="text-left">Asset ID </th>
                        <th class="text-left">Description </th>
                        <th class="text-left">System</th>
                        <th class="text-left">Manufacturer</th>
                        <th class="text-left">Model</th>
                        <th class="text-left">Serial Number</th>
                        <!--  -->
                        <th class="text-left">Critical Safety</th>
                        <th class="text-left">Nde Own or Not</th>
                        <th class="text-left">Location</th>
                        <!-- <th class="text-left">Project</th> -->
                        <!-- <th class="text-left">Class</th> -->
                        <!-- <th class="text-left">Class Code</th> -->
                        <th class="text-right">Action</th>
                     </tr>
                  <tbody id="table-body">


                     @can('all asset')
                     @foreach ($data as $all_asset)
                     <tr class="{{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">
                        <!-- <td><input type="checkbox" name="items[]"></td> -->
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">@can('all asset') <a href="{{ route('asset-category-edit', $all_asset->id) }}" @endcan>{{$all_asset->id}}</a></td>
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->description}}</td>
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->spreadcategory->system_description}}</td>
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->manufacturer}}</td>
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->system_modal}}</td>
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->serial_no}}</td> 
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->sefety_critical}}</td>
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->own}}</td> 
                        <!-- <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->system_project}}</td> -->
                        <!-- <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->system_class}}</td> -->
                        <!-- <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->class_code}}</td>     -->
                        <td class="text-left {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">{{$all_asset->assetlocation ? $all_asset->assetlocation->name : ''}} </td>
                        <td class="text-right {{ $asset->id == $all_asset->id ? 'bg-secondary' : '' }}">
                           @can('edit asset')
                           <a href="{{ route('edit-asset', $all_asset->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                              <i class="fas fa-edit"></i>
                           </a>
                           @endcan
                           @can('transfer asset')
                           <a title="Transfer Asset to another System" class="btn btn-sm btn-outline-info hide-read-only" href="{{ route('tranfer-asset', $all_asset->id) }}">
                              <i class="fa fa-arrow-right"></i>
                           </a>
                           @endcan
                           @can('edit asset')
                           <a href="{{route('edit-qurantine',$all_asset->id)}}" class="btn btn-sm btn-outline-primary" title="qurantine assets">
                              <i class="fa fa-exclamation-triangle"></i>
                           </a>
                           @endcan
                           @can('view asset')
                           <a href="{{route('asset-qrcode',$all_asset->id)}}" class="btn btn-sm btn-outline-primary" title="Scan the QR code">
                              <i class="fa fa-qrcode"></i>
                           </a>
                           @endcan
                           @can('unassign asset')
                           <a href="{{route('unassign-asset',$asset->id)}}" class="btn btn-sm btn-outline-primary" title="Unassign assets">
                              <i class="fa fa-undo"></i>
                           </a>
                           @endcan 
                           @can('delete asset')
                           <a href="{{ route('unassign-asset', $all_asset->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                           </a>
                           @endcan
                        </td>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="container">
                                       <div class="row">
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Asset</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Manufacturer</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Model</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Serial No.</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Location.</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Structure Group</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>

                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Safety Critical</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                        
                                          <div class= "col-lg-6 col-sm-12 col-md-6 mt-3">
                                             
                                              <label for="">Nde own or Not</label>
                                              <input class ="form-control" type="text" readonly value ="1154.4584">
                                              
                                              
                                          </div>
                                          <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                             <label for="">Project</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                                             <label for="">Class</label>
                                             <input class="form-control" type="text" readonly value="1154.4584">
                                          </div>
                                          <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                                             <label for="">Description</label>
                                             <textarea name="" id="" class="form-control" cols="30" rows="3"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </tr>
                     @endforeach
                     @endcan
                  </tbody>
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">

      </div>
   </div>
   <!-- edit task and renew task start-->

   <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12">
         <!--/ Tasks Timeline -->

         <div class="row">
            <div class="col-12 ">
               <div class="card card-action mb-4">
                  <div class="card-header align-items-center">
                     <h5 class="card-action-title mb-0">Tasks List</h5>
                  </div>
                  <?php

                  use Illuminate\Support\Facades\Auth;

                  foreach ($tasks as $key => $task) : ?>

                     <?php
                     if ($task->active == 0) {
                        $buttonClass = 'btn-dark';
                     } else if ($task->status() == "Certified") {
                        $buttonClass = 'btn-success';
                     } else if ($task->status() == "Expiring") {
                        $buttonClass = 'btn-warning';
                     } else if ($task->status() == "Expired") {
                        $buttonClass = 'btn-danger';
                     } else if ($task->status() == "Incomplete") {
                        $buttonClass = 'btn-secondary';
                     } else {
                        $buttonClass = 'btn-secondary';
                     }

                     ?>
                     <div class="p-1">
                        <div class="accordion accordion-flush " id="accordionFlushExample<?= $key ?>">
                           <div class="accordion-item border-bottom">
                              <button class="w-100 text-left collapsed btn {{ $buttonClass }} text-decoration-none" type="button" data-toggle="collapse" data-target="#flush-collapseOne{{ $key }}" aria-expanded="false" aria-controls="flush-collapseOne{{ $key }}">
                                 {{ $task->name }} - {{ $task->frequency }} - {{ $task->month_year }}
                                 <span class="float-end"><b>IMCA Ref:</b> {{ $task['tasktype']['name'] ?? ''}}</span>
                              </button>
                              <div id="flush-collapseOne<?= $key ?>" class="accordion-collapse collapse" data-parent="#accordionFlushExample<?= $key ?>">
                                 <div class="accordion-body">
                                    <div class="card-body border">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <b>Task ID:</b>{{$task['id']}}
                                          </div>
                                          <div class="col-md-6 text-end">
                                             <b>IMCA Ref:</b>{{ $task['tasktype']['name'] ?? ''}}
                                          </div>
                                       </div>
                                       <br><br>
                                       <div class="row">
                                          <div class="col-md-8">
                                             <b>IMCA D018 Requirements:</b>
                                             {{ $task['description']}}
                                             <br>
                                             <b>Maintenance Routine Notes:</b> {{ $task['notes']}}
                                          </div>
                                          <div class="col-md-4 text-end">
                                             <b>Start Date:</b> {{ $task['start_date'] ? date('Y-m-d', strtotime($task['start_date'])) : '' }} &nbsp;/&nbsp;
                                             <b>Expiry Date:</b> {{ $task['expire_date'] ? date('Y-m-d', strtotime($task['expire_date'])) : '' }}
                                          </div>
                                       </div>
                                       <br><br>
                                       <label class="text-muted pull-right"><i>Last modified date:
                                             {{ date('Y-m-d', strtotime($task['updated_at'] ?? '')) }}</i></label>
                                    </div>
                                 </div>
                                 <div class="card-footer">
                                    <div class="text-center">
                                       <a class="btn btn-primary text-white @if($task->frequency == 0 || $task->active == 0) d-none @endif" data-id="{{ $task['id']}}" data-toggle="modal" data-target="#edit_modal<?= $key ?>">Renew Task</a>
                                       <a data-toggle="modal" data-target="#renewmodal<?= $key ?>" class="btn btn-outline-primary @if($task->frequency == 0 || $task->active == 0) d-none @endif">Edit Task</a>
                                       <a class="btn btn-outline-success @if($task->active == 0) d-none @endif" data-toggle="modal" data-target="#file_modal<?= $key ?>">Files</a>
                                       <a href="{{ route('deactivate-task', $task['id']) }}" onclick="return confirm('Are you sure you want to Deactivate the task?')" class="btn btn-outline-danger @if($task->active == 0) d-none @endif">Deactivate Task</a>
                                       <a href="{{ route('reactivate-task', $task['id']) }}" onclick="return confirm('Are you sure you want to activate the task?')" class="btn btn-outline-success @if($task->active == 1) d-none @endif">Re-activate Task</a>
                                    </div>
                                 </div>
                              </div>

                              {{-- file upload Modal --}}
                              <div class="modal fade" id="file_modal<?= $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog" style="min-width: 90%;">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel_2">Uplaod File
                                          </h1>
                                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <form action="{{ route('uploadfile-asset', $task['id'])}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          @method('PUT')
                                          <div class="modal-body">
                                             <div class="modal-body">
                                                <div class="RadAjaxPanel" id="" style="display: block;">
                                                   <div id="MainContent_MainAreaContent_pnlRenewTask" style="visibility: visible;">
                                                      <table cellspacing="0" id="MainContent_MainAreaContent_fwRenewTask" style="border-collapse:collapse; width:100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2">

                                                                  <div class="row">
                                                                     <div class="col-12">
                                                                        <div class="accordion" id="accordionExample">

                                                                           <div class="accordion-item border-bottom">
                                                                              <h2 class="accordion-header">
                                                                                 <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                                    Add Attachment
                                                                                 </button>
                                                                              </h2>
                                                                              <div id="collapseTwo" class="accordion-collapse collapse show" data-parent="#accordionExample">
                                                                                 <div class="accordion-body">
                                                                                    <div class="w-100">
                                                                                       <!-- <label class="">Attach</label>
                                                                                       <input class="form-control" type="file" name="attach_file2"> -->

                                                                                       <div class="input-group mb-3 file">
                                                                                          <input type="file" multiple class="form-control fileinput" name="attach_file2[]">
                                                                                          <div class="input-group-append">
                                                                                             <span class="btn btn-danger file_clear">Clear</span>
                                                                                          </div>
                                                                                       </div>


                                                                                    </div>
                                                                                    <table class="table my-2 table-bordered">
                                                                                       <thead class="bg-primary text-white">
                                                                                          <tr>
                                                                                             <th class="text-white">File Name</th>
                                                                                             <th class="text-white">Date Created</th>
                                                                                             <th class="text-white">Action</th>
                                                                                          </tr>
                                                                                       </thead>
                                                                                       <tbody>

                                                                                          @foreach ($task->asset_files as $assetfile)
                                                                                          <tr>
                                                                                             <td>{{$assetfile->file}}</td>
                                                                                             <td>{{date('d-m-Y', strtotime($assetfile->created_at))}}</td>
                                                                                             <td> <button class="btn btn-label-danger">
                                                                                                   <a href="{{ route('open-pdf', $assetfile->file) }}" target="_blank"><i class="fa fa-download"></i>open
                                                                                                   </a>
                                                                                                </button>
                                                                                                <a href="{{ route('delete-pdf', $assetfile->id) }}" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash text-danger"></i>
                                                                                                </a>
                                                                                             </td>
                                                                                          </tr>
                                                                                          @endforeach
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                                  <br>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-primary">Save
                                                changes</button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              {{-- file upload end  --}}

                              {{-- Renew Modal --}}
                              <div class="modal fade" id="renewmodal<?= $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog" style="min-width: 90%;">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel_2">Update Task
                                          </h1>
                                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <form action="{{ route('renewtask-asset', $task['id'])}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          @method('PUT')
                                          <div class="modal-body">
                                             <div class="modal-body">
                                                <div class="RadAjaxPanel" id="" style="display: block;">
                                                   <div id="MainContent_MainAreaContent_pnlRenewTask" style="visibility: visible;">
                                                      <table cellspacing="0" id="MainContent_MainAreaContent_fwRenewTask" style="border-collapse:collapse; width:100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2">
                                                                  <div class="">
                                                                     <h6>By clicking 'Renew' you
                                                                        are verifying that
                                                                        <i>Task No:
                                                                           {{ $task['id']}} - PRV
                                                                           - Re-set &amp;
                                                                           {{ $task['task_type']}} -
                                                                           1037.6749</i> has
                                                                        been carried out as
                                                                        detailed in the work
                                                                        order and that all was
                                                                        found to be in good
                                                                        working condition.
                                                                     </h6>
                                                                     <br>
                                                                     <b>IMCA Ref:</b> Sheet 24.3
                                                                     <br>
                                                                     <h6><b>IMCA D018
                                                                           Requirements:
                                                                        </b> {{ $task['description']}}<br>
                                                                        <br>
                                                                        <b>Maintenance
                                                                           Routine:</b>
                                                                        {{ $task['tasktype']['description']}}
                                                                     </h6>
                                                                     <br>
                                                                     <div class="row">
                                                                        <div class="col-sm-9">
                                                                           <h6><b>Notes</b>
                                                                           </h6>
                                                                           <textarea required name="newtask_notes" rows="5" cols="20" maxlength="1300" id="MainContent_MainAreaContent_fwRenewTask_txtTaskRenewNotes" class="form-control" onkeyup="textCounter(this.id, 'renewNotesCounter', 1300)" onkeydown="textCounter(this.id, 'renewNotesCounter', 1300)">{{ $task['renew_notes'] ? $task['renew_notes'] : '' }}</textarea>
                                                                           <label class="h6 text-muted" id="renewNotesCounter">1300
                                                                              characters
                                                                              left</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                           <div class="row">
                                                                              <div class="col-sm-12" style="margin-bottom: 10px;">
                                                                                 <h6><b>Date</b> </h6>
                                                                                 <input required type="date" value="{{ $task['renew_task_date'] ? date('Y-m-d', strtotime($task['renew_task_date'])) : '' }}" name="renewtask_date" class="form-control">
                                                                              </div>
                                                                              <div class="col-sm-12">
                                                                                 <h6><b>Technician</b>
                                                                                 </h6>
                                                                                 <?php $technicianname = Auth::user()->name ?>
                                                                                 <select name="technician" id="" disabled="disabled" class="aspNetDisabled form-control">
                                                                                    <option value="">Please select</option>
                                                                                    <option selected="selected" value="{{$technicianname}}">
                                                                                       {{$technicianname}}
                                                                                    </option>
                                                                                 </select>
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                                  <br>
                                                                  <div class="row">
                                                                     <div class="col-sm-12">
                                                                        <div class="accordion" id="accordionExample">
                                                                           <div class="accordion-item border-bottom border-top">
                                                                              <h2 class="accordion-header">
                                                                                 <button class="accordion-button bg-primary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                    Spares
                                                                                 </button>
                                                                              </h2>
                                                                              <div id="collapseOne" class="accordion-collapse collapse show" data-parent="#accordionExample">
                                                                                 <div class="accordion-body" style="overflow-y:scroll;">
                                                                                    <div class="container-fluid">
                                                                                       <div class="row">
                                                                                          <div class="col-md-12" style="padding-left: 3px; padding-right: 5px;">
                                                                                             <div class="border mb-2" style="height:250px;" tabindex="0">
                                                                                                <div class="rgHeaderWrapper">
                                                                                                   <div id="" class="rgHeaderDiv" style="overflow:hidden;">
                                                                                                      <div class="w-100 itembox row p-3 bg-secondary">
                                                                                                         <div class="text-end">
                                                                                                            <a class="btn btn-primary float-end mb-2 w-25 add_spare">Add Spare</a>
                                                                                                         </div>
                                                                                                         <div class="row sparebox">

                                                                                                            <table class="table table-bordered spare_table">
                                                                                                               <thead>
                                                                                                                  <tr>
                                                                                                                     <th class="rgHeader" style="cursor: move;">Part No.</th>
                                                                                                                     <th class="w-xs-0 rgHeader" style="cursor: move;">Description</th>
                                                                                                                     <th class="text-center rgHeader" style="cursor: move;">Supplier</th>
                                                                                                                     <th class="text-center rgHeader" style="cursor: move;">Supplier part No</th>
                                                                                                                     <th class="text-center rgHeader" style="cursor: move;">Quantity</th>
                                                                                                                     <th class="text-center rgHeader" style="cursor: move;">Critical Quantity</th>
                                                                                                                     <th></th>
                                                                                                                  </tr>
                                                                                                               </thead>
                                                                                                               <tbody>

                                                                                                               </tbody>
                                                                                                            </table>
                                                                                                         </div>
                                                                                                      </div>
                                                                                                      <table class="table table-bordered">
                                                                                                         <thead>
                                                                                                            <tr>
                                                                                                               <th class="rgHeader" >Part No.</th>
                                                                                                               <th class="w-xs-0 rgHeader" >Description</th>
                                                                                                               <th class="text-center rgHeader" >Supplier</th>
                                                                                                               <th class="text-center rgHeader" >Supplier part No</th>
                                                                                                               <th class="text-center rgHeader" >Quantity</th>
                                                                                                               <th class="text-center rgHeader" >Critical Quantity</th>
                                                                                                               <th>Action</th>
                                                                                                            </tr>
                                                                                                         </thead>
                                                                                                         <tbody>
                                                                                                            @forelse ($task['spares'] as $spare)
                                                                                                            <tr class="rgFilterRow" style="background-color:WhiteSmoke;">
                                                                                                               <td style="white-space:nowrap;display:none;">
                                                                                                                  <p> {{$spare->part_number}} </p>
                                                                                                               </td>
                                                                                                               <td style="white-space:nowrap;">
                                                                                                                  <p> {{$spare->part_number}} </p>
                                                                                                               </td>
                                                                                                               <td style="white-space:nowrap;">
                                                                                                                  <p> {{$spare->description}} </p>
                                                                                                               </td>
                                                                                                               <td style="white-space:nowrap;">
                                                                                                                  <p> {{$spare->supplier}} </p>
                                                                                                               </td>
                                                                                                               <td style="white-space:nowrap;">
                                                                                                                  <p> {{$spare->supplier_part_number}} </p>
                                                                                                               </td>
                                                                                                               <td style="white-space:nowrap;">
                                                                                                                  <p> {{$spare->quantity}} </p>
                                                                                                               </td>
                                                                                                               <td style="white-space:nowrap;">
                                                                                                                  <p> {{$spare->critical_quantity}} </p>
                                                                                                               </td>
                                                                                                               <td>
                                                                                                               <a href="{{ route('delete-spare', $spare->id) }}" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash text-danger"></i>
                                                                                                               </a>
                                                                                                               </td>
                                                                                                            </tr>
                                                                                                            @empty
                                                                                                            <tr class="rgFilterRow" style="background-color:WhiteSmoke;">
                                                                                                               <td colspan="6">
                                                                                                                  <p> No spares found </p>
                                                                                                               </td>
                                                                                                            </tr>
                                                                                                            @endforelse
                                                                                                         </tbody>
                                                                                                      </table>
                                                                                                   </div>
                                                                                                </div>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                           <div class="accordion-item border-bottom">
                                                                              <h2 class="accordion-header">
                                                                                 <button class="accordion-button bg-primary" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                                                    Add Attachment
                                                                                 </button>
                                                                              </h2>
                                                                              <div id="collapseTwo" class="accordion-collapse collapse now" data-parent="#accordionExample">
                                                                                 <div class="accordion-body">
                                                                                    <div class="w-100"> 
                                                                                    </div>
                                                                                    <div class="input-group mb-3 file">
                                                                                       <input type="file" multiple class="form-control fileinput" name="attach_file[]">
                                                                                       <div class="input-group-append">
                                                                                          <span class="btn btn-danger file_clear">Clear</span>
                                                                                       </div>
                                                                                    </div>

                                                                                    <table class="table my-2 table-bordered">
                                                                                       <thead class="bg-primary text-white">
                                                                                          <tr>
                                                                                             <th class="text-white">File Name</th>
                                                                                             <th class="text-white">Date Created</th>
                                                                                             <th class="text-white">Action</th>
                                                                                          </tr>
                                                                                       </thead>
                                                                                       <tbody>

                                                                                          @foreach ($task->asset_files as $assetfile)
                                                                                          <tr>
                                                                                             <td>{{$assetfile->file}}</td>
                                                                                             <td>{{date('d-m-Y', strtotime($assetfile->created_at))}}</td>
                                                                                             <td> <button class="btn btn-label-danger">
                                                                                                   <a href="{{ route('open-pdf', $assetfile->file) }}" target="_blank" data-toggle="tooltip" data-placement="top" data-title="Attach File"><i class="fa fa-download"></i>open
                                                                                                   </a>
                                                                                                </button>
                                                                                                <a href="{{ route('delete-pdf', $assetfile->id) }}" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash text-danger"></i>
                                                                                                </a>
                                                                                             </td>
                                                                                          </tr>
                                                                                          @endforeach
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                                  <br>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-primary">Save
                                                changes</button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              {{-- renew task end  --}}

                              {{-- Edit Task --}}
                              <div class="modal fade" id="edit_modal<?= $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel_2">
                                             Renew Task
                                          </h1>
                                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                          <div class="container">
                                             <form action="{{ route('update-asset-task', $task['id'])}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                   <div class="col-lg-6 col-sm-12 col-md-6">
                                                      <label for="">Sheet Number</label>
                                                      <p>{{$task['tasktype']['name']}}</p>
                                                   </div>
                                                   <div class="col-lg-6 col-sm-12 col-md-6">
                                                      <label for="">Task ID</label>
                                                      <p>{{$task['id']}}</p>
                                                      <input type="hidden" name="task_id" value="{{$task['id']}}" id="">
                                                      <input type="hidden" name="asset_id" value="{{$asset['id']}}" id="">
                                                   </div>
                                                   <!-- <div class="col-lg-6 col-sm-12 col-md-6">
                                                      <label for="">Sub Type</label>
                                                      <input type="text" value="{{ $task['sub_type'] }}" class="form-control" name="sub_type" id="">
                                                   </div> -->
                                                   <div class="row item">
                                                      <div class="col-lg-6 col-sm-12 col-md-6">
                                                         <label for="">Inspection Date</label>
                                                         <input value="{{ $task['start_date'] ? date('Y-m-d', strtotime($task['start_date'])) : '' }}" type="date" class="form-control startDate" name="start_date">
                                                         <input value="{{ $task['month_year'] }}" class="month_year" type="hidden" name="month_year">
                                                      </div>
                                                      <div class="col-lg-6 col-sm-12 col-md-6">
                                                         <label for="">Expire Date</label>
                                                         <input value="{{ $task['expire_date'] ? date('Y-m-d', strtotime($task['expire_date'])) : '' }}" type="date" class="form-control endDate" name="end_date" readonly>
                                                      </div>
                                                      <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                                         <label for="">Frequency</label>
                                                         <input value="{{ $task['frequency'] ? $task['frequency'] : '' }}" type="text" class="form-control frequency" name="frequency" disabled>
                                                         <div class="mt-2">
                                                            <input type="checkbox" class="override" name="override">
                                                            <label for="override">Frequency Override</label>
                                                         </div>
                                                      </div>
                                                   </div>


                                                   <!-- <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                                      <label for="">IMCA Reference</label>
                                                      <select name="imca_reference" class="form-select" id="">
                                                         <option value="">Choose imca</option>
                                                         @foreach ($imcas as $imca)
                                                         <option value="{{$imca->id}}" @if ($imca->id == $task['imca_reference'])
                                                            selected
                                                            @endif
                                                            >
                                                            {{$imca->name}}
                                                         </option>
                                                         @endforeach

                                                      </select>
                                                   </div> -->

                                                   <!-- <div class="col-12 mt-3">
                                                      <b>IMCA D018 Requirements:</b>
                                                      <input type="hidden" name="asset_description">
                                                      <p> {{$task['tasktype']['description']}} </p>
                                                   </div> -->
                                                   <div class="col-12 mt-3">
                                                      <b>Maintenance Routine Notes:</b>
                                                      <textarea class="form-control" name="notes" id="" cols="30" rows="3">{{$task['notes']}}</textarea>
                                                   </div>
                                                </div>

                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Save
                                             changes</button>
                                       </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        </div>
                     </div>
                  <?php endforeach; ?>
               </div>
            </div>
         </div>

      </div>
   </div>
   <!-- edit and renew task end -->

   <!-- added task  start-->
   <div class="row">
      <div class="col-12 mb-3">
         @can('create task')
         <a href="javascript:void(0)" class="btn btn-primary float-start " data-toggle="modal" data-target="#exampleModal_2">
            <i class="ti ti-plus me-1"></i>Add New Task
         </a>
         @endcan
      </div>

      <div class="row mb-3">
         <div class="col-12">
            <div class="card p-2">
               <div class="table-responsive text-nowrap" style="max-height: 500px; overflow-y:scroll;">
                  <h2 class="accordion-header p-2t">
                     Audit Log
                  </h2>
                  <table class="table" id="auditlog_table">
                     <thead>
                        <tr class="text-nowrap">
                           <th>Date </th>
                           <th>Task Id </th>
                           <th>Sheet Number</th>
                           <th>Task Title</th>
                           <th>New Notes</th>
                           <!-- <th>Running Hour</th> -->
                           <th>Log</th>
                           <th>Certificate</th>
                        </tr>
                     <tbody id="table-body">
                        @foreach ($auditLogs as $auditLog)
                        <tr>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif">{{ $auditLog->created_at ? date('Y-m-d', strtotime($auditLog->created_at)) : '' }}</td>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif">{{$auditLog->task_id}}</td>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif">{{ $auditLog->tasktype->name }}</td>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif">{{$auditLog->task->description}}</td>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif"> {{substr($auditLog->new_notes, 0, 50)}} </td>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif">
                              <a href="{{ route('audit-log', $auditLog->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                 <i class="fa fa-book"></i>View
                              </a>
                           </td>
                           <td style="@if($auditLog->active == 0) background-color:black; color:white; @endif">
                              <a href="{{ route('generate-pdf', $auditLog->id) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Open PDF in new tab">
                                 <i class="fa fa-download"></i> Open
                              </a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="exampleModal_2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel_2">Add New Task</h1>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="container">
                     <form action="{{ route('asset-store-task')}}" method="POST">
                        @csrf
                        <input type="hidden" name="system_id" value="{{$session->system_id}}">
                        <input type="hidden" name="asset_id" value="{{$asset['id']}}">

                        <div class="row">
                           <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                              <label for="">Sheet Number</label>
                              <select name="task_type" id="task_type_id" class="form-select" id="">
                                 <option value="">Select Sheet Number</option>
                                 @foreach ($tasktypes as $tasktype)
                                 <option value="{{$tasktype->id}}"> {{$tasktype->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <input type="hidden" value="{{$asset->sub_category_id}}" name="sub_category_id">
                           <input type="hidden" value="{{$asset->category_id}}" name="category_id">
                           <div class="cleafix"></div>
                           <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                              <div class="table-responsive">
                                 <table class="table" id="tasktable">
                                    <thead class="table-primary">
                                       <tr>
                                          <th>Description</th>
                                          <th>Frequency</th>
                                          <th>Maintenance Notes</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>

                              </div>
                           </div>
                        </div>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save changes</button>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- added task end -->
</div>
 

@push('scripts')
<script>
   $(document).ready(function() {

      $('#auditlog_table').DataTable({
         pageLength: 25
      });


      $('.override').change(function() {
         console.log("called");
         var $item = $(this).closest('.item');

         // Find the related input box within the same '.item'
         $item.find('.frequency').prop('disabled', !$(this).is(':checked'));
      });

      $(".file_clear").on('click', function(e) {
         e.preventDefault();

         var file = $(this).closest('.file')
         var fr = file.find('.fileinput')
         fr.val('')
      })


      $('.startDate').on('change', function() {
         var startDate = $(this).val();
         var item = $(this).closest('.item')
         var ed = item.find('.endDate')
         var fr = item.find('.frequency')
         var my = item.find('.month_year')
         var frequency = parseInt(fr.val(), 10);
         if (startDate && !isNaN(frequency)) {
            // var endDate = moment(startDate).add(frequency * 30, 'days').format('YYYY-MM-DD');
            // ed.val(endDate);
            var monthsToAdd = 0;
            if (my.val() == 'month') {
               var monthsToAdd = parseInt(fr.val(), 10);
            } else {
               var monthsToAdd = parseInt(fr.val(), 10) * 12;
            }

            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + monthsToAdd);

            // Format the end date as YYYY-MM-DD
            const formattedEndDate = endDate.toISOString().split('T')[0];
            ed.val(formattedEndDate);


         } else {
            ed.val('');
         }
      });
      $('.frequency').on('change', function() {
         var fr = $(this).val();
         var item = $(this).closest('.item')
         var ed = item.find('.endDate')
         var my = item.find('.month_year')
         var startDate = item.find('.startDate').val()
         var frequency = parseInt(fr, 10);
         if (startDate && !isNaN(frequency)) {
            // var endDate = moment(startDate).add(frequency * 30, 'days').format('YYYY-MM-DD');
            // ed.val(endDate);

            var monthsToAdd = 0;
            if (my.val() == 'month') {
               var monthsToAdd = parseInt(fr, 10);
            } else {
               var monthsToAdd = parseInt(fr, 10) * 12;
            }

            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + monthsToAdd);

            // Format the end date as YYYY-MM-DD
            const formattedEndDate = endDate.toISOString().split('T')[0];
            ed.val(formattedEndDate);


         } else {
            ed.val('');
         }
      });
   });


   $('#task_type_id').on('change', function() {

      var tasktype_id = $(this).val();
      var index = 0;


      $("#tasktable").html("");


      $.ajax({
         url: '/asset-tasktype/' + tasktype_id,
         type: "get",
         success: function(data) {

            data.forEach(ele => {
               index++;
               var row = `<tr>
                  <td>
                   <input value="` + ele.id + `" type="hidden" class="form-control" name="pretask[${index}][id]">
                     <input value="` + ele.description + `" type="text" class="form-control" name="pretask[${index}][description]" placeholder="Description">
                  </td>
                  <td>
                     <input value="` + ele.frequency + `" type="text" class="form-control" name="pretask[${index}][frequency]" placeholder="Frequency">
                  </td>
                  <td>
                     <input value="" type="text" class="form-control" name="pretask[${index}][maintenance_notes]" placeholder="Maintenance Notes">
                  </td>
               </tr>`;

               $("#tasktable").append(row);
            });

         }
      });

   });


   $(document).on('click', '.dltspare', function() {
      console.log("dlted");

      let id = $(this).data('id');
      console.log(id);

      $(`#sparerow-${id}`).remove();
   });


   var sparerows = 0;

   $('.add_spare').click(function() {

      var item = $(this).closest('.itembox')

      var newRow = `
      <tr class="rgFilterRow" style="background-color:WhiteSmoke;" id="sparerow-` + sparerows + `">
      <td>
         <input type="text" class="form-control" name="parts[` + sparerows + `][part_number]" required>
      </td>
      <td>
         <input type="text" class="form-control" name="parts[` + sparerows + `][description]">
      </td>
      <td>
         <input type="text" class="form-control" name="parts[` + sparerows + `][supplier]">
      </td>
      <td>
         <input type="text" class="form-control" name="parts[` + sparerows + `][supplier_part_number]">
      </td>
      <td>
         <input type="text" class="form-control" name="parts[` + sparerows + `][quantity]">
      </td>
      <td>
         <input type="text" class="form-control" name="parts[` + sparerows + `][critical_quantity]">
      </td>
      <td> 
         <span class="btn btn-sm btn-danger mx-1 dltspare" data-id="${sparerows}"><i class="fa fa-times"></i></span>
      </td>
   </tr> `;
      $('.spare_table tbody').append(newRow);
      sparerows++;
   });
</script>
@endpush

@endsection