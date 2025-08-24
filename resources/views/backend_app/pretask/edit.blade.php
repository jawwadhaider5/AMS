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
                <h1 class="m-0">Edit Predefined Task</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Pre Defined Tasks</a></li>
                    <li class="breadcrumb-item active">Update</li>
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

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif


            <form method="POST" action="{{route('update-pretask' , $tasktype->id )}}" id="newform">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-12">
                        <label for="">Sheet Number</label>
                        <input value="{{ $tasktype->name }}" type="text" class="form-control" name="sheet_number" id="">
                    </div>
                    <div class="col-md-9">
                        <div id="dynamic-fields">
                            @php
                            $componentIndex = 0;
                            @endphp

                            @foreach($tasktype->predefinedtasks as $pre)
                            @php
                            $componentIndex++;
                            @endphp  

                            <div class="row" id="component-{{$componentIndex}}">
                                <div class="col-md-12">
                                    <div class="input-group my-2" >   
                                        <input type="hidden" value="{{ $pre->id }}" name="component[{{$componentIndex}}][pretask_id]">
                                        <input type="hidden" class="form-control" name="component[{{$componentIndex}}][edit]" value="1">
                                        <input type="text" value="{{ $pre->name }}" class="form-control" name="component[{{$componentIndex}}][name]" placeholder="Enter Task Name">
                                        <input type="text" value="{{ $pre->description }}" class="form-control" name="component[{{$componentIndex}}][description]" placeholder="Enter Task Description">
                                        <input type="text" value="{{ $pre->frequency }}" class="form-control" name="component[{{$componentIndex}}][frequency]" placeholder="Enter Task Frequency"> 
                                        <select class="form-control" name="component[{{$componentIndex}}][month_year]" required>
                                            <option value="">Select Option</option>
                                            <option value="month" @if($pre->month_year == "month") selected @endif>Months</option>
                                            <option value="year" @if($pre->month_year == "year") selected @endif>Years</option>
                                        </select>
                                        <button type="button" class="btn btn-danger ml-2 remove-component" data-id="{{$componentIndex}}"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div> 
                            </div>


                            @endforeach
                            <input type="hidden" value="{{ $componentIndex }}" id="componentIndex">
                        </div>
                        <a id="add-field" class="btn btn-sm btn-info my-2" title="Add Predefined Task"><i class="fa fa-plus"></i> Predefined Task</a>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 float-end">Update</button>

            </form>
        </div>

    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function() {
  
        $('#newform').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        let componentIndex = 0;

        function addComponent() {
            componentIndex = parseInt($("#componentIndex").val()) + 1;
            let componentHTML = `
                            <div class="row" id="component-${componentIndex}">
                                <div class="col-md-12">
                                    <div class="input-group my-2" >   
                                        <input type="hidden" class="form-control" name="component[${componentIndex}][edit]" value="0">
                                        <input type="text" class="form-control" name="component[${componentIndex}][name]" placeholder="Enter Task Name">
                                        <input type="text" class="form-control" name="component[${componentIndex}][description]" placeholder="Enter Task Description">
                                        <input type="text" class="form-control" name="component[${componentIndex}][frequency]" placeholder="Enter Task Frequency"> 
                                        <select class="form-control"  name="component[${componentIndex}][month_year]" required>
                                            <option value="">Select Option</option>
                                            <option value="month">Months</option>
                                            <option value="year">Years</option>
                                        </select>
                                        <button type="button" class="btn btn-danger ml-2 remove-component" data-id="${componentIndex}"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div> 
                            </div>`;
            $('#dynamic-fields').append(componentHTML);
            $("#componentIndex").val(parseInt($("#componentIndex").val()) + 1)
        }



        $(document).on('click', '#add-field', function() {
            addComponent();
        });



        $(document).on('click', '.remove-component', function() {
            let componentId = $(this).data('id');
            $(`#component-${componentId}`).remove();
        });

    });
</script>

@endpush

@endsection