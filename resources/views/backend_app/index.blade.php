@extends('backend_app.layouts.template')
@section('content')


<!-- 
include('backend_app.layouts.nav')

<div class="content-wrapper mt-5 pt-5"> -->

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
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

<!-- Content -->
<div class="container-xxl w-100 flex-grow-1 container-p-y w-100">
  <div class="row">
    <div class="col-lg-6 col-12 ">
      <div class="card">
        <div class="card-header header-elements">
          <h5 class="card-title mb-0"> NDE Asset Status</h5>
        </div>
        <div class="card-body">

          <div class="row"> 
          <div class="col-md-4 pt-5">
              <ul class="chart-legend clearfix">
                <li><p><i class="far fa-circle" style="color: #1ac400;"></i> Certified ({{ $chartData[0] }})</p></li>
                <li><p><i class="far fa-circle" style="color: #f7d200;"></i> Expiring ({{ $chartData[1] }})</p></li>
                <li><p><i class="far fa-circle" style="color: #f04c00;"></i> Expire ({{ $chartData[2] }})</p></li>
                <li><p><i class="far fa-circle" style="color: #b8b8b8;"></i> Incomplete ({{ $chartData[3] }})</p></li> 
              </ul>
            </div>

            <div class="col-md-8">
              <div class="chart-responsive">
                <canvas id="pieChart" height="150"></canvas>
              </div> 
            </div> 
          </div> 
 
        </div>
      </div>
    </div>


    <div class="col-xl-6 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-0">Spread List</h5>

          </div>

        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="dashboard_spread_table">
              <thead>
                <tr>
                  <th>Spread</th>
                  <th>Description</th>
                  <th>Current Status</th>
                </tr>
              </thead>

              @foreach ($spreads as $spread)
              <tr>
                <!-- <td><a href="{{ route('save-systemtype-id', $spread->systemtype->id) }}">{{$spread->system_name}}</a></td> -->

                <td><a href="{{ route('save-systemtype-id', $spread->id) }}">{{$spread->system_name}}</a></td>
                <td>{{$spread->system_description}}</td>
                @php
                $status = getStatus($spread->id);
                @endphp
                <td>
                  @if($spread->status === 'Certified')
                  <span class="btn btn-sm btn-success waves-effect waves-light m-auto d-block">{{ $spread->status }}</span>
                  @elseif($spread->status === 'Incomplete')
                  <span class="btn btn-sm btn-secondary waves-effect waves-light m-auto d-block">{{ $spread->status }}</span>
                  @elseif($spread->status === 'Expiring')
                  <span class="btn btn-sm btn-warning waves-effect waves-light m-auto d-block">{{ $spread->status }}</span>
                  @elseif($spread->status === 'Expired')
                  <span class="btn btn-sm btn-danger waves-effect waves-light m-auto d-block">{{ $spread->status }}</span>
                  @else
                  <span class="btn btn-sm btn-secondary waves-effect waves-light m-auto d-block">{{ $spread->status }}</span>
                  @endif
                </td>

              </tr>
              @endforeach
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <div class="content-backdrop fade"></div> -->



<!-- include('backend_app.layouts.footer') -->


@push('scripts')


<!-- Main JS -->
<!-- <script src="{{ asset('assets/js/main.js') }}"></script> -->

<script>
  // Pass PHP array to JavaScript
  const chartData = <?php echo json_encode($chartData); ?>;
 
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData = {
    labels: ['Certified','Expiring','Expired','Incomplete'],
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










  $('#dashboard_spread_table').DataTable({
    pageLength: 10
  });
</script>
@endpush
@endsection