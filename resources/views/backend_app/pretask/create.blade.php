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
                <h1 class="m-0">Add Predefined Task</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Predefined Task</a></li>
                    <li class="breadcrumb-item active">Add New</li>
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
            <form action="{{ route('store-pretask')}}" method="POST" id="newform">
                @csrf
                <div class="row">
                    <!-- <div class="col-lg-3 col-sm-12 col-md-3 mt-3 mt-3">
                        <label for="">Spread Type</label>
                        <select name="system_type" class="form-select" id="system">
                            <option value="">Select Spread Type</option>
                            @foreach ($data['systemtypes'] as $systemtype)
                            <option value="{{$systemtype->id}}"> {{$systemtype->name}}</option>
                            @endforeach
                        </select>
                    </div> -->

                    <div class="col-lg-12 col-sm-12 col-md-12 mt-3 mt-3">
                        <label for="">Sheet Number</label>
                        <div id="dynamic-fields"></div>
                        <a id="add-field" class="btn btn-sm btn-info my-2" title="Add Sheet"><i class="fa fa-plus"></i> Sheet</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>
            </form>

        </div>
    </div>



</div>
<!-- / Content -->



@push('scripts')
<script>
    $(document).ready(function() {


        $('#newform').on('submit', function(event) {
            event.preventDefault();  
 
            const url = $(this).attr('action');
            const formData = $(this).serialize();
 
            $.ajax({
                type: 'POST',
                url: url,  
                data: formData,
                success: function(response) { 
                    console.log(response); 
                    if (response.success == 1) {
                        window.location = "/pretask/all";  
                    } else {
                        alert("something went wrong!")
                    }
                },
                error: function(res) { 
                    alert(res.responseJSON.message)
                    console.log(res);
                }
            });
        });


        $('#newform').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        let componentIndex = 0;
        let subComponentIndex = 0;

        // $('#system').on('change', function() {

        //     for (let index = 0; index <= componentIndex; index++) {
        //         $(`#component-${index}`).remove();
        //         $(`#sub-components-${index}`).remove();
        //         $(`#sub-components-btn-${index}`).remove();
        //     }

        // });




        function addComponent() {
            componentIndex++;

            // systemtypeId = $("#system").val();

            // if (systemtypeId == null || systemtypeId == '') {
            //     alert("Select System Type First")
            // } else {

            // var sheet_no = '';
            // $.ajax({
            //     url: '/imca-change',
            //     method: 'POST',
            //     data: {
            //         _token: '{{ csrf_token() }}',
            //         systemtype_id: systemtypeId
            //     },


            //     success: function(res) {
            //         console.log(res);

            //         res.subcategories.forEach(ele => {
            //             sheet_no = sheet_no + '<option value="' + ele.id + '">' + ele.sheet_number + ' - ' + ele.name + '</option>';
            //         });

            let componentHTML = `
                            <div class="row" id="component-${componentIndex}">
                                <div class="col-md-4">
                                    <div class="input-group my-2" >   
                                        <input type="text" class="form-control" name="component[${componentIndex}][sheet_number]" placeholder="Enter Sheet Number">
                                        <button type="button" class="btn btn-danger ml-2 remove-component" data-id="${componentIndex}"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group my-2">
                                        <div class="sub-components w-100" id="sub-components-${componentIndex}"></div> 
                                    </div>
                                    <button type="button" id="sub-components-btn-${componentIndex}" class="btn btn-sm btn-info ml-2 add-sub-component" data-id="${componentIndex}"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>`;
            $('#dynamic-fields').append(componentHTML);


            //     },
            //     error: function(xhr, status, error) {
            //         console.error('AJAX Error:', error);
            //     }
            // });


            // }


        }

        function addSubComponent(componentId) {
            subComponentIndex++;
            let subComponentHTML = `
                    <div class="input-group mb-2" id="sub-component-${componentId}-${subComponentIndex}">
                        <input type="text" class="form-control" style="width: 25%;" name="component[${componentId}][sub-component][${subComponentIndex}][task_name]" placeholder="Task Name">
                        <input type="text" class="form-control" style="width: 45%;" name="component[${componentId}][sub-component][${subComponentIndex}][task_description]" placeholder="Description">
                        <input type="text" class="form-control" style="width: 12%;" name="component[${componentId}][sub-component][${subComponentIndex}][task_frequency]" placeholder="Frequency">
                        <select class="form-control" style="width: 13%;" name="component[${componentId}][sub-component][${subComponentIndex}][month_year]" required>
                            <option value="">Select Option</option>
                            <option value="month">Months</option>
                            <option value="year">Years</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-danger ml-2 remove-sub-component" data-id="${componentId}-${subComponentIndex}"><i class="fa fa-minus"></i></button>
                    </div>
                `;
            $(`#sub-components-${componentId}`).append(subComponentHTML);
        }

        $(document).on('click', '#add-field', function() {
            addComponent();
        });

        $(document).on('click', '.add-sub-component', function() {
            let componentId = $(this).data('id');
            addSubComponent(componentId);
        });

        $(document).on('click', '.remove-component', function() {
            let componentId = $(this).data('id');
            $(`#component-${componentId}`).remove();
            $(`#sub-components-${componentId}`).remove();
            $(`#sub-components-btn-${componentId}`).remove();
        });

        $(document).on('click', '.remove-sub-component', function() {
            let id = $(this).data('id');
            $(`#sub-component-${id}`).remove();
        });
    });
</script>

@endpush
@endsection