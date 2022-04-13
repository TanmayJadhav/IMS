@extends('template')

@section('main')

    {{-- <style>
        .select {
            background: #4843cc;
            background: -webkit-linear-gradient(to right, #4843cc, #4843cc);
            background: linear-gradient(to right, #4843cc, #4843cc);
            color: #4843cc;
            min-height: 100vh
        }

    </style> --}}

    <form method="POST" action="/shopadmin/add">
        @csrf
        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/shopadmin" class="btn btn-dark mr-2 btn-sm"><i
                            class="fa fa-chevron-left"></i></a> Add New Shop Admin</p>
            </div>
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
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#"
                                class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shop Name</label>
                            <input type="text" name="shopname" value="{{ old('shopname') }}" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Shop Category</label>
                        <select
                            class="form-control choices-multiple-remove-button
                        choices-multiple-remove-button" 
                            required name="shopcategory[]" multiple>
                            <option value="Computer">Computer</option>
                            <option value="Mobile">Mobile</option>
                            <option value="Electronics">Electronics</option>
                            <option value="General">General</option>
                            <option value="Special">Special</option>
                            {{-- @foreach ($shopcategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach --}}

                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Owner Name</label>
                            <input type="text" name="ownername" value="{{ old('ownername') }}" class="form-control"
                                required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Permissions</label>
                            <select
                                class="form-control choices-multiple-remove-button
                            choices-multiple-remove-button"
                                placeholder="Select Permission" required name="permission[]" multiple>
                                <option value="1">Suppliers & Products</option>
                                <option value="2">Customers</option>
                                <option value="3">Generate Quotation</option>
                                <option value="4">Sell Product</option>
                                <option value="5">Generate Reports</option>
                                <option value="6">Employees</option>
                                <option value="7">Operators</option>
                                <option value="8">Expense</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" rows="2" cols="40" value="{{ old('address') }}" required
                                class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Country</label>
                        <select class="form-control " required value="{{ old('country') }}" id="country" name="country">
                            <option value="" selected disabled>Select</option>
                            <option value="101"> India</option>

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div>
                            <label for="title">Select State:</label>
                            <select class="form-control dropdown-select" value="{{ old('state') }}" name="state"
                                id="state">
                                <option value="" selected disabled>Select Country First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <label for="title">Select City:</label>
                            <select class="form-control dropdown-select " value="{{ old('city') }}" name="city"
                                id="city">
                                <option value="" selected disabled>Select State First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirmpassword" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success" type="submit" name="add"><i class="fa fa-plus"></i> Add</button>
                </div>
            </div>
    </form>

@section('script')

    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // $(document).ready(function() {

        //     var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        //         removeItemButton: true,

        //     });



        // });

        $(document).ready(function() {
            $('.choices-multiple-remove-button').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.dropdown-select').select2();
        });
    </script>




    <script>
        $(document).ready(function() {

            $('#country').on('change', function() {
                var country_id = $(this).val();
                if (country_id) {
                    $.ajax({
                        url: '/getstatelist/' + country_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {

                            $('#state').empty();

                            $.each(data, function(key, values) {
                                $('#state').append('<option value="' + key + '">' +
                                    values + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty();
                }
            });

            $('#state').on('change', function() {
                var state_id = $(this).val();
                if (state_id) {
                    $.ajax({
                        url: '/getcitylist/' + state_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#city').empty();

                            $.each(data, function(key, values) {
                                $('#city').append('<option value="' + key + '">' +
                                    values + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city').empty();
                }

            });

        });
    </script>
@endsection


@stop
