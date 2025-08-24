<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF</title>
  <style>
    .clearfix:after {
      content: "";
      display: table;
      clear: both;
    }

    .mb-1{margin-bottom: 10px;}
    .text-left{text-align:left;}
    .bold{font-weight: bold;}

    a {
      color: #5D6975;
      text-decoration: underline;
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
    table h3{
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
    .table-bordered{
      border: 1px solid #777777;
      margin-bottom: 20px;
    }
    .table-bordered tr td{
      border-bottom: 1px solid #777777;
    }
    .table-bordered tr td:first-child{
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

        $current_date = date('d-m-Y');
    ?>

<body>
  <header class="clearfix">
    <div class="header-top">

      <div id="logo" class="clearfix">
      <img src="{{ asset('assets/logo/1.jpeg') }}" alt="" />
         <h1>{{$system->system_name}}  {{$system->systemtype->name}}</h1>
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
            <p> {{$auditLog->task->description}} </p>
            <h3>Maintenance Routine Notes:</h3>
            <p> {{$auditLog->task->notes}}</p>
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
                  <td colspan="2">Date Completed</td>
                </tr>
                <tr>
                  <td colspan="2">@if($auditLog->task->expire_date) {{ auth()->user()->name }}   @endif</td>
                  <td colspan="2">@if($auditLog->task->expire_date) {{date('d-m-Y', strtotime($auditLog->task->expire_date))}}   @endif</td>
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
          <td colspan="2">{{$current_date}}
            <br>https://google.com/
          </td>
          <td colspan="2" style="text-align: right;">        
          <img src="{{ asset('assets/logo/1.jpeg') }}" style="width: 120px;" alt="" />
           
          </td>
        </tr>
      </tbody>
    </table>  
  </footer>
</body>

</html>