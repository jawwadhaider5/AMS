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
               
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Barcode</a></li>
                    <li class="breadcrumb-item active">Print</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection


<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card p-3">
        {!! QrCode::size(250)->generate($link); !!}
        <h3>Scan for Asset: {{ $id }}</h3>

        <br><br><br>
        <a href="{{route('asset-qrcode-pdf',$id)}}" class="btn btn-sm btn-outline-primary w-25" title="Downlaod the QR code">
            <i class="fa fa-qrcode"></i>
        </a>
    </div>


</div>

<!-- 
        include('backend_app.layouts.footer')
    </div> -->

@endsection