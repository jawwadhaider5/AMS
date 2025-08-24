@extends('backend_app.layouts.template')
@section('content')

<div id="preloader" style="display:none;" class="spinner-grow text-success" style="position:absolute;" role="status">
    <span class="visually mx-5">Downloading...</span>
  </div>
<div class="layout-page">
    <!-- Navbar -->

 @include('backend_app.layouts.nav')

    <!-- / Navbar -->

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">File /</span> {{$data->id_no}}</h4>
        <input type="hidden" value="{{$data->id}}" id="file_id">
        <!-- Header -->
        <div class="row">
          <div class="col-12">
            <div class="card mb-4">

              <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">

                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                  <div
                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                      <h4>HV-Code:{{$data->hv_code}}</h4>
                      <ul
                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-color-swatch"></i> {{$data->size}} {{$data->unit}}
                        </li>
                        <li class="list-inline-item d-flex gap-1"><i class="ti ti-map-pin"></i> {{$data->file_location}}</li>
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-calendar"></i> Created At {{$data->created_at->format('j M Y')}}
                        </li>
                      </ul>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary">
                      File Status:{{$data->file_status}}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ Header -->

        <!-- Navbar pills -->
        <div class="row">
            <div class="col-md-12">
              <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                <li class="nav-item">
                    <button
                          class="btn btn-primary"
                          type="button"
                          data-bs-toggle="offcanvas"
                          data-bs-target="#offcanvasBackdrop"
                          aria-controls="offcanvasBackdrop">
                          Add Payment
                        </button>

                  <div
                  class="offcanvas offcanvas-end"
                  tabindex="-1"
                  id="offcanvasBackdrop"
                  aria-labelledby="offcanvasBackdropLabel">
                  <div class="offcanvas-header">
                    <h5 id="offcanvasBackdropLabel" class="offcanvas-title">Add Payment</h5>
                    <button
                      type="button"
                      class="btn-close text-reset"
                      data-bs-dismiss="offcanvas"
                      aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                    <div class="form-input">
                        <form action="{{route('ledger-payment')}}" method="POST">
                            @csrf
                 <label for="">Paid Amount</label>
                 <input type="number" name="paid_amount" class="form-control">
                </div>
                <div class="form-input my-3">
                    <label for="">ID No</label>
                    <input type="text" name="file_name" value="{{$data->id_no}}" disabled class="form-control">
                    <input type="hidden" name="file_id" value="{{$data->id}}"  class="form-control">
                    <input type="hidden" name="total_amount" value="{{$data->total_amount - $total_paid}}"  class="form-control">

                   </div>
                   <div class="form-input my-3">
                    <label for="">Purpose</label>
                    <input type="text" name="purpose" value=""  class="form-control">
                   </div>
                    <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                    <button
                      type="button"
                      class="btn btn-label-secondary d-grid w-100"
                      data-bs-dismiss="offcanvas">
                      Cancel
                    </button>
                </form>
                  </div>
                </div>
                </li>

              </ul>
            </div>
          </div>
        <!--/ Navbar pills -->

        <!-- User Profile Content -->
        <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-4">
            <!-- About User -->
            <div class="card mb-4">
              <div class="card-body">
                <small class="card-text text-uppercase">About</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-file-description text-heading"></i
                        ><span class="fw-medium mx-2 text-heading">HV-Code:</span> <span>{{$data->hv_code}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-file-description text-heading"></i
                        ><span class="fw-medium mx-2 text-heading">Form-No:</span> <span>{{$data->form_no}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-check text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Id-No:</span> <span>{{$data->id_no}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-crown text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Security-No:</span> <span>{{$data->security_no}}</span>
                  </li>
                      <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-crown text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Plot-No:</span> <span>{{$data->plot_no}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-flag text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">File-Status:</span> <span>{{$data->file_status}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-file-description text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Type:</span> <span>{{$data->type}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                  <i class="ti ti-file-description text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">size:</span> <span>{{$data->size}} {{$data->unit}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                  <i class="ti ti-file-description text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Loc:</span> <span>{{$data->file_location}}</span>
                  </li>
                </ul>
                <small class="card-text text-uppercase">Payment</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                  <i class="ti ti-money"></i><span class="fw-medium mx-2 text-heading">Total Amount:</span>
                  <span>{{ number_format($data->total_amount) }}</span>
                    </li>
                  <li class="d-flex align-items-center mb-3">
                  <i class="ti ti-money"></i><span class="fw-medium mx-2 text-heading">Paid Amount:</span>
                  <span>{{ number_format($total_paid) }}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                 <i class="ti ti-money"></i><span class="fw-medium mx-2 text-heading">Balance Amount:</span>
                 <span>{{ number_format($data->total_amount - $total_paid) }}</span>
                 </li>
                </ul>

              </div>
            </div>

          </div>
          <div class="col-xl-6 col-lg-6 col-md-5">

            <!--/ Activity Timeline -->
            <div class="position-relative">


            <div class="row" >
              <!-- Connections -->
              <div class="col-lg-12 col-xl-12">
                <div class="card card-action mb-4 " >
                  <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Ledger</h5>
                    <div class="card-action-element">
                      <div class="dropdown">
                        <button
                          type="button"
                          class="btn dropdown-toggle hide-arrow p-0"
                          data-bs-toggle="dropdown"
                          aria-expanded="false">
                          <i class="ti ti-dots-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a id="export_excel" class="dropdown-item" >Export PDF</a></li>

                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <table class="table table-hoverable">
                        <tr>
                            <th>S.No</th>
                            <th>Paid Amount</th>
                            <th>Purpose</th>
                            <th>Functions</th>
                        </tr>
                        @forelse($ledger as $key=>$item)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{ number_format($item->paid_amount) }}</td>
                            <td>{{$item->purpose}}</td>
                            <td><a href="{{route('delete-ledger',['id'=>$item->id])}}"><i class="ti ti-trash text-danger" style="cursor: pointer"></i></a><i  data-bs-toggle="modal" data-bs-target="#ledger_{{$item->id}}"  style="cursor: pointer" class="ti ti-pencil mx-4 text-warning"></i></td>
                            <div class="modal fade" id="ledger_{{$item->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                  <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      <div class="text-center mb-4">
                                        <h3 class="mb-2">Update Ledger Payment</h3>
                                        <p>Update the values and then click on submit to save the data</p>
                                      </div>

                                      <form id="enableOTPForm" class="row g-3" action="{{route('update-ledger',['id'=>$item->id])}}" method="post">
                                        @csrf
                                        <div class="col-12">
                                          <label class="form-label" for="modalEnableOTPPhone">Paid Amount</label>
                                          <div class="input-group py-2">

                                            <input
                                              type="number"
                                                class="form-control"
                                              name="paid_amount"
                                              value="{{$item->paid_amount}}"
                                               />
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEnableOTPPhone">Purpose</label>
                                            <div class="input-group py-2 mb-3">

                                              <input
                                                type="text"
                                                value="{{$item->purpose}}"
                                                name="purpose"
                                                class="form-control "
                                                />
                                            </div>
                                          </div>
                                        <div class="col-12">
                                          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                          <button
                                            type="reset"
                                            class="btn btn-label-secondary"
                                            data-bs-dismiss="modal"
                                            aria-label="Close">
                                            Cancel
                                          </button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </tr>
                      @empty
                            <li>Empty</li>
                        @endforelse
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Connections -->
              <!-- Teams -->

              <!--/ Teams -->
            </div>


            <div class="row" style="display:none;" id="ledger-section">
                <div class="col-lg-12 col-xl-12 ">
                  <div class="card card-action mb-4 bg-white pt-5 mt-5 " >
                    <img src="{{asset('assets/img/logo/hillview-png-1.png')}}" class="w-25 p-3 ms-auto" alt="">
                    <div class="card-header align-items-center">

                      <h5 class="card-action-title mb-0 text-black">Ledger of {{$data->hv_code}}</h5>

                    </div>
                    <div class="card-body">
                      <table class="table table-hoverable text-black">
                          <tr>
                              <th>S.No</th>
                              <th>Paid Amount</th>
                              <th>Purpose</th>

                          </tr>
                          @forelse($ledger as $key=>$item)
                          <tr>
                              <td>{{$key}}</td>
                              <td>{{$item->paid_amount}}</td>
                              <td>{{$item->purpose}}</td>

                          </tr>
                        @empty
                              <li>Empty</li>
                          @endforelse
                      </table>

                      <table class="table table-hoverable text-black mt-4">
                        <tr>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance Amount</th>

                        </tr>

                        <tr>
                            <td>{{$data->total_amount}}</td>
                            <td>{{$total_paid}}</td>
                            <td>{{$data->total_amount - $total_paid}}</td>

                        </tr>

                    </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-md-4">
            <div class="row">
                <!-- Connections -->
                <div class="col-lg-12 col-xl-12">
                    <div class="card  mb-4">
                        <div class="card-header align-items-center">
                          <h5 class="card-action-title mb-0">Sales Partner Detail</h5>
                          @if($data->distributor_id !== null)
                          @php
                              $dealer_data=DB::table('distributors')->where('id',$data->distributor_id)->first();
                          @endphp
                           <ul class=" mt-3 p-0" style="font-size: 12px;">
                            <li>
                                Name: <span class="text-primary">{{$dealer_data->name}}
                            </li>
                            <li>Company:   <span class="text-primary">{{$dealer_data->company}}</span></li>
                            <li>Cnic:   <span class="text-primary">{{$dealer_data->cnic_no}}</span></li>
                            <li>Phone:  <span class="text-primary">{{$dealer_data->phone_no}}</span></li>
                         </li>
                         @else
                            <h6>Not Assigned Yet</h6>
                        </ul>
                         @endif

                        </div>
                      </div>
                  <div class="card  mb-4">
                    <div class="card-header align-items-center">
                      <h5 class="card-action-title mb-0">Client Detail</h5>
                      @if($client)
                      <ul class=" mt-3 p-0" style="font-size: 12px;">
                        <li>
                            Name: <span class="text-primary">{{$client->name}}
                        </li>
                        <li>Cnic:   <span class="text-primary">{{$client->cnic}}</span></li>
                        <li>Phone:  <span class="text-primary">{{$client->phone_no}}</span></li>
                     </li>
                     @else
                        <h6>Not Assigned Yet</h6>
                    </ul>
                     @endif

                    </div>
                  </div>
                </div>
            </div>
            </div>
          </div>
        </div>
        <!--/ User Profile Content -->
      </div>


      {{-- Modal Edit --}}
      <div class="modal fade" id="enableOTP" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
          <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center mb-4">
                <h3 class="mb-2">Enable One Time Password</h3>
                <p>Verify Your Mobile Number for SMS</p>
              </div>
              <p>Enter your mobile phone number with country code and we will send you a verification code.</p>
              <form id="enableOTPForm" class="row g-3" onsubmit="return false">
                <div class="col-12">
                  <label class="form-label" for="modalEnableOTPPhone">Phone Number</label>
                  <div class="input-group">
                    <span class="input-group-text">US (+1)</span>
                    <input
                      type="text"
                      id="modalEnableOTPPhone"
                      name="modalEnableOTPPhone"
                      class="form-control phone-number-otp-mask"
                      placeholder="202 555 0111" />
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                  <button
                    type="reset"
                    class="btn btn-label-secondary"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                    Cancel
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!--/ Enable

      {{--  --}}

      <!-- Footer -->
   @include('backend_app.layouts.footer')
      <!-- / Footer -->

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
      let file_id = $("#file_id").val();
      $("#export_excel").click(function(){
        $("#preloader").show();

      // Capture the HTML section
      var element = $("#ledger-section").html();

        console.log(element);
      // Options for html2pdf.js
      var options = {
        margin: 10,
        filename: 'ledger.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      };

      // Use html2pdf.js to generate the PDF
      html2pdf(element, options)
        .then(function(){
          // Hide the preloader once the PDF is generated
          $("#preloader").hide();
        })
      // Hide the ledger section again after capturing

      });

    });
  </script>

  @endsection
