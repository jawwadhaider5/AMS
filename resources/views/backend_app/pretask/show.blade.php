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
                <h1 class="m-0">Predefined Task Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Pre Defined Tasks</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">


    <div class="card">
        <div class="card-datatable table-responsive p-4">


            <div class="row">
                <div class="col-md-6">
                <div class="card">
                <div class="card-body">
                        <table class="table table-striped">
                            <thead class=" table-primary">
                                <tr>
                                    <th class="w-25">Sheet Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $tasktype->name }} <i class="fa fa-arrow-right float-end"></i></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped">
                                <thead class=" table-primary">
                                    <tr>
                                        <th class="w-25">Task Name</th>
                                        <th class="w-50">Description</th>
                                        <th class="w-25">Frequency</th>
                                        <th class="w-25">Month/Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasktype->predefinedtasks as $pre)
                                    <tr>
                                        <td>{{ $pre->name }} </td>
                                        <td>{{ $pre->description }}</td>
                                        <td>{{ $pre->frequency }}</td>
                                        <td>{{ $pre->month_year }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



</div>
<!-- / Content -->



@push('scripts')
<script>
    // $(document).ready(function() {
    //     $(document).on('click', '.open-component', function() {
    //         let id = $(this).data('id');
    //         console.log(id);

    //         $(`#sub-category-${id}`).toggle();
    //     });
    // });
</script>

@endpush
@endsection