@extends('template')

@section('main')


    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card p-0">

                            <div class="card-header d-flex align-item-center justify-content-between">
                                <p class="h5 m-0"><a href="/sellproduct" class="btn btn-dark mr-2 btn-sm"><i
                                            class="fa fa-chevron-left"></i></a>
                                    Add Customer Details</p>
                            </div>
                            <form class="form-sample" id="form" method="POST" action="/sellproduct/add_customer_details">
                                @csrf
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger" class="close" data-dismiss="alert">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                        @if (Session::has('alert-' . $msg))
                                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                                <a href="#" class="close" data-dismiss="alert"
                                                    aria-label="close">&times;</a>
                                            </p>
                                        @endif
                                    @endforeach
                                    <div class="row">
                                        

                                        <div class="col-md-9">
                                            <div class="form-group ">
                                                <label class=" col-form-label">Customer Name</label>
                                                <select class="form-control dropdown-select" id="customer_dropdown"
                                                    placeholder="Select Product Name" required name="customer_id">
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">
                                                            {{ $customer->name }} ({{ $customer->mobile }})</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                           
                                        </div>
                                        <div class="col-md-3    ">
                                            <div class="form-group ">
                                                <label class=" col-form-label text-danger">If New Customer Add Here</label>
                                                <button onclick="prevent()"
                                                    class="btn form-control btn-warning btn-sm mr-1 " role="button"
                                                    data-toggle="modal" data-target="#addcustomerModal"><i
                                                        class="fa fa-plus"></i> Add New
                                                    Customer</button>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="">
                                        <button class="btn btn-primary btn-lg" onclick="enable()" type="submit" name="add"><i
                                                class="fa fa-arrow-right"></i>
                                            Next</button>
                                    </div>
                                </div>
                            </form>

                            {{-- Add new customer modal --}}
                            <div class="modal fade " id="addcustomerModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Add Customer</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>



                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Name</label>
                                                                <input type="text" id="name" name="name" value=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                           
                                                                <div class="form-group">
                                                                    <label for="">Mobile</label>
                                                                    <input type="number" step="any" id="mobile" name="mobile"
                                                                        value="" class="form-control">
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Address</label>
                                                                <input type="text" id="address" name="address" value=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-success" onclick="add_customer();prevent()" type="submit"
                                                class="btn btn-primary">Add
                                                Customer</button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

@section('script')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropdown-select').select2();
        });
    </script>

    <script>
        function prevent() {
            $('#form').submit(function(event) {
                event.preventDefault();
            });
        }


        function enable() {
            $("#form").unbind("submit");
        }


        function add_customer() {
            $name = $('#name').val();
            $mobile = $('#mobile').val();
            $address = $('#address').val();

            if($mobile === '' || $mobile === null){
                $mobile = 'undefined';
            }
            if($address === '' || $address === null){
                $address = 'undefined';
            }

            $.ajax({
                url: '/addcustomer/' + $name + '/' + $mobile + '/' + $address ,
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    // console.log(data);
                    if (data['status'] == "success") {
                        //notifier("Added successfully!!");

                        // for (var i = 0; i < data['customers'].length; i++) {
                        $("#customer_dropdown").append('<option value=' + data['customers'][0].id + '>' +
                            data['customers'][0].name + ' ' + '('  + data['customers'][0].mobile + ')'  + '</option>');
                        // $("#customer_dropdown").append("<option" +
                        //     "' value='" + data['customers'][i]['id'] + "'>" +
                        //     data['customers'][i]['name'] + "</option>");
                        // }

                        // '<option value=' + key + '>' + value + '</option>'
                        alert('Customer Added Sucessfully');
                        $("#addcustomerModal").modal('hide');


                    } else {

                    }

                }
            });
        }
    </script>




@endsection


@endsection
