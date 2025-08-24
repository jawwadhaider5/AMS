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
                <h1 class="m-0">All Locations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Location</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection


        <div class="container-xxl flex-grow-1 container-p-y"> 

            @can('create location')
            <div class="row">
                <div class="col-12">
                    <a href="{{route('add-locations')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add locations +</a>
                </div>
            </div>
            @endcan

            <!-- DataTable with Buttons -->
            <div class="card">

                @can('all location')
                <div class="table-responsive text-nowrap">
                    <table class="table" id="location_table">
                        <thead>
                            <tr class="text-nowrap">
                                <td class="text-start">#</td>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        <tbody id="table-body">

                            @foreach ($locations as $location)
                            <tr>
                                <td class="text-start">{{$loop->index+1}}</td>
                                <td>{{$location->name}}</td>
                                <td class="text-end">
                                    @can('edit location')
                                    <a href="{{ route('edit-locations', $location->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('delete location')
                                    <a href="{{ route('delete-locations', $location->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @endcan
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        </thead>
                    </table>
                </div>
                @endcan
            </div>
            <div id="paginationContainer" class="float-end mt-3">
            </div>
        </div>


        <!-- include('backend_app.layouts.footer')

        <div class="content-backdrop fade"></div>
    </div>

</div> -->


@push('scripts')
<script>
    $('#location_table').DataTable({
        pageLength: 10
    });
</script>
@endpush


@endsection