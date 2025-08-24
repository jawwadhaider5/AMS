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
        <h1 class="m-0">All Projects</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Project</a></li>
          <li class="breadcrumb-item active">All</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">


  <!-- </div> -->
  @can('create project')
  <div class="row">
    <div class="col-12">
      <div class="dropdown float-end">
      </div>
      <a href="{{route('add-project')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Project +</a>

    </div>
  </div>
  @endcan
  <div class="row">
    <div class="col-12">

      <div class="card">

        @can('all project')
        <div class="table-responsive text-nowrap">

          <table class="table" id="all_projects_table">
            <thead>
              <tr class="text-nowrap">
                <th>Status</th>
                <th>Location</th>
                <th>Project Name</th>
                <th>Client Name </th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Equipment</th>
                <th>Actions</th>
              </tr>
            <tbody id="table-body">

              @foreach ($allprojects as $project)
              <tr>
                <td>
                  <span class="btn btn-sm btn-warning">Not Started</span>
                </td>
                <td>{{$project->locationdata ? $project->locationdata->name : ''}}</td>
                <td>{{$project->project_name}}</td>
                <td>{{$project->client_name}}</td>
                <td><a class="btn btn-sm btn-primary start_project" data-pid="{{$project->id}}">Start Now</a></td>
                <td>{{$project->end_date}}</td>
                <td>@foreach ($project->assets as $asset) {{$asset->description}}, @endforeach</td>
                <td>
                  @can('edit project')
                  <a href="{{ route('edit-project', $project->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  @endcan
                  @can('delete project')
                  <a href="{{ route('delete-project', $project->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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


      <div class="card">

        @can('all project')
        <div class="table-responsive text-nowrap">

          <table class="table" id="live_projects_table">
            <thead>
              <tr class="text-nowrap">
                <th>Status</th>
                <th>Location</th>
                <th>Project Name</th>
                <th>Client Name </th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Equipment</th>
                <th>Actions</th>
              </tr>
            <tbody id="table-body">

              @foreach ($liveprojects as $project)
              <tr>
                <td>
                  <span class="btn btn-sm btn-success">Live</span>
                </td>
                <td>{{$project->locationdata ? $project->locationdata->name : ''}}</td>
                <td>{{$project->project_name}}</td>
                <td>{{$project->client_name}}</td>
                <td>{{$project->start_date}}</td>
                <td><a class="btn btn-sm btn-danger close_project" data-pid="{{$project->id}}">Close Now</a></td>
                <td>@foreach ($project->assets as $asset) {{$asset->description}}, @endforeach</td>
                <td>
                  @can('edit project')
                  <a href="{{ route('edit-project', $project->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  @endcan
                  @can('delete project')
                  <a href="{{ route('delete-project', $project->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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
    <div class="col-12">
      <div class="card">

        <div class="table-responsive text-nowrap">


          <table class="table" id="closed_projects_table">
            <thead>
              <tr class="text-nowrap">
                <th>Status</th>
                <th>Location</th>
                <th>Project Name</th>
                <th>Client Name </th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Equipment</th>
                <th>Actions</th>
              </tr>
            <tbody id="table-body">

              @foreach ($closedprojects as $project)
              <tr>
                <td>
                  <span class="btn btn-sm btn-danger">Closed</span>
                </td>
                <td>{{$project->locationdata ? $project->locationdata->name : ''}}</td>
                <td>{{$project->project_name}}</td>
                <td>{{$project->client_name}}</td>
                <td>{{$project->start_date}}</td>
                <td>{{$project->end_date}}</td>
                <td>{{$project->project_name}}</td>
                <td>
                  <a href="{{ route('edit-project', $project->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <!-- <a href="{{ route('edit-project', $project->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                          <i class="fa fa-download"> Export</i>
                          </a> -->
                  <a href="{{ route('delete-project', $project->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>

              </tr>
              @endforeach
            </tbody>
            </thead>
          </table>
        </div>
      </div>
      <div id="paginationContainer" class="float-end mt-3">

      </div>
    </div>
  </div>
</div>
<!-- include('backend_app.layouts.footer')

    <div class="content-backdrop fade"></div>
  </div>

</div> -->

@push('scripts')
<script>
  $('#all_projects_table').DataTable({
    pageLength: 10
  });


  $('#live_projects_table').DataTable({
    pageLength: 10
  });

  $('#closed_projects_table').DataTable({
    pageLength: 10
  });



  $(".start_project").on('click', function() { 
    var pid = $(this).data("pid") 
    console.log(pid);
    
    $.ajax({
      url: '/project/start/' + pid,
      type: "GET", 
      success: function(data) { 
        console.log("started"); 
        location.reload();
      }
    }); 
  })

  $(".close_project").on('click', function() { 
    var pid = $(this).data("pid") 
    $.ajax({
      url: '/project/close/' + pid,
      type: "GET", 
      success: function(data) { 
        console.log("closed"); 
        location.reload();
      }
    }); 
  })


</script>
@endpush

@endsection