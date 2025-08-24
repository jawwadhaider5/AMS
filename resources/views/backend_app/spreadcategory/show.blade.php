@extends('backend_app.layouts.template')
@section('content')


<!-- <div class="layout-page"> 
  @include('backend_app.layouts.nav')
  <div class="content-wrapper">  -->

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ $spreadcategory->system_description ?? 'Please Select A System' }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">System</a></li>
          <li class="breadcrumb-item active">Show</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection


<div class="container-xxl flex-grow-1 container-p-y">

  <div class="card">
    <div class="card-datatable table-responsive">

      <div class="row">
        <div class="col-md-6">
          <table class="table mt-3 table-bordered">
            <thead class="table-primary">
              <tr>
                <td colspan="2" class="text-center">System Information</td>
              </tr>
            </thead>
            <tbody id="table-body">

              <tr>
                <td>System Description</td>
                <td>{{ $spreadcategory->system_description }}</td>
              </tr>
              <tr>
                <td>Manufacturer</td>
                <td>{{ $spreadcategory->manufraturer }}</td>
              </tr>
              <tr>
                <td>Modal Number</td>
                <td>{{ $spreadcategory->model_number }}</td>
              </tr>
              <tr>
                <td>Class System</td>
                <td>{{ $spreadcategory->class_system }}</td>
              </tr>
              <tr>
                <td>Class Name</td>
                <td>{{ $spreadcategory->class_name }}</td>
              </tr>
              <tr>
                <td>Containerized System</td>
                <td>{{ $spreadcategory->containerized_system }}</td>
              </tr>
              <tr>
                <td>@if($spreadcategory->containerized_system == 'yes') Container @else Serial @endif Number</td>
                <td>{{ $spreadcategory->container_number }}</td>
              </tr>
              <tr>
                <td>Manufacture Date</td>
                <td>{{ $spreadcategory->manufacture_date }}</td>
              </tr>
              <tr>
                <td>Purchase Date</td>
                <td>{{ $spreadcategory->purchased_date }}</td>
              </tr>
              <tr>
                <td>Size/dimension</td>
                <td>@if($spreadcategory->containerized_system == 'yes') W = {{$spreadcategory->size }} m, L = {{$spreadcategory->dimension}} m, H = {{$spreadcategory->height}} m @else D = {{$spreadcategory->size }} m @endif</td>
              </tr>
              <tr>
                <td>Weight</td>
                <td>{{ $spreadcategory->weight }}</td>
              </tr>
              <tr>
                <td>Spread</td>
                <td>@if ($spreadcategory->system) {{ $spreadcategory->system->system_name ?? '' }} @else <span class="btn btn-sm btn-warning">Not Assigned</span> @endif</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6 ">
          <div style="overflow-x:auto;">
            <table class="table mt-3 table-bordered">
              <thead class="table-primary">
                <tr>
                  <th>Date Sheet Files</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    @if(count($spreadcategory->data_sheets)>0)
                    @foreach($spreadcategory->data_sheets as $sps)
                    <a target="_blank" href="/pdf/{{$sps}}"><i class="fa-solid fa-file-pdf text-danger p-2" style="font-size: 30px; "></i>{{$sps}}</a><br>
                    @endforeach
                    @else
                    <p class="text-secondary">No Data Sheets found</p>
                    @endif
                </tr>
              </tbody>
            </table>
            <table class="table mt-3 table-bordered">
              <thead class="table-primary">
                <tr>
                  <th>Certificates Files</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    @if(count($spreadcategory->certificates)>0)
                    @foreach($spreadcategory->certificates as $cert)
                    <a target="_blank" href="/pdf/{{$cert}}"><i class="fa-solid fa-file-pdf text-danger p-2" style="font-size: 30px; "></i>{{$cert}}</a><br>
                    @endforeach
                    @else
                    <p class="text-secondary">No Certificates found</p>
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
            <table class="table mt-3 table-bordered">
              <thead class="table-primary">
                <tr>
                  <th>Manual Files</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    @if(count($spreadcategory->manuals) > 0)
                    @foreach($spreadcategory->manuals as $manu)
                    <a target="_blank" href="/pdf/{{$manu}}"><i class="fa-solid fa-file-pdf text-danger p-2" style="font-size: 30px; "></i> {{$manu}}</a><br>
                    @endforeach
                    @else
                    <p class="text-secondary">No Manuals found</p>
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>


        <div class="col-md-6">
          <table class="table mt-3 table-bordered">
            <thead id="table-head" class="table-primary">
              <tr>
                <td>Spread type ({{ $spreadcategory->systemtype->name ?? '' }})</td>
              </tr>
            </thead>
            <tbody id="table-body">
              @foreach ($categories as $item)
              <tr>
                <td>{{ $item->name }}</td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>

        @if ($spreadcategory->system)

        <div class="col-md-6">
          <table class="table mt-3 mb-1 table-bordered" id="assets_table">
            <thead class="table-primary">
              <tr>
                <td>Sub component</td>
                <td>Status</td>
              </tr>
            </thead>
            <tbody id="sub-component-body">
              @foreach ($subcomponents as $item)
              <tr>
                <td class="subcomponent" data-id="{{ $item['id'] }}" data-spreadcategoryid="{{ $spreadcategory->id }}">{{ $item['name'] }} <span class="float-end">({{$item['asset_count']}})</span></td>
                <td>{{ $item['status'] }}</td>
              </tr>
              <tr id="assets-{{ $item['id'] }}" class="d-none">

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

      </div>

    </div>

  </div>
</div>


@push('scripts')
<script>
  $(document).ready(function() {
 

      // Event listener for the "Assign Asset" button click
      $("#assets_table").on("click", ".assignbtn", function(e) {
        e.preventDefault();  
        let spreadcategoryid = $(this).data('spreadcategoryid');
        let subcomid = $(this).data("subcomid");

        var closestTbody = $(this).closest('table tbody');  
        var selectedCheckboxes = closestTbody.find("input[type='checkbox']:checked");

        var selectedValues = [];
        selectedCheckboxes.each(function() {
            selectedValues.push($(this).val());
        }); 
        if (selectedValues.length > 0) { 
            var dataToSend = {
                assetIds: selectedValues,
                subcomponentid: subcomid,
                spreadcategoryid: spreadcategoryid
            };  
 
            $.ajax({
                url: '/spreadcategory/assign-asset-to-system',  
                type: 'GET',
                data: dataToSend,
                success: function(response) { 
                  
                  if (response.success == 1) {
                    alert("assigned successfully");
                    window.location.reload();
                  } else {
                    alert("something went wrong!");
                  }
                     
                },
                error: function(error) {
                    console.error("Error assigning assets:", error); 
                }
            });
        } else {
            alert("No assets selected!");
        }
    }); 


    function loadassets(subcomponentId, spreadcategoryid) {

      $(`#assets-${subcomponentId}`).html('');

      if ($(`#assets-${subcomponentId}`).hasClass('d-none')) {

        $.ajax({
          type: 'get',
          url: '/spreadcategory/get-all-unassigned-assets',
          success: function(response) { 
            
            if (response.success == 1) {
              
              let row = '';
            response.assets.forEach(e => {
             
              row += ` <tr>
                    <td><input type="checkbox" name="assetids[]" id="" value="${e.id}"></td>
                    <td>${e.description}</td>
                    <td>${e.system_modal}</td>
                    <td>${e.serial_no}</td>
                  </tr>`; 
            });

            let assetHTML = ` 
              <table class="table mt-1 table-bordered table-sm" style="max-height:200px; overflow-y:scroll; display:block;">
                <thead class="table-secondary ">
                  <tr>
                    <th style="width: 5%;">Select</th>
                    <th>Asset Name</th>
                    <th>Model</th>
                    <th>Serial No</th>
                  </tr>
                </thead>
                <tbody>
                    ${row}
                  <tr>
                    <td colspan="4"> <input type="submit" value="Assign Asset" class="btn btn-sm btn-primary float-end assignbtn" data-subcomid="${subcomponentId}" data-spreadcategoryid="${spreadcategoryid}"></td>
                  </tr> 
                </tbody> 
              </table> `;


            $(`#assets-${subcomponentId}`).append(assetHTML);
            $(`#assets-${subcomponentId}`).removeClass('d-none');

          } else {
              alert("No unassigned assets found!")
            }

          },
          error: function(res) {
            alert(res.responseJSON.message)
          }
        });  

      } else {
        $(`#assets-${subcomponentId}`).addClass('d-none');
      } 
    }


    $(document).on('click', '.subcomponent', function() {
      let subcomponentId = $(this).data('id'); 
      let spreadcategoryid = $(this).data('spreadcategoryid');
      loadassets(subcomponentId, spreadcategoryid);
    });


 
  


 

  });
</script>

@endpush

@endsection