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
        <h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection


<div class="container-xxl w-100 flex-grow-1 container-p-y w-100">
  <div class="row">
    <!-- Website Analytics -->
    <div class="col-lg-6 col-12 ">
      <div class="card" style="min-height: 400px;overflow-y:scroll;">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-0">Assets</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-md-4 pt-5">
              <ul class="chart-legend clearfix">
                <li>
                  <p><i class="far fa-circle" style="color: #1ac400;"></i> Certified ({{ $chartData[0] }})</p>
                </li>
                <li>
                  <p><i class="far fa-circle" style="color: #f7d200;"></i> Expiring ({{ $chartData[1] }})</p>
                </li>
                <li>
                  <p><i class="far fa-circle" style="color: #f04c00;"></i> Expire ({{ $chartData[2] }})</p>
                </li>
                <li>
                  <p><i class="far fa-circle" style="color: #b8b8b8;"></i> Incomplete ({{ $chartData[3] }})</p>
                </li>
              </ul>
            </div>

            <div class="col-md-8">
              <div class="chart-responsive">
                <canvas id="pieChart" height="150"></canvas>
              </div>
            </div>


          </div>

          <!-- <div id="donutChart"></div> -->
        </div>
      </div>
    </div>
    <!--/ Website Analytics -->

    <!-- Sales Overview -->

    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card" style="min-height:455px;max-height:455px;overflow-y:scroll;">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-0">System List
              &nbsp;<span class="btn btn-sm btn-primary float-end" id="add_system_modal" data-id="{{$sysid->id}}"><i class="fa fa-plus"></i></span></h5>
            <input type="hidden" value="{{$sysid->system_type_id}}" id="old_system_type_id">
            <input type="hidden" value="{{$sysid->id}}" id="old_system_id">
          </div>
        </div>
        <div class="card-body">
          <div>
            <table class="table table-bordered" id="system_table">
              <thead>
                <th>System</th>
                <th>Current Status</th>
                <th>Actions</th>
              </thead>
              <tbody>
                @foreach ($asignspread as $spread)
                <tr>
                  <td>
                    @can('all system')
                    <a href="{{ route('show-spreadcategory', $spread->id) }}">{{$spread->system_description}}</a>
                    @endcan
                  </td>
                  <td><span class="btn btn-sm @if($spread->status == 'Certified') btn-success 
                                @elseif($spread->status == 'Expiring') btn-warning 
                                @elseif($spread->status == 'Expired') btn-danger 
                                @elseif($spread->status == 'Incomplete') btn-secondary @endif">{{ $spread->status }}</span></td>
                  <td>
                  <a href="{{ route('un-assign-system', $spread->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to un assign the system?')">Un-assign</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            <table class="table table-bordered ">
              <thead>
                <th colspan="3">Spread Summary</th>
              </thead>
              <tbody>
                @foreach ($spreadlists as $spread)
                @if($sysid->system_type_id == $spread->system_type_id )
                <tr>
                  <td>{{$spread->system_name}}</td>
                  <td class="text-center">
                    <a href="{{route('system-summary' , $spread->system_type_id)}}" target="_blank">
                      <i class="fas fa-file-pdf text-danger" style="font-size: 30px;"></i> <br>System Summary
                    </a>
                  </td>
                  <td class="text-center">
                    <a href="{{route('work-order-pdf' , $spread->id)}}" target="_blank">
                      <i class="fas fa-file-pdf text-danger" style="font-size: 30px;"></i> <br> Work Orders
                    </a>
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Projects table -->
    <br>
    <div class="col-6 col-xl-6 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0 mt-2">
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex flex-wrap justify-content-between">
            <span class="h5 mb-0 text-warning">Expiring Tasks</span>
            <a href="{{route('expiring-work-order-pdf' , $spread->id)}}" id="" class="btn btn-warning btn-sm pull-right hide-popconfirm" style="width: auto;" target="_blank"><i class="fas fa-file-pdf pr-1"></i>Work Orders</a>
          </div>
        </div>
        <div class="table-responsive text-nowrap" style="min-height:300px;max-height:300px;overflow:auto;">
          <table class="table" id="expiring_table">
            <thead>

              <tr>
                <th>Inspection Requirments</th>
                <th>Asset</th>
                <th>Sheet Number</th>
                <th>Description</th>
                <th>Expiry Date</th>
              </tr>
            </thead>
            @foreach ($tasks as $task)
            <tr>
              <td>{{$task->name}}</td>
              <td>
                <a @can("edit asset") href="{{ route('asset-category-edit', $task->asset_id) }} " @endcan>{{$task->asset_id}}</a>
              </td>
              <td>{{$task->task_type_name}}</td>
              <td> {{substr($task->description, 0, 200)}}</td>
              <td>{{$task->expire_date}}</td>
            </tr>
            @endforeach
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div class="col-6 col-xl-6 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0 mt-2">
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex flex-wrap justify-content-between">
            <span class="h5 mb-0 text-danger">Tasks</span>
            <select name="" class="w-50 form-select py-0" id="filter">
              <option value="expired">Expired</option>
              <option value="incomplete">Incompelete</option>
            </select>
            <a href="{{route('expired-work-order-pdf' , $spread->id)}}" id="expiredpdf" class="btn btn-danger btn-sm pull-right hide-popconfirm" style="width: auto;" target="_blank"><i class="fas fa-file-pdf pr-1"></i>Work Orders</a>
            <a href="{{route('incomplete-work-order-pdf' , $spread->id)}}" id="incompletepdf" class="btn btn-danger btn-sm pull-right hide-popconfirm" style="width: auto; display:none;" target="_blank"><i class="fas fa-file-pdf pr-1"></i>Work Orders</a>
          </div> 
        </div>
        <div class="table-responsive text-nowrap"  id="expired_list" style="min-height:300px;max-height:300px;overflow:auto;">
          <table class="table" id="expired_table">
            <thead>
              <tr>
                <th>Inspection Requirements</th>
                <th>Asset ID</th>
                <th>Sheet Number</th>
                <th>Description</th>
                <th>Expire Date</th>
              </tr>
            </thead> 
            <tbody> 
              @foreach ($expiretasks as $task)
              <tr>
                <td>{{$task->name}}</td>
                <td>
                  <a @can("edit asset") href="{{ route('asset-category-edit', $task->asset_id) }}" @endcan>{{$task->asset_id}}</a>
                </td>
                <td>{{$task->task_type_name}}</td>
                <td>{{substr($task->description, 0, 200)}}</td>
                <td>{{$task->expire_date}}</td>
              </tr>
              @endforeach 
            </tbody>  
          </table>

        </div>
        <div class="table-responsive text-nowrap" id="incomplete_list"  style="min-height:300px;max-height:300px;overflow:auto; display:none;">
          <table class="table" id="incomplete_table">
            <thead>
              <tr>
                <th>Inspection Requirements</th>
                <th>Asset ID</th>
                <th>Sheet Number</th>
                <th>Description</th>
                <th>Expire Date</th>
              </tr>
            </thead>   
            <tbody >
              @foreach ($incompletetasks as $task)
              <tr>
                <td>{{$task->name}}</td>
                <td>
                  <a @can("edit asset") href="{{ route('asset-category-edit', $task->asset_id) }}" @endcan>{{$task->asset_id}}</a>
                </td>
                <td>{{$task->task_type_name}}</td>
                <td>{{substr($task->description, 0, 200)}}</td>
                <td>{{$task->expire_date}}</td>
              </tr>
              @endforeach
            </tbody> 
          </table> 
        </div>
      </div>
    </div>

    <!--/ Projects table -->
  </div>
</div>
<!-- <div class="content-backdrop fade"></div> -->


<div class="modal fade" id="all_systems_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign System</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table ">
              <thead class="table-primary">
                <th>System Detail</th>
                <th>Action</th>
              </thead>
              <tbody>
                @foreach ($spreadcategorys as $sc)
                <tr>
                  <td>{{$sc->system_description}}</td>
                  <td><span class="btn btn-sm btn-primary float-end assign_system" data-system_id="{{$sc->system_id}}" data-new_system_id="{{$sc->id}}" data-new_system_type_id="{{$sc->system_type_id}}"><i class="fa fa-plus"></i></span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- </div>
  include('backend_app.layouts.footer') -->

@push('scripts')
<script>
  $('#expired_table').DataTable({
    pageLength: 25
  });

  $('#expiring_table').DataTable({
    pageLength: 25
  });

  $('#incomplete_table').DataTable({
    pageLength: 25
  });

  $('#system_table').DataTable({
    pageLength: 10
  });

  $("#filter").on('change', function() {

    var value = $(this).val();
    if (value == "expired") {
      $("#expired_list").show()
      $("#incomplete_list").hide()
      $("#expiredpdf").show()
      $("#incompletepdf").hide()
    } else {
      $("#expired_list").hide()
      $("#incomplete_list").show()
      $("#expiredpdf").hide()
      $("#incompletepdf").show()
    }



  })


  const chartData = <?php echo json_encode($chartData); ?>;

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData = {
    labels: ['Certified', 'Expiring', 'Expired', 'Incomplete'],
    datasets: [{
      data: chartData,
      backgroundColor: ["#1ac400", "#f7d200", "#f04c00", "#b8b8b8"],
    }]
  }
  var pieOptions = {
    legend: {
      display: true
    }
  }

  var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions
  })


  $("#add_system_modal").on('click', function() {
    // var system_type_id = $(this).data("id");
    // var ostid = $("#old_system_type_id").val(); 
    $("#all_systems_modal").modal("show")
  })

  $('#all_systems_modal').on('show.bs.modal', function() {})
  $('#all_systems_modal').on('hidden.bs.modal', function() {})


  // $('#new_system_type_id').change(function() {
  //   var new_system_type_id = $(this).val();

  //   if (new_system_type_id) {
  //     $.ajax({
  //       url: '/spreadcategory/get-systems/' + new_system_type_id,
  //       type: "GET",
  //       dataType: "json",
  //       success: function(data) {
  //         $('#new_system_id').empty();
  //         $('#new_system_id').append('<option value="">Select System</option>');

  //         $.each(data, function(key, value) {
  //           $('#new_system_id').append('<option value="' + value.id + '">' + value.system_description + '</option>');
  //         });
  //       }
  //     });
  //   } else {
  //     $('#new_system_id').empty();
  //     $('#new_system_id').append('<option value="">Select System</option>');
  //   }
  // });


  $(".assign_system").on('click', function() {
    // var system_type_id = $(this).data("id");
    // var ostid = $("#old_system_type_id").val();
    // var nstid = $("#new_system_type_id").val();
    // var nsid = $("#new_system_id").val();

    var ostid = $("#old_system_type_id").val();
    var osid = $("#old_system_id").val();

    var nstid = $(this).data("new_system_type_id");
    var nsid = $(this).data("new_system_id");

    var alreadyAssigned = $(this).data("system_id");


    if (!nsid) {
      alert("select a system")
    } else if (alreadyAssigned) {
      alert("This system already has been assigned. You can not reassign it.")
    } else {
      if (ostid != nstid) {
        var conf = confirm("you are adding system from another spread type")
        if (conf) {
          $.ajax({
            url: '/spreadcategory/assign-system/',
            type: "GET",
            data: {
              "old_system_type_id": ostid,
              "new_system_type_id": nstid,
              "old_system_id": osid,
              "new_system_id": nsid
            },
            success: function(data) {
              location.reload();
            }
          });
        }
      } else {
        $.ajax({
          url: '/spreadcategory/assign-system/',
          type: "GET",
          data: {
            "old_system_type_id": ostid,
            "new_system_type_id": nstid,
            "old_system_id": osid,
            "new_system_id": nsid
          },
          success: function(data) {
            location.reload();
          }
        });
      }
    }
    // $("#all_systems_modal").modal("hide")
  })



  // const chartData = <?php echo json_encode($chartData); ?>;

  // const purpleColor = '#1ac400',
  //   yellowColor = '#f7d200',
  //   cyanColor = '#28dac6',
  //   orangeColor = '#f04c00',
  //   oceanBlueColor = '#b8b8b8';

  // let cardColor, headingColor, labelColor, borderColor, legendColor;

  // if (isDarkStyle) {
  //   cardColor = config.colors_dark.cardColor;
  //   headingColor = config.colors_dark.headingColor;
  //   labelColor = config.colors_dark.textMuted;
  //   legendColor = config.colors_dark.bodyColor;
  //   borderColor = config.colors_dark.borderColor;
  // } else {
  //   cardColor = config.colors.cardColor;
  //   headingColor = config.colors.headingColor;
  //   labelColor = config.colors.textMuted;
  //   legendColor = config.colors.bodyColor;
  //   borderColor = config.colors.borderColor;
  // }

  // // Create combined labels with values
  // const combinedLabels = [
  //   `Certified ${chartData[0]}`,
  //   `Expiring ${chartData[1]}`,
  //   `Expired ${chartData[2]}`,
  //   `Incomplete ${chartData[3]}`
  // ];

  // // Donut Chart
  // const donutChartEl = document.querySelector('#donutChart');
  // const donutChartConfig = {
  //   chart: {
  //     height: 390,
  //     type: 'donut'
  //   },
  //   labels: combinedLabels,
  //   series: chartData, // Use the same chartData array
  //   colors: [purpleColor, yellowColor, orangeColor, oceanBlueColor],
  //   stroke: {
  //     show: false,
  //     curve: 'straight'
  //   },
  //   dataLabels: {
  //     enabled: true,
  //     formatter: function(val, opt) {
  //       return opt.w.globals.series[opt.seriesIndex];
  //     }
  //   },
  //   legend: {
  //     show: true,
  //     position: 'bottom',
  //     markers: {
  //       offsetX: -3
  //     },
  //     itemMargin: {
  //       vertical: 3,
  //       horizontal: 10
  //     },
  //     labels: {
  //       colors: legendColor,
  //       useSeriesColors: false
  //     }
  //   },
  //   plotOptions: {
  //     pie: {
  //       donut: {
  //         labels: {
  //           show: true,
  //           name: {
  //             fontSize: '2rem',
  //             fontFamily: 'Public Sans'
  //           },
  //           value: {
  //             fontSize: '1.2rem',
  //             color: legendColor,
  //             fontFamily: 'Public Sans',
  //             formatter: function(val) {
  //               return val;
  //             }
  //           },
  //           total: {
  //             show: true,
  //             fontSize: '1.5rem',
  //             color: headingColor,
  //             label: 'Total',
  //             formatter: function(w) {
  //               return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
  //             }
  //           }
  //         }
  //       }
  //     }
  //   },
  //   responsive: [{
  //       breakpoint: 992,
  //       options: {
  //         chart: {
  //           height: 380
  //         },
  //         legend: {
  //           position: 'bottom',
  //           labels: {
  //             colors: legendColor,
  //             useSeriesColors: false
  //           }
  //         }
  //       }
  //     },
  //     {
  //       breakpoint: 576,
  //       options: {
  //         chart: {
  //           height: 320
  //         },
  //         plotOptions: {
  //           pie: {
  //             donut: {
  //               labels: {
  //                 show: true,
  //                 name: {
  //                   fontSize: '1.5rem'
  //                 },
  //                 value: {
  //                   fontSize: '1rem'
  //                 },
  //                 total: {
  //                   fontSize: '1.5rem'
  //                 }
  //               }
  //             }
  //           }
  //         },
  //         legend: {
  //           position: 'bottom',
  //           labels: {
  //             colors: legendColor,
  //             useSeriesColors: false
  //           }
  //         }
  //       }
  //     },
  //     {
  //       breakpoint: 420,
  //       options: {
  //         chart: {
  //           height: 280
  //         },
  //         legend: {
  //           show: false
  //         }
  //       }
  //     },
  //     {
  //       breakpoint: 360,
  //       options: {
  //         chart: {
  //           height: 250
  //         },
  //         legend: {
  //           show: false
  //         }
  //       }
  //     }
  //   ]
  // };

  // if (donutChartEl !== undefined && donutChartEl !== null) {
  //   const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
  //   donutChart.render();
  // }
</script>



@endpush
@endsection