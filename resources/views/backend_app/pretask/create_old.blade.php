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
                    <li class="breadcrumb-item"><a href="#">Pre Defined Tasks</a></li>
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


            <form action="{{ route('store-pretask')}}" method="POST" id="newform">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Spread Type</label>
                        <select name="system_type" class="form-select" id="system">
                            <option value="">Select Spread Type</option>
                            @foreach ($data['systemtypes'] as $systemtype)
                            <option value="{{$systemtype->id}}"> {{$systemtype->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Components</label>
                        <select name="category" class="form-select" id="component">
                            <option value="">Select Components</option>
                            @foreach ($data['categories'] as $category)
                            <option value="{{$category->id}}"> {{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Sub Components</label>
                        <select name="sub_category_id" class="form-select" id="subcomponent">
                            <option value="">Select Sub-Components</option>
                            @foreach ($data['subcategories'] as $subcategory)
                            <option value="{{$subcategory->id}}"> {{$subcategory->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Task Type </label>
                        <select name="task_type" class="form-select" id="">
                            <option value="">Select Task Type</option>
                            @foreach ($data['tasktypes'] as $tasktype)
                            <option value="{{$tasktype->id}}"> {{$tasktype->name}}</option>
                            @endforeach
                        </select>
                    </div>

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


<script>
    $(document).ready(function() {

        $('#newform').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#system').on('change', function() {
            systemtypeId = $(this).val();

            $('#component').html('<option value="">Select Component</option>');
            $('#subcomponent').html('<option value="">Select Sub Component</option>');

            $.ajax({
                url: '/categories-change',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    systemtype_id: systemtypeId
                },
                success: function(res) {

                    console.log(res);

                    res.categories.forEach(ele => {
                        $('#component').append('<option value="' + ele.id + '">' + ele.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });


        $('#component').change(function() {
            var category_id = $(this).val();

            if (category_id) {
                $.ajax({
                    url: '/get-subcategories/' + category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('#subcomponent').empty();
                        $('#subcomponent').append('<option value="">Select Sub Component</option>');
                        $.each(data, function(key, value) {
                            $('#subcomponent').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#subcomponent').empty();
                $('#subcomponent').append('<option value="">Select Sub Component</option>');
            }
        });


    })
</script>


@endsection