@extends('backend_app.layouts.template')
@section('content')


@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IMCA Audit Type</h1>
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



    <div class="card">
        <div class="card-datatable table-responsive p-4">

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif
            <form action="{{route('update-systemtype' , $systemtype->id )}}" method="POST" id="newform">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="container">
                        <label for="">Spread type Name</label>
                        <input value="{{ $systemtype->name }}" type="text" class="form-control col-md-4" name="system_type" id="">

                        <div id="dynamic-fields">


                            @php

                            $componentIndex = 0;
                            $subComponentIndex = 0;

                            @endphp

                            @foreach($systemtype->categories as $cat)
                            @php
                            $componentIndex++;
                            @endphp

                            <div class="row" id="component-{{$componentIndex}}">
                                <div class="col-md-4">
                                    <div class="input-group my-2">
                                        <input type="hidden" value="{{ $cat->id }}" name="component[{{$componentIndex}}][component_id]">
                                        <input type="hidden" value="1" name="component[{{$componentIndex}}][edit]">
                                        <input type="text" value="{{ $cat->display_id }}" class="form-control" name="component[{{$componentIndex}}][id]" placeholder="ID">
                                        <input type="text" value="{{ $cat->name }}" class="form-control w-75" name="component[{{$componentIndex}}][name]" placeholder="Inspection Requirement">
                                        <button type="button" class="btn btn-danger ml-2 remove-component" data-id="{{$componentIndex}}"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group my-2">
                                        <div class="sub-components w-100" id="sub-components-{{$componentIndex}}">

                                            @foreach($cat->subcategories as $subcat)
                                            @php
                                                $subComponentIndex++;
                                            @endphp
                                            <div class="input-group mb-2" id="sub-component-{{$componentIndex}}-{{$subComponentIndex}}">
                                                <input type="hidden" value="{{ $subcat->id }}" name="component[{{$componentIndex}}][sub-component][{{$subComponentIndex}}][sub_component_id]">
                                                <input type="hidden" value="1" name="component[{{$componentIndex}}][sub-component][{{$subComponentIndex}}][edit]">
                                                <input type="text" value="{{ $subcat->display_id }}" class="form-control" style="width: 5%;" name="component[{{$componentIndex}}][sub-component][{{$subComponentIndex}}][id]" placeholder="ID">
                                                <input type="text" value="{{ $subcat->name }}" class="form-control" style="width: 30%;" name="component[{{$componentIndex}}][sub-component][{{$subComponentIndex}}][name]" placeholder="Inspection">
                                                <select  class="form-control select2" multiple="multiple" data-placeholder="Select Sheets" data-dropdown-css-class="select2-primary" 
                                                value="" style="width: 60%;" name="component[{{$componentIndex}}][sub-component][{{$subComponentIndex}}][sheet_number][]" required>
                                                    <option value="">Select Sheet Number</option>
                                                    @foreach($sheets as $sheet)
                                                    <option value="{{$sheet->id}}" {{ in_array($sheet->id, $subcat->selectedSheets) ? 'selected' : ''}}>{{$sheet->name}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-danger ml-2 remove-sub-component" data-id="{{$componentIndex}}-{{$subComponentIndex}}"><i class="fa fa-minus"></i></button>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <button type="button" id="sub-components-btn-{{$componentIndex}}" class="btn btn-sm btn-info ml-2 add-sub-component" data-id="{{$componentIndex}}"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            <input type="hidden" value="{{ $componentIndex }}" id="componentIndex">
                            <input type="hidden" value="{{ $subComponentIndex }}" id="subComponentIndex">
                        </div>
                        <a id="add-field" class="btn btn-sm btn-info my-2" title="Add Component"><i class="fa fa-plus"></i> Inspection Requirements</a>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 float-end">Update</button>
            </form>

        </div>
    </div>



</div>
<!-- / Content -->



@push('scripts')
<script>
    $(document).ready(function() {


        $('.select2').select2()

        $('#newform').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        
        // let componentIndex = 0;
        // let subComponentIndex = 0;
        var sheets = <?php echo json_encode($sheets); ?>

        var sheet_no = '';
        sheets.forEach(ele => {
            sheet_no = sheet_no + '<option value="' + ele.id + '">' + ele.name + '</option>';
        });

        function addComponent() {
            componentIndex = parseInt($("#componentIndex").val()) + 1;

            let componentHTML = `<div class="row" id="component-${componentIndex}">
                    <div class="col-md-4">
                        <div class="input-group my-2" >
                            <input type="hidden" class="form-control" name="component[${componentIndex}][edit]" value="0">
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
            $("#componentIndex").val(componentIndex)
        }

        function addSubComponent(componentId) {
            // subComponentIndex++;
            subComponentIndex = parseInt($("#subComponentIndex").val()) + 1;

            console.log(componentId);
            console.log(subComponentIndex);



            let subComponentHTML = `
                    <div class="input-group mb-2" id="sub-component-${componentId}-${subComponentIndex}">
                        <input type="hidden" class="form-control" name="component[${componentId}][sub-component][${subComponentIndex}][edit]" value="0">
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
            $("#subComponentIndex").val(subComponentIndex)
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
    });
</script>

@endpush
@endsection