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
        <h1 class="m-0">Add System</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Systems</a></li>
          <li class="breadcrumb-item active">Add new</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="card">
    <div class="card-datatable table-responsive p-4">

      @if($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
      </div>
      @endif


      <form action="{{ route('store.Spread')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12  mt-3">
            <label for="">System Description</label>
            <input value="{{ old('system_description') }}" type="text" class="form-control" name="system_description" placeholder="System Description" id="" required>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="">Manufraturer</label>
            <input value="{{ old('manufraturer') }}" type="text" placeholder="Manufraturer" class="form-control" name="manufraturer" id="">
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="">Model Number</label>
            <input value="{{ old('model_number') }}" type="text" placeholder="Model Number" class="form-control" name="model_number" id="">
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <div class="d-flex flex-row gap-3 mt-4">
              <div class="w-50">
                <label for="">Class System</label>
              </div>
              <div>
                <div class="d-flex flex-row gap-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="class_system" value="yes" id="flexRadioDefault3">
                    <label class="form-check-label" for="flexRadioDefault3">
                      Yes
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="class_system" value="no" id="flexRadioDefault4" checked>
                    <label class="form-check-label" for="flexRadioDefault4">
                      No
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="">Class Name</label>
            <input value="{{ old('class_name') }}" type="text" placeholder="Class Name" class="form-control" name="class_name" id="class-name">
          </div>



          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <div class="d-flex flex-row gap-3 mt-4">
              <div class="w-50">
                <label for="">Containerized System</label>
              </div>
              <div>
                <div class="d-flex flex-row gap-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="containerized_system" value="yes" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                      Yes
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="containerized_system" value="no" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                      No
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-6 col-sm-6 col-md-6 mt-3" id="containernobox">
            <label for="">Container Number</label>
            <input value="{{ old('container_number') }}" type="text" placeholder="Container Number" class="form-control" name="container_number" id="container-no">
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3" id="serialnobox">
            <label for="">Serial Number</label>
            <input value="{{ old('serial_number') }}" type="text" placeholder="Serial Number" class="form-control" name="serial_number" id="serial-no">
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3 mt-3">
            <label for="">Manufacture Date</label>
            <input value="{{ old('manufacture_date') }}" type="date" placeholder="Manufacture Date" class="form-control" name="manufacture_date" id="">
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3 mt-3">
            <label for="">Purchased Date</label>
            <input value="{{ old('purchased_date') }}" type="date" placeholder="Purchased Date" class="form-control" name="purchased_date" id="">
          </div>

          <div class="col-lg-6 col-sm-6 col-md-6 mt-3" id="allsizebox">
            <label for="">Size/Dimension</label>
            <div class="d-flex flex-row gap-3">
              <input value="{{ old('size') }}" type="text" placeholder="Width" class="form-control" name="size" id="size">
              <input value="{{ old('dimension') }}" type="text" placeholder="Length" class="form-control" name="dimension" id="dimension">
              <input value="{{ old('height') }}" type="text" placeholder="Height" class="form-control" name="height" id="height">
            </div>

          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3" id="onesizebox">
            <label for="">Size/Dimension</label> 
              <input value="{{ old('onesize') }}" type="text" placeholder="Size" class="form-control" name="onesize" id="onesize">   
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="">Weight</label>
            <input id="weight" value="{{ old('weight') }}" type="text" placeholder="Enter Weight" class="form-control" name="weight" id="">
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="">Select IMCA Audit Type</label>
            <select id="systems" name="system_id" class="form-select">
              <option value="">Choose...</option>
              @foreach ($systemtypes as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-3 table-bordered">
                <thead class="table-primary">
                  <tr>
                    <th>Date Sheet</th>
                    <th>Certificates</th>
                    <th>Manuel</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="file" multiple style="width: 100%;" class="form-control" name="date_sheet_files[]"></td>
                    <td><input type="file" multiple style="width: 100%;" class="form-control" name="certificate_files[]"></td>
                    <td><input type="file" multiple style="width: 100%;" class="form-control" name="manual_files[]"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-6 offset-3 p-1">
            <table class="table mt-3 table-striped">
              <thead id="table-head" class="table-primary">
                <tr>
                  <td>IMCA Code</td>
                  <td>Required</td>
                </tr>
              </thead>
              <tbody id="table-body"></tbody>
            </table>
          </div>

        </div>
        <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>
      </form>
    </div>

  </div>
</div>

@push('scripts')

<script>
  // Function to check the selected radio button and enable/disable the container-no input
  function checkContainerized() {
    let val = $("input[name='containerized_system']:checked").val();
    if (val === 'no') {
      $("#dimension, #size, #weight, #height").attr('disabled', true);
      $("#serialnobox").show();
      $("#containernobox").hide();
      $("#onesizebox").show();
      $("#allsizebox").hide();
    } else {
      $("#dimension, #size, #weight, #height").attr('disabled', false);
      $("#serialnobox").hide();
      $("#containernobox").show();
      $("#onesizebox").hide();
      $("#allsizebox").show();
    }
  }
  $("input[name='containerized_system']").change(checkContainerized);
  checkContainerized();

  function checkclasssystem() {
    let val = $("input[name='class_system']:checked").val();
    if (val === 'no') {
      $("#class-name").attr('disabled', true);
    } else {
      $("#class-name").attr('disabled', false);
    }
  }
  $("input[name='class_system']").change(checkclasssystem);
  checkclasssystem();

  $('#systems').change(function() {
    var val = $(this).val();
    var option_text = $("#systems option:selected").text();

    var serviceBody = $('#table-body');
    // var componentBody = $('#sub-component-body');
    // var assetBody = $('#assets-body');
    // var tasksBody = $('#tasks-body');

    serviceBody.empty();
    // componentBody.empty();
    // assetBody.empty();
    // tasksBody.empty();


    $.ajax({
      url: '/spreadcategory/search-systems/' + val,
      method: 'GET',
      success: function(response) {
        // Update the table head
        var servicesSelect = $('#table-head');
        servicesSelect.empty();
        servicesSelect.append(`<tr><td>${response.system}</td><td>Required</td></tr>`);
 
        serviceBody.empty(); // Clear existing rows

        $.each(response.data, function(index, service) {
          $rw = ``;
          // if (service.checked == 1) {
          //   $rw = `<tr><td>${service.name}</td><td><input type="checkbox" class="components_checkboxes" checked value="${service.id}" name="values[]"/></td></tr>`;
          // } else {
            $rw = `<tr><td>${service.name}</td><td><input type="checkbox" class="components_checkboxes" value="${service.id}" name="values[]"/></td></tr>`;
          // }
          serviceBody.append($rw);
        });

        // var componentBody = $('#sub-component-body');
        // componentBody.empty();
        // $.each(response.included_data, function(index, item) {
        //   var rowHtml = `<tr><td>${item.name} </td><td>${item.status}</td><td><input type="checkbox" class="sub_components_checkboxes" value="${item.id}" name="subcomponents[]"/></td></tr>`;
        //   componentBody.append(rowHtml);
        // });



        // Re-bind checkbox change event
        // $('input[type="checkbox"][name="values[]"]').change(function() {
        //   var isChecked = $(this).is(':checked');
        //   var taskid = $(this).val();

        //   var searchIDs = $("#table-body input.components_checkboxes:checked").map(function() {
        //     return $(this).val();
        //   }).toArray();

        //   // var componentBody = $('#sub-component-body');
        //   componentBody.empty();
        //   // var assetBody = $('#assets-body');
        //   assetBody.empty();
        //   // var tasksBody = $('#tasks-body');
        //   tasksBody.empty();

        //   if (searchIDs && searchIDs.length > 0) {
        //     $.ajax({
        //       url: "/shift-component",
        //       method: 'GET',
        //       data: {
        //         "data": searchIDs
        //       },
        //       success: function(response) {

        //         // var componentBody = $('#sub-component-body');
        //         // componentBody.empty();
        //         $.each(response, function(index, item) {
        //           var rowHtml = `<tr><td>${item.name}<span class="float-end">(${item.asset_count})</span></td><td>${item.status}</td><td><input type="checkbox" class="sub_components_checkboxes" value="${item.id}" name="subcomponents[]"/></td></tr>`;
        //           componentBody.append(rowHtml);
        //         });


        //         $('input[type="checkbox"][name="subcomponents[]"]').change(function() {
        //           var sub_comp_ids = $("#sub-component-body input.sub_components_checkboxes:checked").map(function() {
        //             return $(this).val();
        //           }).toArray();

        //           // var assetBody = $('#assets-body');
        //           assetBody.empty();
        //           // var tasksBody = $('#tasks-body');
        //           tasksBody.empty();

        //           if (sub_comp_ids && sub_comp_ids.length > 0) {
        //             $.ajax({
        //               url: "/shift-sub-component",
        //               method: 'GET',
        //               data: {
        //                 "sub_components_ids": sub_comp_ids
        //               },
        //               success: function(response) {
        //                 console.log(response);
        //                 // var assetBody = $('#assets-body');
        //                 // assetBody.empty();
        //                 $.each(response, function(index, item) {
        //                   var rowHtml = `<tr><td>${item.description}<span class="float-end">(${item.task_count})</span></td><td>${item.status}</td><td><input type="checkbox" class="assets_checkboxes" value="${item.id}" name="assets[]" ${(item.spread_category_id) ? 'disabled' : '' }/></td></tr>`;
        //                   assetBody.append(rowHtml);
        //                 });

        //                 $('input[type="checkbox"][name="assets[]"]').change(function() {
        //                   var isChecked = $(this).is(':checked');
        //                   var taskid = $(this).val();
        //                   var assets_ids = $("#assets-body input.assets_checkboxes:checked").map(function() {
        //                     return $(this).val();
        //                   }).toArray();

        //                   // var tasksBody = $('#tasks-body');
        //                   tasksBody.empty();

        //                   if (assets_ids && assets_ids.length > 0) {
        //                     $.ajax({
        //                       url: "/shift-assets",
        //                       method: 'GET',
        //                       data: {
        //                         "assets_ids": assets_ids
        //                       },
        //                       success: function(response) {
        //                         // var tasksBody = $('#tasks-body');
        //                         // tasksBody.empty();
        //                         $.each(response, function(index, item) {
        //                           var rowHtml = `<tr class="${(item.spread_category_id) ? 'bg-secondary text-white' : '' }" ><td>${item.description}</td><td>${item.status}</td></tr>`;
        //                           tasksBody.append(rowHtml);
        //                         });
        //                       },
        //                       error: function(xhr, status, error) {
        //                         console.error(error);
        //                       }
        //                     });
        //                   }

        //                 });


        //               },
        //               error: function(xhr, status, error) {
        //                 console.error(error);
        //               }
        //             });
        //           }
        //         });


        //       },
        //       error: function(xhr, status, error) {
        //         console.error(error);
        //       }
        //     });
        //   }
        // });
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
</script>
@endpush
@endsection