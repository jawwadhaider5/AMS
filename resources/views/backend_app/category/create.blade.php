@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">
   include('backend_app.layouts.nav') 
  <div class="content-wrapper">  -->

  @section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!--<h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>-->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inspection Requirements</a></li>
                    <li class="breadcrumb-item active">Add New</li>
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

            
          <form action="{{route('store-category')}}" method="POST">
            @csrf

            <div class="row">
              <div class="col-lg-6 col-sm-12 col-md-6">
                <label for="">IMCA Audit Type</label>
                <select name="parent_cat_id" class="form-select" id="spread_id">
                  <option value="">Select IMCA Audit Type</option>
                  @foreach ($systemtypes as $systemtype)
                  <option value="{{$systemtype->id}}">{{$systemtype->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-6 col-sm-12 col-md-6">
                <label for="">Name</label>
                <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

              </div>
              <div class="col-lg-6 col-sm-12 col-md-6">
                <label for="">Description</label>
                <input value="{{ old('description') }}" type="text" class="form-control" name="description" id="">

              </div>




            </div>



            <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

          </form>

          
        </div>
        <div>
        <br>
          <hr>
          <br>

          <table class="table table-bordered" id="components_table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              @foreach($components as $com)
              <tr>
                <td>{{$com->id}}</td>
                <td>{{$com->name}}</td>
                <td>{{$com->description}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <!-- include('backend_app.layouts.footer') 
    <div class="content-backdrop fade"></div>
  </div> 
</div> -->
 
<script>
  $(document).ready(function() {  

    $('#spread_id').on('change', function() {
        systemtypeId = $(this).val();  
        $('#components_table tbody').html('');

        $.ajax({
            url: '/categories-change',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', 
                systemtype_id: systemtypeId
            },
            success: function(res) {  
                res.categories.forEach(ele => { 
                  var tr = '<tr><td>'+ele.id+'</td><td>'+ele.name+'</td> <td>'+ele.description+'</td></tr>';
                  $('#components_table tbody').append(tr);
                }); 
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        }); 
    });
  })
    </script>

@endsection