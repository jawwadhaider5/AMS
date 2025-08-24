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

    .mb-1 {
      margin-bottom: 10px;
    }

    .text-left {
      text-align: left;
    }

    .bold {
      font-weight: bold;
    }

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
      border-collapse: collapse;
    }

    .table-bordered tr td {
      border-bottom: 1px solid #777777;
      padding: 5px;
      border-collapse: collapse;
    }

    .table-bordered tr th {
      border-bottom: 1px solid #777777;
      text-align: left;
      padding: 5px;
      border-collapse: collapse;
    }

    .table-bordered tr td:first-child {
      background-color: #C1CED9;
    }

    table th {
      padding: 5px 5px;
      border-bottom: 1px solid #C1CED9;
      white-space: nowrap;
    }

    table table td {
      padding: 5px 5px;
    }

    footer {
      margin: 20px 0;
      padding: 8px 0;
    }
  </style>
</head>


<body>
  <header class="clearfix">
    <div class="header-top">
      <div id="logo" class="clearfix">
       
           <img src="{{ asset('assets/logo/1.jpeg') }}"  alt="" />
        <h1>{{$spread->system_name}} - {{$spread->systemtype->name}}</h1>
      </div>
    </div>
  </header>
  <main>

    <h2>Summary</h2>
    <table class="table-bordered">
      <tbody>
        <tr>
          <td colspan="2">Certified:</td>
          <td colspan="2">{{$certified}}</td>
        </tr>
        <tr>
          <td colspan="2">Expiring:</td>
          <td colspan="2">{{$expiring}}</td>
        </tr>
        <tr>
          <td colspan="2">Expired:</td>
          <td colspan="2">{{$expired}}</td>
        </tr>
        <tr>
          <td colspan="2">Incomplete:</td>
          <td colspan="2">{{$incomplete}}</td>
        </tr>
      </tbody>
    </table>


    <h2>Maintenance</h2>
    <h3>Work Schedule</h3>
    <p>The following is a list of maintenance required over the next 31 days</p>
    <table class="table-bordered">
      <thead>
        <tr>
          <th colspan="2">Task No</th>
          <th colspan="2">Asset Description</th>
          <th colspan="2">Task</th>
          <th colspan="2">Due Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($spread->tasks as $key => $value)
        <tr>
          <td colspan="2">{{ $value->id }}</td>
          <td colspan="2">{{ $value->asset->description }}</td>
          <td colspan="2">{{ $value->tasktype->name }}</td>
          <td colspan="2">{{ $value->expire_date }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <h2>Spare</h2>
    <h3>Spare Used</h3>
    <p>The following is a list of all spares used over the previous 31 days.</p>
    <table class="table-bordered">
      <thead>
        <tr>
          <th>Part No.</th>
          <th>Description</th>
          <th>Supplier</th>
          <th>Supplier Part No.</th>
          <th>Qty Used</th>
          <th>Remaining</th>
          <th>Due Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($spares as $key => $value)
        <tr>
          <td>{{ $value->part_number}}</td>
          <td>{{ $value->description }}</td>
          <td>{{ $value->supplier }}</td>
          <td>{{ $value->supplier_part_number }}</td>
          <td>{{ $value->quantity }}</td>
          <td>{{ $value->critical_quantity }}</td>
          <td>{{ $value->created_at }}</td>
        </tr>
        @empty

        <tr>
            
          <td colspan="7">no spares found!</td>
        </tr>

        @endforelse

      </tbody>
    </table>



  </main>

  <footer style="position: absolute; bottom:0; width:100%">
    <table>
      <tbody>
        <tr>
          <td>
              <br>
              
            <br>https://google.com/
          </td>
          <td style="text-align: right;">
              
          
              
               <img src="{{ asset('assets/logo/1.jpeg') }}" style="width: 120px;" alt="" />
          </td>
        </tr>
      </tbody>
    </table>
  </footer>
</body>


</html>