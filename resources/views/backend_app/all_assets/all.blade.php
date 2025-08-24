@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">
    include('backend_app.layouts.nav') 
    <div class="content-wrapper">  -->

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">All Assets</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Assets</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">

    @can('create asset')
    <div class="row">
        <div class="col-12">
            <span class="btn btn-primary w-auto float-start mb-2 mx-6" id="add_asset">Add <i class="fa fa-plus"></i></span>
        </div>
    </div>
    @endcan

    @can('create asset')
    <div class="card" id="add_asset_box" style="display: none;">
        <div class="table-responsive text-nowrap p-1">
            <table class="table">
                <thead class="table-primary">
                    <tr class="text-nowrap">
                        <th class="text-left">Description</th>
                        <!-- <th class="text-left">Component</th>
                        <th class="text-left">Sub Component</th>
                        <th class="text-left">System</th> -->
                        <th class="text-left">Manufacturer</th>
                        <th class="text-left">Model</th>
                        <th class="text-left">Serial Number</th>
                        <th class="text-left">Safety Crtical</th>
                        <th class="text-left">Nde own or Not</th>
                        <th class="text-left">Location</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <tr>
                        <td class="text-left">
                            <input type="text" name="description" class="form-control" id="asset_description">
                            <input type="hidden" value="{{$current_sys->id}}" id="asset_spread_id">
                            <input type="hidden" value="{{$current_sys->system_type_id}}" id="asset_spread_type_id">
                        </td>
                        <!-- <td class="text-left">
                            <select name="category_id" id="asset_category_id" class="form-control">
                                <option value="-">Choose a Component</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-left">
                            <select name="subcategory_id" id="asset_subcategory_id" class="form-control">
                                <option value="-">Choose a Sub Component</option>
                            </select>
                        </td>
                        <td class="text-left">
                            <select name="system_id" id="asset_system_id" class="form-control">
                                <option value="-">Choose a system</option>
                            </select>
                        </td> -->
                        <td class="text-left"><input type="text" name="manufacturer" class="form-control" id="asset_manufacturer"></td>
                        <td class="text-left"><input type="text" name="model" class="form-control" id="asset_modal"></td>
                        <td class="text-left"><input type="text" name="serial_number" class="form-control" id="asset_serial_number"></td>
                        <td class="text-left"><select name="Level" class="form-select" id="asset_safety_critical">
                                <option value="Level 1">Yes</option>
                                <option value="Level 2">No</option>
                                
                             
                                </select>
                                </td>
                                
                                <td class="text-left"><select name="own" class="form-select" id="asset_own">
                                    <option value="Nde own">Nde Own</option>
                                    <option value="other party">Other party</option>
</select>
</td>
                            
                        <td class="text-left">
                            <!-- <input type="text" name="system_class" class="form-control" id="asset_system_class"> -->
                            <select name="location" class="form-select" id="asset_location">
                                <option value="">Select Location</option>
                                @foreach ($locations as $loc)
                                <option value="{{$loc->id}}">{{$loc->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-right"><span class="btn btn-sm btn-success mx-1" id="submit_add_asset"><i class="fa fa-check"></i></span>
                            <span class="btn btn-sm btn-danger mx-1" id="close_add_asset"><i class="fa fa-times"></i></span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    @endcan

    @can('all asset')
    <div class="card">
        <div class="table-responsive text-nowrap p-1">
            <table class="table" id="assets_table">
                <thead class="table-primary">
                    <tr class="text-nowrap">
                        <th class="text-left">Asset ID</th>
                        <th class="text-left">Description</th>
                        <th class="text-left">Component</th>
                        <th class="text-left">Sub Component</th>
                        <th class="text-left">System</th>
                        <th class="text-left">Manufacturer</th>
                        <th class="text-left">Model</th>
                        <th class="text-left">Serial Number</th>
                        <th class="text-left">Safety Critical</th>
                        <th class="text-left">Nde own or Not</th>
                        <th class="text-left">Location</th>
                        <th class="text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_assets as $key => $asset)
                    <tr>
                        <td class="text-left">@if($asset->spread_id && $asset->spread_category_id)<a href="{{ route('asset-category-edit', $asset->id) }}">{{$asset->id}}</a> @else {{$asset->id}} @endif</td>
                        <td class="text-left">{{substr($asset->description, 0, 20)}}</td>
                        <td class="text-left">{{$asset->category ? $asset->category->name : ""}}</td>
                        <td class="text-left">{{$asset->subcategory ? $asset->subcategory->name : ""}}</td>
                        <td>
                            @can('assign asset')
                            @if ($asset->spread_category_id)
                            {{$asset->spreadcategory->system_description}}
                            @else
                            <a href="#" class="btn btn-sm btn-warning assign_btn" data-asset_id="{{$asset->id}}">Un Assigned</a>
                            @endif
                            @endcan
                        </td>
                        <td class="text-left">{{$asset->manufacturer}}</td>
                        <td class="text-left">{{$asset->system_modal}}</td>
                        <td class="text-left">{{$asset->serial_no}}</td>
                        <td class="text-left">{{$asset->sefety_critical}}</td>
                        <td class="text-left">{{$asset->own}}</td>
                        <td class="text-left">{{ $asset->assetlocation ? $asset->assetlocation->name : '' }}</td>
                        <td class="text-left">
                            <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Rental Order</a>
                            <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Certifacation</a>
                            <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Manuel</a>
                            <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Drawing</a>
                            <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Photo</a>
                            <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Inspection Report</a>
                             <a class="btn btn-sm btn-outline-success " data-toggle="modal" data-target="#file_modal<?= $key ?>">Other</a>
       
                            @can('edit asset')
                            <a href="{{ route('edit-asset', $asset->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Asset">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @if ($asset->spread_category_id)
                            @can('unassign asset')
                            <a href="{{route('unassign-asset',$asset->id)}}" class="btn btn-sm btn-outline-primary" title="Unassign assets">
                                <i class="fa fa-undo"></i>
                            </a>
                            @endcan
                            @endif
                            @can('delete asset')
                            <a href="{{ route('delete-asset', $asset->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            @endcan


                            <div class="modal fade" id="file_modal<?= $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="min-width: 90%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel_2">Uplaod File
                                    </h1>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('alluploadfile-asset', $asset['id'])}}" method="POST" enctype="multipart/form-data">
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
                                                                                            Add File
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseTwo" class="accordion-collapse collapse show" data-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <div class="w-100"> 

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

                                                                                                    @foreach ($asset->allfiles as $file)
                                                                                                    <tr>
                                                                                                        <td>{{$file->file}}</td>
                                                                                                        <td>{{date('d-m-Y', strtotime($file->created_at))}}</td>
                                                                                                        <td> <button class="btn btn-label-danger">
                                                                                                                <a href="{{ route('open-allasset', $file->file) }}" target="_blank">open</a>
                                                                                                            </button>
                                                                                                            <a href="{{ route('delete-allfile', $file->id) }}" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash text-danger"></i>
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


                        </td>
                    </tr>

                    

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcan
    
       
    

    <div class="modal fade" id="asset_system_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Assign System</h1>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('asset-assign-system')}}" method="POST">
                    @csrf
                    <input type="hidden" id="selected_asset" value="" name="selected_asset">
                    <div class="modal-body">
                        <div class="container">

                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-6 mt-3">
                                    <label for="">Component</label>
                                    <select name="category_id" id="asset_category_id" class="form-control" required>
                                        <option value="-">Choose a Component</option>
                                        @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-6 mt-3">
                                    <label for="">Sub Component</label>
                                    <select name="sub_category_id" id="asset_subcategory_id" class="form-control" required>
                                        <option value="-">Choose Sub Component</option>

                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-6 mt-3">
                                    <label for="">System</label>
                                    <select name="system_id" class="form-select" id="asset_system_id" required>
                                        <option value="">Select System</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- / Content -->



@push('scripts')
<script>

$(".file_clear").on('click', function(e) {
         e.preventDefault();

         var file = $(this).closest('.file')
         var fr = file.find('.fileinput')
         fr.val('')
      })


    $('#assets_table').DataTable({
        pageLength: 100
    });

    $("#add_asset").on('click', function() {
        $("#add_asset_box").show();
    })
    $("#close_add_asset").on('click', function() {
        $("#add_asset_box").hide();
    })

    $("#submit_add_asset").on('click', function() {

        var asset_description = $("#asset_description").val();
        var asset_manufacturer = $("#asset_manufacturer").val();
        var asset_model = $("#asset_modal").val();
        var asset_serial_number = $("#asset_serial_number").val();
        var asset_safety_critical = $("#asset_safety_critical").val();
        var asset_own = $("#asset_own").val();
        // var asset_system_class = $("#asset_system_class").val();
        var asset_system_id = $("#asset_system_id").val();
        var asset_location = $("#asset_location").val();
        // var asset_category_id = $("#asset_category_id").val();
        // var asset_subcategory_id = $("#asset_subcategory_id").val();
        var asset_spread_id = $("#asset_spread_id").val();
        var asset_spread_type_id = $("#asset_spread_type_id").val();


        if (!asset_description || !asset_manufacturer || !asset_model) {
            alert("fields are required");
        } else {


            var data = {
                "description": asset_description,
                "manufacturer": asset_manufacturer,
                "system_modal": asset_model,
                "serial_no": asset_serial_number,
                "sefety_critical": asset_safety_critical,
                "own": asset_own,
                // "system_class": asset_system_class,
                "system_id": asset_system_id,
                // "category_id": 1,
                // "sub_category_id": 1,
                "spread_id": asset_spread_id,
                "spread_type_id": asset_spread_type_id,
                "location": asset_location
            };



            $.ajax({
                url: '/assets/ajax_add/withoutsystem/',
                type: "get",
                data: data,
                success: function(data) {

                    console.log(data);

                    // location.reload();
                }
            });
        }
    });

    $('#asset_category_id').change(function() {
        var category_id = $(this).val();
        console.log(category_id);

        if (category_id) {
            $('#asset_subcategory_id').empty();
            $.ajax({
                url: '/get-subcategories/' + category_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#asset_subcategory_id').append('<option value="">Select Sub Component</option>');
                    $.each(data, function(key, value) {
                        $('#asset_subcategory_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#asset_subcategory_id').empty();
            $('#asset_subcategory_id').append('<option value="">Select Sub Component</option>');
        }
    });

    $('#asset_subcategory_id').change(function() {
        var category_id = $('#asset_category_id').val();

        if (category_id) {
            $('#asset_system_id').empty();
            $.ajax({
                url: '/get-systems/' + category_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#asset_system_id').append('<option value="">Select System</option>');
                    data.forEach(e => {
                        console.log(e);
                        $('#asset_system_id').append('<option value="' + e.system_id + '">' + e.system_name + '</option>');
                    });
                }
            });
        } else {
            $('#asset_system_id').empty();
            $('#asset_system_id').append('<option value="">Select System</option>');
        }
    });


    $("#assets_table").on("click", ".assign_btn", function(e) {
        e.preventDefault();
        var asset_id = $(this).data('asset_id');
        $('#selected_asset').val(asset_id);
        $("#asset_system_modal").modal('show');
    });

    // $('.assign_btn').click(function(e) {
    //     e.preventDefault();
    //     var asset_id = $(this).data('asset_id');
    //     console.log(asset_id);

    //     $('#selected_asset').val(asset_id);

    //     $("#asset_system_modal").modal('show');
    //     // $.ajax({
    //     //     url: '/get-system-modal/' + asset_id,
    //     //     type: "GET",
    //     //     success: function(data) {
    //     //         $('#asset_system_modal').html(data).modal('show');
    //     //     }
    //     // });
    // });
</script>
@endpush


@endsection