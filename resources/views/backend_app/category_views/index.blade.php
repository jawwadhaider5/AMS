@extends('backend_app.layouts.template')
@section('content')

<div class="layout-page">
    <!-- Navbar -->
    @include('backend_app.layouts.nav')

    <!-- / Navbar -->

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Category View /</span> All</h4>

        <div class="row mb-3">
            <div class="col-12">
                 <div class="card p-3">
                <div class="card-title">Filters</div>
                <form action="#" id="dealer_form" method="POST">
                    @csrf
                <div class="">
                <div class="d-flex flex-wrap flex-row">



                    <div class="input-group mb-3 w-25 me-2">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search   </button>
                      </div>
                      <div class="input-group mb-3 w-25">
                        <label class="input-group-text" for="inputGroupSelect01">Show</label>
                        <select class="form-select" id="inputGroupSelect01">
                          <option selected>Choose...</option>
                          <option value="1">Active</option>
                          <option value="2">Unactive</option>

                        </select>
                      </div>
                </div>
            </form>

                </div>
                </div>
            </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="dropdown float-end">
                    <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Actions
                    </button>

                    <ul class="dropdown-menu" style="">
                        <li><a data-bs-toggle="modal" data-bs-target="#exampleModal_2" class="dropdown-item" href="https://crm.khybercity.com.pk/export-files/pdf">Assign Project</a></li>
                      <li><a class="dropdown-item" href="https://crm.khybercity.com.pk/export-files/pdf">Refresh</a></li>
                      <li><a class="dropdown-item" href="https://crm.khybercity.com.pk/export-files/excel" id="delete_all">Export Excel</a></li>

                    </ul>
                  </div>
                  <a href="{{route('categoryview-add')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Record +</a>


            </div>
        </div>

        <div class="modal fade" id="exampleModal_2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Project Assign</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                            <label for="">Assign Project</label>
                            <select name="" class="form-select" id="">
                                <option value="">Choose</option>
                                <option value="">Project 1</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                            <label for="">Start Date</label>
                            <input class="form-control" type="date" readonly value="1154.4584">
                        </div>




                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        {{-- <div class="card p-3 mb-3">
            <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-6">

            <label for="">Search Customers</label>
            <input type="text" id="searchInput" placeholder="Search Customers" class="form-control mt-2">

        </div>
        </div>
        </div> --}}
        <!-- DataTable with Buttons -->
        <div class="card">

            <div class="table-responsive text-nowrap">
                {{-- <a href="{{route('add-files')}}" class="btn btn-primary float-end mt-3 mx-3">Add New File</a> --}}
                <table class="table">
                  <thead>
                    <tr class="text-nowrap">
                        <td><input type="checkbox" name="items[]"></td>
                        <th>Asset ID </th>
                        <th>Description </th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Serial No.</th>
                        <th>Location</th>
                        <th>Safety Critical</th>
                        <th>Nde own Or Not</th>
                        <th>Project </th>
                        <th>Class?</th>
                        <th>Class Code</th>
                        <th>Actions</th>

                    </tr>
                    <tbody id="table-body">
                    {{-- @foreach ($data as $item) --}}
                    <tr>
                        <td><input type="checkbox" name="items[]"></td>
                        <td><a href="{{route('show-categoryview',['id'=>1])}}">124120</a></td>
                        <td>BTEA</td>
                        <td>194AD</td>
                        <td>""</td>
                        <td>""</td>
                        <td>""</td>
                        <td>""</td>
                        <td>""</td>
                        <td>""</td>
                        <td>""</td>
                        <td>  <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                ><i class="ti ti-pencil me-1"></i> Edit</a
                              >
                              <a class="dropdown-item"  href="#"
                                ><i class="ti ti-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div></td>
                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="container">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Asset</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Manufacturer</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Model</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Serial No.</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Location.</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Structure Group</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>

                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Safety Critical</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class ="col-lg-6 col-sm-12 col-md-6 mt -3">
                                            <input for="">Nde own or Not</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                            </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                            <label for="">Project</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                                            <label for="">Class</label>
                                            <input class="form-control" type="text" readonly value="1154.4584">
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                                            <label for="">Description</label>
                                           <textarea name="" id="" class="form-control" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>

                    </tr>
                    {{-- @endforeach --}}
                </tbody>
                </thead>
               </table>
          </div>
        </div>
        <div id="paginationContainer" class="float-end mt-3">
            {{-- {{$data->links()}} --}}
         </div>

      </div>
      <!-- / Content -->

      <!-- Footer -->
  @include('backend_app.layouts.footer')
      <!-- / Footer -->

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>

@endsection

