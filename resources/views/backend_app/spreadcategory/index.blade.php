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
                <h1 class="m-0">All Systems</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Systems</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection


<div class="container-xxl flex-grow-1 container-p-y"> 
    @can('create system')
    <div class="row">
        <div class="col-12">
            <a href="{{route('add-spreadcategory')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add System +</a>
        </div>
    </div>
    @endcan

    <div class="card">

        @can('all system')
        <div class="table-responsive text-nowrap">
            <table class="table" id="spreadcategory_table">
                <thead class="table-primary">
                    <tr class="text-nowrap">
                        <th class="text-left">System</th> 
                        <th class="text-left">Spread</th>
                        <th class="text-left">IMCA Audit Type</th>
                        <th class="text-left">Manufacturer</th>
                        <th class="text-left">Model Number</th>
                        <th class="text-left">ID Number</th>
                        <th class="text-left">Class</th>
                        <th class="text-left">Dimension</th>
                        <th class="text-left">Container Number</th>
                        <th class="text-left">Serial Number</th>
                        <th class="text-left">Weight</th>
                        <th class="text-left">M. Year</th>
                        <th class="text-left">P. Year</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php $count = 1 ?>
                    @foreach ($spreadcategorys as $spreadcategory)
                    <tr>
                        <td class="text-left"> <a href="{{ route('show-spreadcategory', $spreadcategory->id) }}">{{$spreadcategory->system_description}}</a></td>
                        <td class="text-left">@if ($spreadcategory->system) {{ $spreadcategory->system->system_name ?? '' }} @else <span class="btn btn-sm btn-warning">Not Assigned</span> @endif</td>
                        <td class="text-left">{{ $spreadcategory->systemtype->name  ?? '' }}</td>
                        <td class="text-left">{{ $spreadcategory->manufraturer }}</td>
                        <td class="text-left">{{ $spreadcategory->model_number }}</td>
                        <td class="text-left">{{ $spreadcategory->id }}</td>
                        <td class="text-left">{{ $spreadcategory->class_system }}</td>
                        <td class="text-left">@if($spreadcategory->containerized_system == 'yes') W = {{ $spreadcategory->size }} m, L = {{$spreadcategory->dimension}} m,  H = {{$spreadcategory->height}} m @else D = {{ $spreadcategory->size }} m @endif</td>
                        <td class="text-left">@if($spreadcategory->containerized_system == 'yes') {{$spreadcategory->container_number}} @endif</td>
                        <td class="text-left">@if($spreadcategory->containerized_system == 'no') {{$spreadcategory->container_number}} @endif</td>
                        <td class="text-left">{{$spreadcategory->weight}}</td>
                        <td class="text-left">{{$spreadcategory->manufacture_date}}</td>
                        <td class="text-left">{{$spreadcategory->purchased_date}}</td>
                        <td class="text-left"><span class="btn btn-sm @if($spreadcategory->status == 'Certified') btn-success 
                                @elseif($spreadcategory->status == 'Expiring') btn-warning 
                                @elseif($spreadcategory->status == 'Expired') btn-danger 
                                @elseif($spreadcategory->status == 'Incomplete') btn-secondary @endif">{{ $spreadcategory->status }}</span></td>
                        <td class="text-left">
                            @can('edit system')
                            <a href="{{ route('edit-spreadcategory', $spreadcategory->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('transfer system')
                            <a title="Transfer System" class="btn btn-sm btn-outline-info hide-read-only" href="{{ route('transfer-system', $spreadcategory->id) }}">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                            @endcan
                            @can('delete system')
                            <a href="{{ route('delete-spreadcategory', $spreadcategory->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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
        {{-- {{$data->links()}} --}}
    </div>

</div>
<!-- / Content -->


@push('scripts')
<script>
    $('#spreadcategory_table').DataTable({
        pageLength: 10
    });
</script>
@endpush

@endsection