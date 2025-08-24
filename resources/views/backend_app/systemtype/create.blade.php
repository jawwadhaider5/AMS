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
                <h1 class="m-0">Add New IMCA Audit Type</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">IMCA Audit Type</a></li>
                    <li class="breadcrumb-item active">Add New</li>
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

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif
            <form action="{{ route('store-systemtype')}}" method="POST" id="newform">
                @csrf
                <div class="row">
                    <div class="container-fluid">
                        <label for="">IMCA Audit Type</label>
                        <input value="{{ old('name') }}" type="text" class="form-control col-md-4" name="system_type" id="">

                        <div id="dynamic-fields"></div>
                        <a id="add-field" class="btn btn-sm btn-info my-2" title="Add Component"><i class="fa fa-plus"></i> Inspection Requirements </a>
 
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
                    if (response.success == 1) {
                        window.location = "/systemtype/all";
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

        let componentIndex = 0;
        let subComponentIndex = 0;
        var sheets = <?php echo json_encode($sheets); ?>

        var sheet_no = '';
        sheets.forEach(ele => {
            sheet_no = sheet_no + '<option value="' + ele.id + '">' + ele.name + '</option>';
        });

        function addComponent() {
            componentIndex++;

            let componentHTML = `
                   <div class="row" id="component-${componentIndex}">
                    <div class="col-md-4">
                        <div class="input-group my-2" >
                            <input type="text" class="form-control" name="component[${componentIndex}][id]" placeholder="ID">
                            <input type="text" class="form-control w-75" name="component[${componentIndex}][name]" placeholder="Inspection Requirments">
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
        }

        function addSubComponent(componentId) {
            subComponentIndex++;

            let subComponentHTML = `
                    <div class="input-group mb-2" id="sub-component-${componentId}-${subComponentIndex}">
                        <input type="text" class="form-control" style="width: 5%;" name="component[${componentId}][sub-component][${subComponentIndex}][id]" placeholder="ID">
                        <input type="text" class="form-control" style="width: 30%;" name="component[${componentId}][sub-component][${subComponentIndex}][name]" placeholder="Inspection"> 
                        <select class="form-control select2" multiple="multiple" data-placeholder="Select Sheets" data-dropdown-css-class="select2-primary" 
                        style="width: 60%;" name="component[${componentId}][sub-component][${subComponentIndex}][sheet_number][]" required>
                            <option value="">Select Sheet Number</option>
                            ${sheet_no}
                        </select>
                        <button type="button" class="btn btn-sm btn-danger ml-2 remove-sub-component" data-id="${componentId}-${subComponentIndex}"><i class="fa fa-minus"></i></button>
                    </div>
                `;
            $(`#sub-components-${componentId}`).append(subComponentHTML);

            $('.select2').select2()
 

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

        $('#newform').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

    });
</script>

@endpush
@endsection