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
        $current_date = date('d-m-Y');
    ?>

<body>
  <header class="clearfix">
    <div class="header-top">

      <div id="logo" class="clearfix">
        <img src="{{ asset('assets/logo/1.jpeg') }}" alt="" />
         <h1>Asset Detail QR Code</h1>
      </div>
    </div>
  </header>
  <main class="text-center">
    
  {!! QrCode::size(250)->generate($link); !!}
            <h3>Scan for Asset: {{ $id }}</h3>

            <br><br><br>
            <a href="{{route('asset-qrcode-pdf',$id)}}" class="btn btn-sm btn-outline-primary" title="Downlaod the QR code">
                                    <i class="fa fa-qrcode"></i>
                                 </a>
      
  </main>
  <footer>
    <table>
      <tbody>
        <tr>
          <td colspan="2">{{$current_date}}
            <br>https://google.com/
          </td>
          <td colspan="2" style="text-align: right;">        
            <img src="{{ asset('assets/logo/1.jpeg') }}" style="width: 120px;" />
          </td>
        </tr>
      </tbody>
    </table>  
  </footer>
</body>

</html>