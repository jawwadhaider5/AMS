@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">

    @include('backend_app.layouts.nav')

    <div class="content-wrapper"> -->

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Spare</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Spares</a></li>
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


            <form action="{{route('store-spares')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <label for="">System Name</label>
                        <select name="system_name" class="form-select" id="">
                            <option value="">select system </option>
                            @foreach ($systems as $system)
                            <option value="{{$system->id}}"> {{$system->system_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <label for="">Part Number</label>
                        <input value="{{ old('part_number') }}" type="text" class="form-control" name="part_number">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 mt-3">
                        <label for="">Description</label>
                        <textarea name="description" cols="30" class="form-control" rows="5"></textarea>

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Supplier</label>
                        <input value="{{ old('supplier') }}" type="text" class="form-control" name="supplier">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Supplier Part Number</label>
                        <input value="{{ old('supplier_part_number') }}" type="text" class="form-control" name="supplier_part_number">
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Quantity</label>
                        <input value="{{ old('quantity') }}" type="text" class="form-control" name="quantity">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Critical Quantity</label>
                        <input value="{{ old('critical_quantity') }}" type="text" class="form-control" name="critical_quantity">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

            </form>
        </div>

    </div>
</div>
<!-- include('backend_app.layouts.footer')
      <div class="content-backdrop fade"></div>
    </div>
  </div> -->
@endsection