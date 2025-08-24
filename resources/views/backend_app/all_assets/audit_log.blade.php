@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
  @include('backend_app.layouts.nav') 
  <div class="content-wrapper"> -->
    <!-- Content -->

    @section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Assets</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Assets</a></li>
                    <li class="breadcrumb-item active">Audit Log</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

    <div class="container-xxl flex-grow-1 container-p-y"> 

      <div class="card">
        <div class="card-datatable table-responsive p-4">



          <style>
            .clearfix:after {
              content: "";
              display: table;
              clear: both;
            }

            .mb-1 {
              margin-bottom: 10px;
            }

            .text-left {
              text-align: left;
            }

            .bold {
              font-weight: bold;
            }
 
            body {
              position: relative;
              margin: 0 auto;
              color: #001028;
              background: #FFFFFF;
              font-family: sans-serif;
              font-size: 12px;
            }

            header {
              padding: 10px 0;
              margin-bottom: 30px;
            }

            .header-top {
              display: flex;
              justify-content: space-between;
              border-bottom: 1px solid #000000;
            }

            table h3 {
              margin: 0 0 10px;
              text-align: left;
            }

            #logo {
              margin: 0 auto 10px;
              text-align: center;
            }

            #logo img {
              max-width: 100%;
              width: 200px;
            }

            .header-top h1 {
              font-size: 2.2em;
              line-height: 1.4em;
              font-weight: normal;
              text-align: center;
              margin: 0;
            }

            table {
              width: 100%;
              border-collapse: collapse;
            }

            .table-bordered {
              border: 1px solid #777777;
              margin-bottom: 20px;
            }

            .table-bordered tr td {
              border-bottom: 1px solid #777777;
            }

            .table-bordered tr td:first-child {
              background-color: #C1CED9;
            }

            table th {
              padding: 5px 20px;
              border-bottom: 1px solid #C1CED9;
              white-space: nowrap;
            }

            table table td {
              padding: 8px 14px;
            }

            footer {
              margin: 20px 0;
              padding: 8px 0;
            }
          </style>
          </head>

          <?php 

          $start_date = ($auditLog->task->start_date) ? new DateTime($auditLog->task->start_date) : '';
          $expire_date = ($auditLog->task->expire_date) ? new DateTime($auditLog->task->expire_date) : '';


          // $interval = $start_date->diff($expire_date);
          // $month_difference = $interval->format('%m');

          $current_date = date('d-m-Y');
          ?>

          <body>
            <header class="clearfix">
              <div class="header-top">

                <div id="logo" class="clearfix">
          <!--<img src="{{ asset('assets/logo/1.jpeg') }}" alt="" />-->
                  <h1>{{$system->system_name}} {{$system->systemtype->name}}</h1>
                </div>
              </div>
            </header>
            <main>
              <h2>Certification of Inspection</h2>
              <table>
                <tbody>
                  <tr>
                    <td>
                      <h3>Asset Information</h3>
                      <table class="table-bordered">
                        <tbody>
                          <tr>
                            <td colspan="2">Asset ID</td>
                            <td colspan="2">{{$auditLog->asset->id}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Description</td>
                            <td colspan="2"> {{$auditLog->asset->description}} </td>
                          </tr>
                          <!-- <tr>
                            <td colspan="2">Location</td>
                            <td colspan="2">auditLog->asset->assetlocation->name</td>
                          </tr> -->
                          <tr>
                            <td colspan="2">Manufacturer</td>
                            <td colspan="2">{{$auditLog->asset->manufacturer}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Model</td>
                            <td colspan="2">{{$auditLog->asset->system_modal}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Serial No.</td>
                            <td colspan="2">{{$auditLog->asset->serial_no}}</td>
                          </tr>

                        </tbody>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h3>Task Information</h3>
                      <table class="table-bordered">
                        <tbody>
                          <tr>
                            <td colspan="2">Task Title</td>
                            <td colspan="2">{{$auditLog->task->name}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Task No</td>
                            <td colspan="2">{{$auditLog->task->id}} </td>
                          </tr>
                          <tr>
                            <td colspan="2">IMCA D018</td>
                            <td colspan="2">{{$auditLog->task->asset->systemtype->name}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">IMCA D023</td>
                            <td colspan="2">{{$auditLog->task->asset->systemtype->name}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Periodicity</td>
                            <td colspan="2">{{$auditLog->task->frequency}} {{$auditLog->task->month_year}}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Expiry Date</td>
                            <td colspan="2">@if($auditLog->task->expire_date) {{date('d-m-Y', strtotime($auditLog->task->expire_date))}}   @endif</td>
                          </tr>

                        </tbody>
                      </table>
                    </td>
                  </tr>


                  <tr>
                    <td>
                      <h3>IMCA D018 Requirements:</h3>
                      <p> {{$auditLog->task->description}}</p>
                      <h3>Maintenance Routine Notes:</h3>
                      <p>{{$auditLog->task->notes}}</p> 
                      <h3>Renewal Notes</h3>
                      <p>{{$auditLog->task->renew_notes}}</p>

                    </td>
                  </tr>

                  <tr>
                    <td>
                      <table style="border: 2px solid gray;">
                        <tbody>
                          <tr>
                            <td colspan="2">Completed By</td>
                            <td colspan="2">Inspected On</td>
                          </tr>
                          <tr>
                            <td colspan="2">@if($auditLog->task->expire_date) {{ auth()->user()->name }}   @endif</td>
                            <td colspan="2">@if($auditLog->task->start_date) {{date('d-m-Y', strtotime($auditLog->task->start_date))}}   @endif</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>

                </tbody>
              </table>

            </main>
            <footer>
              <table>
                <tbody>
                  <tr>
                    <td colspan="2"> Submitted on {{$current_date}}
                      <br>https://ndeoffshore.com/
                    </td>
                    <td colspan="2" style="text-align: right;">
                        <!--<img src="{{ asset('assets/logo/1.jpeg') }}" style="width: 120px;" alt="" />-->
            
                    </td>
                  </tr>
                </tbody>
              </table>
            </footer>
          </body>




        </div>

      </div>
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <!-- include('backend_app.layouts.footer')
    <div class="content-backdrop fade"></div>
  </div>
</div> -->




@endsection