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
                <h1 class="m-0"> IMCA Audit Type Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">IMCA Audit Type</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- <div class="card">
        <div class="card-datatable table-responsive p-4">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif
            <form action="{{ route('store-systemtype')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <label for="">Spread Type Name</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" name="system_type" id="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

            </form>
        </div>
    </div> -->


    <div class="card">
        <div class="card-datatable table-responsive p-4">

            <h2>{{ $systemtype->name }}</h2>
            @foreach($systemtype->categories as $cat)


            <div class="row">
                <div class="col-md-6">
                    <div class="input-group my-2">
                        <button type="button" class="btn btn-outline-secondary ml-2 open-component w-100 text-left" data-id="{{$cat->id}}">
                            {{$cat->display_id}} - {{$cat->name}} <i class="fa fa-arrow-right float-end"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="display: none;" id="sub-category-{{$cat->id}}">
                        <div class="card-body">
                            <!-- @foreach($cat->subcategories as $subcat)
                            <p>{{ $subcat->id }} - {{ $subcat->name }}</p>
                            @endforeach -->
                            <table class="table table-striped">
                                <thead class=" table-primary">
                                    <tr>
                                        <th class="w-25">ID</th>
                                        <th class="w-50">Inspection</th>
                                        <th class="w-25">Sheet Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cat->subcategories as $subcat)
                                    <tr>
                                        <td>{{ $subcat->display_id }} </td>
                                        <td>{{ $subcat->name }}</td>
                                        <!-- <td>{{ $subcat->tasktype ? $subcat->tasktype->name : '' }}</td> -->
                                        <td>
                                        @foreach($subcat->sheets as $sheet)
                                                    {{ $sheet->tasktype->name }} ,
                                        @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            @endforeach

        </div>
    </div>



</div>
<!-- / Content -->



@push('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.open-component', function() {
            let id = $(this).data('id');
            console.log(id);

            $(`#sub-category-${id}`).toggle();
        });
    });
</script>

@endpush
@endsection