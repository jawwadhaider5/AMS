@extends('backend_app.layouts.template')
@section('content')
<!-- 
<div class="layout-page">
    include('backend_app.layouts.nav') 
    <div class="content-wrapper"> -->

    @section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Sub Component</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-1"><span class="text-muted fw-light">NDE Sub Components</span> </h4>

            @can('create sub component')
            <div class="row">
                <div class="col-12">
                    <a href="{{route('add-subcategory')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Sub Components +</a>
                </div>
            </div>
            @endcan

            <div class="card">

                @can('all sub component')
                <div class="table-responsive text-nowrap">
                    <table class="table" id="subcomponents_table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>Sub Components</th>
                                <th>Components</th>
                                <th>Serial No</th>
                                <th>IMCA</th>
                                <th>Assigned To</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($subcategories as $category)
                            <tr>
                                <td>{{$category->subcategory_name}} </td>
                                <td>{{$category->category_name}} </td>
                                <td>{{$category->id}}</td>
                                <td>{{ $category->system_type_name }}</td>
                                <td>{{ $category->spread_name}}</td>
                                <td>{{ $category->location}}</td>
                                <td>
                                    <span class="btn btn-sm 
                              @if($category->status === 'Expired') 
                                  btn-danger
                              @elseif($category->status === 'Expiring') 
                                  btn-warning
                              @elseif($category->status === 'Certified') 
                                  btn-success
                              @else 
                                  btn-secondary
                              @endif
                              waves-effect waves-light">
                                        {{ $category->status }}
                                    </span>

                                </td>
                                <td class="text-end">
                                    @can('edit sub component')
                                    <a href="{{ route('edit-subcategory', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('transfer sub component')
                                    <a title="Transfer Sub Component" class="btn btn-sm btn-outline-info hide-read-only" href="{{ route('transfer-sub-category', $category->id) }}">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                    @endcan
                                    @can('delete sub component')
                                    <a href="{{ route('delete-subcategory', $category->id) }}" class="btn btn-sm btn-danger @if($category->id  == 1) d-none @endif" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @endcan
                                </td>
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
                {{-- {{$data->links()}} --}}
            </div>

        </div>
        <!-- / Content -->

        <!-- Footer -->
        <!-- include('backend_app.layouts.footer')
        <div class="content-backdrop fade"></div>
    </div>
</div> -->


@push('scripts')
<script>
    $('#subcomponents_table').DataTable({
        pageLength: 10
    });
</script>
@endpush


@endsection