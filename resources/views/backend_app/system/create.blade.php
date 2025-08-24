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
                <h1 class="m-0">Add Spread</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Spread</a></li>
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

            
            <form action="{{ route('store-system')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
                        <label for="">Spread Name</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" name="system_name" id="">

                    </div>

                    <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
                        <label for="">IMCA Audit Type Name</label>
                        <select name="system_type_id" class="form-select" id="">
                            <option value="">Select IMCA Audit Type</option>
                            @foreach ($systemtypes as $systemtype)
                            <option value="{{$systemtype->id}}"> {{$systemtype->name}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                        <label for="">Spread Description</label> 
                        <textarea name="system_description" id="" class="form-control">{{ old('name') }}</textarea>

                    </div>

                    <!-- <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Locations</label>
                        <select name="system_description" class="form-select" id="">
                            <option value="">select location</option>
                            @foreach ($locations as $location)
                            <option value="{{$location->id}}"> {{$location->name}}</option>
                            @endforeach
                        </select>
                    </div> -->
                </div>
                <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

            </form>
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