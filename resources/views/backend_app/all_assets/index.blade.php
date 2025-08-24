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
                        <th class="text-left">System</th>
                        <th class="text-left">Manufacturer</th>
                        <th class="text-left">Model</th>
                        <th class="text-left">Serial Number</th> 
                        <th class="text-left">Safety Crtical</th>  
                        <th class="text-left"> Nde Own or Not</th>
                        <th class="text-left">Class</th> 
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <tr>
                        <td class="text-left">
                            <input type="text" name="description" class="form-control" id="asset_description">
                            <input type="hidden" value="{{$cat_id}}" id="asset_category_id"> 
                        <input type="hidden" value="{{$subcat_id}}" id="asset_subcategory_id">
                        <input type="hidden" value="{{$sysid->id}}" id="asset_spread_id"> 
                        </td>
                        <td class="text-left"><select name="system_id" id="asset_system_id" class="form-control">
                                <option value="-">Choose a system</option>
                                @foreach($spreadcategories as $system)
                                <option value="{{$system->system_id}}">{{$system->system_name}}</option>
                                @endforeach
                            </select></td>
                        <td class="text-left"><input type="text" name="manufacturer" class="form-control" id="asset_manufacturer"></td>
                        <td class="text-left"><input type="text" name="model" class="form-control" id="asset_modal"></td>
                        <td class="text-left"><input type="text" name="serial_number" class="form-control" id="asset_serial_number"></td>
                         
                        <td class="text-left"><select name="Level" class="form-select" id="asset_safety_critical">
                                <option value="Level 1">Yes</option>
                                <option value="Level 2">No</option>
                            
                            </select></td>
                            <td class="text-left"><select name="own" class ="form-control" id ="asset_own"></td>
                            <option value="NDE own">Nde own</option>
                            <option value="Not"> Not </option> 
                            </select>
                            </td>
                            
                        <!-- <td class="text-left"><select name="system_project" class="form-select" id="asset_system_project">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select></td> -->
                        <!-- <td class="text-left">
                        <input type="text" name="system_class" class="form-control" id="asset_system_class"> 
                        </td> -->
                        <td class="text-left"><select name="location" class="form-select" id="asset_location">
                                <option value="">Select Location</option>
                                @foreach ($locations as $loc)
                                <option value="{{$loc->id}}">{{$loc->name}}</option>
                                @endforeach
                            </select></td>
                        <!-- <td class="text-left"><select name="class_code" class="form-select" id="asset_class_code">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select></td> -->
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
            <form id="bulk_assign_form" action="{{route('assign-bulk-project-form')}}" method="POST">
                @csrf
                <table class="table" id="assets_table">
                    <thead class="table-primary">
                        <tr class="text-nowrap">
                            <th class="text-left">Asset ID</th>
                            <th class="text-left">Description</th>
                            <th class="text-left">System</th>
                            <th class="text-left">Manufacturer</th>
                            <th class="text-left">Model</th>
                            <th class="text-left">Serial Number</th> 
                            <th class="text-left">Safety Critical</th> 
                            <th class="text-left">Nde own or Not</th>
                            <th class="text-left">Location</th> 
                        </tr>
                    </thead>
                    <tbody id="table-body">

                        @foreach ($all_assets as $all_asset)
                        <tr>
                            <td class="text-left"><a href="{{ route('asset-category-edit', $all_asset->id) }}">{{$all_asset->id}}</a></td>
                            <td class="text-left">{{substr($all_asset->description, 0, 20)}}</td>
                            <td class="text-left">{{$all_asset->spreadcategory->system_description}}</td>
                            <td class="text-left">{{$all_asset->manufacturer}}</td>
                            <td class="text-left">{{$all_asset->system_modal}}</td>
                            <td class="text-left">{{$all_asset->serial_no}}</td> 
                            <td class="text-left">{{$all_asset->sefety_critical}}</td> 
                            <td class="text-left">{{$all_asset->owm}}</td>
                            <td class="text-left">{{ $all_asset->assetlocation ? $all_asset->assetlocation->name : '' }}</td> 
                            <!-- <td>
                            <!--    @can('edit asset')-->
                            <!--    @if ($all_asset->system_status == 1)-->
                            <!--    <a href="{{ route('asset-active', ['id' => $all_asset->id, 'status' => 0]) }}" class="btn btn-sm btn-danger">Deactivate</a>-->
                            <!--    @else-->
                            <!--    <a href="{{ route('asset-active', ['id' => $all_asset->id, 'status' => 1]) }}" class="btn btn-sm btn-success">Activate</a>-->
                            <!--    @endif-->
                            <!--    @endcan-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    @can('edit asset')-->
                            <!--    <a href="{{ route('assign-asset', $all_asset->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">-->
                            <!--        Assign project-->
                            <!--    </a>-->
                            <!--    @endcan-->
                            <!--</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- <br>
                    <button type="submit" class="btn btn-primary" title="Assign Project">Assign Bulk Project</button> -->

            </form>
        </div>
    </div>
    @endcan

</div>
<!-- / Content -->



@push('scripts')
<script>
    $('#assets_table').DataTable({
        pageLength: 10
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
        var asset_location = $("#asset_location").val();
        var asset_safety_critical = $("#asset_safety_critical").val();
        var asset_own = $("#asset_own").val();
        //var asset_system_project = $("#asset_system_project").val();
        // var asset_system_class = $("#asset_system_class").val();
        //var asset_class_code = $("#asset_class_code").val();
        var asset_system_id = $("#asset_system_id").val();

        var asset_category_id = $("#asset_category_id").val();
        var asset_subcategory_id = $("#asset_subcategory_id").val();
        var asset_spread_id = $("#asset_spread_id").val();


        if (!asset_description || !asset_manufacturer || !asset_model || !asset_category_id || !asset_subcategory_id) {
            alert("fields are required");
        } else {


            var data = {
                "description" : asset_description,
                "manufacturer" : asset_manufacturer,
                "system_modal" : asset_model,
                "serial_no" : asset_serial_number,
                "location" : asset_location,
                "sefety_critical" : asset_safety_critical,
                "own" : asset_own,
                //"system_project" : asset_system_project,
                // "system_class" : asset_system_class,
                //"class_code" : asset_class_code,
                "system_id" : asset_system_id, 
                "category_id" : asset_category_id,
                "sub_category_id" : asset_subcategory_id,
                "spread_id" : asset_spread_id,
            };

            $.ajax({
                url: '/assets/ajax_add/',
                type: "get", 
                data: data,
                success: function(data) {  
                    
                    location.reload();
                }
            });
        }


        


    })
</script>
@endpush

@endsection