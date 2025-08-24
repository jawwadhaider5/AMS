@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
    @include('backend_app.layouts.nav') 
    <div class="content-wrapper"> -->
<!-- Content -->

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Role</a></li>
                    <li class="breadcrumb-item active">Permissions</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 text-capitalize">Role : {{ $role->name }}</h4>
    <p>All Permissions are listed below:</p>


    <!-- DataTable with Buttons -->
    <div class="card p-2">
        <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 p-4">
                    <h4>Dashboard Permissions</h4>
                    <div class="form-check">
                        <input id="c1" class="form-check-input" name="permissions[]" type="checkbox" value="view dashboard" id="c1" {{ in_array('view dashboard', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c1">
                            View Dashboard
                        </label>
                    </div>
                </div>
                <div class="col-md-4 p-4">
                    <h4>Spreads Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all spread" id="c1" {{ in_array('all spread', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c2">
                            All Spread
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view spread" id="c1" {{ in_array('view spread', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c3">
                            View Spread
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create spread" id="c1" {{ in_array('create spread', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c4">
                            Create Spread
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit spread" id="c1" {{ in_array('edit spread', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c5">
                            Edit Spread
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete spread" id="c1" {{ in_array('delete spread', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c5">
                            Delete Spread
                        </label>
                    </div>
                </div>
                <div class="col-md-4 p-4">
                    <h4>Systems Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all system" id="c1" {{ in_array('all system', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c7">
                            All System
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view system" id="c1" {{ in_array('view system', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c8">
                            View System
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create system" id="c1" {{ in_array('create system', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c9">
                            Create System
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit system" id="c1" {{ in_array('edit system', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c10">
                            Edit System
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete system" id="c1" {{ in_array('delete system', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c11">
                            Delete System
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="transfer system" id="c1" {{ in_array('transfer system', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label" for="c6">
                            Transfer System
                        </label>
                    </div>
                </div>
                <div class="col-md-4 p-4">
                    <h4> Inspection Requirments Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all component" id="c1" {{ in_array('all component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Inspection Requirments 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view component" id="c1" {{ in_array('view component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Inspection Requirments 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create component" id="c1" {{ in_array('create component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Inspection Requirments 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit component" id="c1" {{ in_array('edit component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Inspection Requirments 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete component" id="c1" {{ in_array('delete component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Inspection Requirments 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="transfer component" id="c1" {{ in_array('transfer component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Transfer Inspection Requirments 
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4> Inspection Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all sub component" id="c1" {{ in_array('all sub component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Inspection
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view sub component" id="c1" {{ in_array('view sub component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Inspection
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create sub component" id="c1" {{ in_array('create sub component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Inspection
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit sub component" id="c1" {{ in_array('edit sub component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Inspection
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete sub component" id="c1" {{ in_array('delete sub component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Inspection
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="transfer sub component" id="c1" {{ in_array('transfer sub component', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Transfer Inspection
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Assets Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all asset" id="c1" {{ in_array('all asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Assets
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view asset" id="c1" {{ in_array('view asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Asset
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create asset" id="c1" {{ in_array('create asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Asset
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit asset" id="c1" {{ in_array('edit asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Asset
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete asset" id="c1" {{ in_array('delete asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Asset
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="transfer asset" id="c1" {{ in_array('transfer asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Transfer Asset
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="assign asset" id="c1" {{ in_array('assign asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Assign Asset
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="unassign asset" id="c1" {{ in_array('unassign asset', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Unassign Asset
                        </label>
                    </div>
                </div>
 


                <div class="col-md-4 p-4">
                    <h4>Qurantines Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all qurantine" id="c1" {{ in_array('all qurantine', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Qurantines
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view qurantine" id="c1" {{ in_array('view qurantine', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Qurantine
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create qurantine" id="c1" {{ in_array('create qurantine', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Qurantine
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit qurantine" id="c1" {{ in_array('edit qurantine', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Qurantine
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete qurantine" id="c1" {{ in_array('delete qurantine', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Qurantine
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Maintenance Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all maintenance" id="c1" {{ in_array('all maintenance', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Maintenance
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view maintenance" id="c1" {{ in_array('view maintenance', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Maintenance
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create maintenance" id="c1" {{ in_array('create maintenance', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Maintenance
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit maintenance" id="c1" {{ in_array('edit maintenance', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Maintenance
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete maintenance" id="c1" {{ in_array('delete maintenance', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Maintenance
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Spares Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all spare" id="c1" {{ in_array('all spare', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Spares
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view spare" id="c1" {{ in_array('view spare', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Spare
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create spare" id="c1" {{ in_array('create spare', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Spare
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit spare" id="c1" {{ in_array('edit spare', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Spare
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete spare" id="c1" {{ in_array('delete spare', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Spare
                        </label>
                    </div>
                </div>


                <div class="col-md-4 p-4">
                    <h4>Locations Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all location" id="c1" {{ in_array('all location', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Locations
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view location" id="c1" {{ in_array('view location', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View location
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create location" id="c1" {{ in_array('create location', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create location
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit location" id="c1" {{ in_array('edit location', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit location
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete location" id="c1" {{ in_array('delete location', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete location
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Projects Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all project" id="c1" {{ in_array('all project', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Projects
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view project" id="c1" {{ in_array('view project', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Project
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create project" id="c1" {{ in_array('create project', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Project
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit project" id="c1" {{ in_array('edit project', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Project
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete project" id="c1" {{ in_array('delete project', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Project
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Spread Types Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all spread type" id="c1" {{ in_array('all spread type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All IMCA Audit Type
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create spread type" id="c1" {{ in_array('create spread type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create IMCA Audit Type
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit spread type" id="c1" {{ in_array('edit spread type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit IMCA Audit Type
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete spread type" id="c1" {{ in_array('delete spread type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete IMCA Audit Type
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Task Types Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all task type" id="c1" {{ in_array('all task type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Task Types
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view task type" id="c1" {{ in_array('view task type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Task Type
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create task type" id="c1" {{ in_array('create task type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Task Type
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit task type" id="c1" {{ in_array('edit task type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Task Type
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete task type" id="c1" {{ in_array('delete task type', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Task Type
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Pre Defined Tasks Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all pre define task" id="c1" {{ in_array('all pre define task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Pre Defined Tasks
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view pre define task" id="c1" {{ in_array('view pre define task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Pre Defined Task
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create pre define task" id="c1" {{ in_array('create pre define task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Pre Defined Task
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit pre define task" id="c1" {{ in_array('edit pre define task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Pre Defined Task
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete pre define task" id="c1" {{ in_array('delete pre define task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Pre Defined Task
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Tasks Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all task" id="c1" {{ in_array('all task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Tasks
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view task" id="c1" {{ in_array('view task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Task
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create task" id="c1" {{ in_array('create task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Task
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit task" id="c1" {{ in_array('edit task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit Task
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete task" id="c1" {{ in_array('delete task', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Task
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>IMCA References Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all imca reference" id="c1" {{ in_array('all imca reference', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All IMCA References
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view imca reference" id="c1" {{ in_array('view imca reference', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View IMCA Reference
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create imca reference" id="c1" {{ in_array('create imca reference', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create IMCA Reference
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="edit imca reference" id="c1" {{ in_array('edit imca reference', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Edit IMCA Reference
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete imca reference" id="c1" {{ in_array('delete imca reference', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete IMCA Reference
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Roles Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="roles and permission" id="c1" {{ in_array('roles and permission', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Roles and Permission
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all role" id="c1" {{ in_array('all role', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Roles
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view role" id="c1" {{ in_array('view role', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Role
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create role" id="c1" {{ in_array('create role', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Role
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="update role" id="c1" {{ in_array('update role', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Update Role
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete role" id="c1" {{ in_array('delete role', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Role
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Permissions Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all permission" id="c1" {{ in_array('all permission', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Permissions
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view permission" id="c1" {{ in_array('view permission', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View Permission
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create permission" id="c1" {{ in_array('create permission', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create Permission
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="update permission" id="c1" {{ in_array('update permission', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Update Permission
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete permission" id="c1" {{ in_array('delete permission', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete Permission
                        </label>
                    </div>
                </div>
                <div class="col-md-4 p-4">
                    <h4>Users Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="all user" id="c1" {{ in_array('all user', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            All Users
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="view user" id="c1" {{ in_array('view user', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            View User
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="create user" id="c1" {{ in_array('create user', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Create User
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="update user" id="c1" {{ in_array('update user', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Update User
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="delete user" id="c1" {{ in_array('delete user', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Delete User
                        </label>
                    </div>
                </div>

                <div class="col-md-4 p-4">
                    <h4>Other Permissions</h4>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="advance" id="c1" {{ in_array('advance', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Advance
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="actions" id="c1" {{ in_array('actions', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Actions
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="permissions[]" type="checkbox" value="setting" id="c1" {{ in_array('setting', $rolePermissions) ? 'checked':'' }}>
                        <label class="form-check-label">
                            Setting
                        </label>
                    </div>
                </div>

            </div>

            <div class="mb-3 mt-3 float-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>



    <!-- Modal to add new record -->

    <!--/ DataTable with Buttons -->


</div>

<!-- </div> 
    include('backend_app.layouts.footer') 
    <div class="content-backdrop fade"></div>
</div> 
</div> -->

@endsection