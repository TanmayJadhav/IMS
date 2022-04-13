@extends('template')

@section('main')

    <form method="POST" action="">
        @csrf
        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/shopadmin" class="btn btn-dark mr-2 btn-sm"><i
                            class="fa fa-chevron-left"></i></a>Edit Shop Admin</p>
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
                            <input type="text" name="shopname" disabled value="{{ $shopadmin->shop->name }}" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Shop Category</label>

                        @php
                            $permission_arr = json_decode($shopadmin->shopcategory);
                        @endphp
                        @if (!empty($permission_arr))

                            <select class="form-control choices-multiple-remove-button" required name="shopcategory[]"
                                multiple>



                                {{-- @foreach ($shopadmins as $shop)
                                    <option value="{{ $shop->shopcategory->id }}"
                                        {{ $shop->shopcategory->name == $shopadmin->shopcategory->name ? 'selected' : '' }}>
                                        {{ $shop->shopcategory->name }}</option>
                                @endforeach --}}


                                <option value="Computer" {{ in_array('Computer', $permission_arr) ? 'selected' : '' }}>
                                    Computer</option>
                                <option value="Mobile" {{ in_array('Mobile', $permission_arr) ? 'selected' : '' }}>Mobile
                                </option>
                                <option value="Electronics"
                                    {{ in_array('Electronics', $permission_arr) ? 'selected' : '' }}>Electronics</option>
                                <option value="General" {{ in_array('General', $permission_arr) ? 'selected' : '' }}>
                                    General</option>
                                <option value="Special" {{ in_array('Special', $permission_arr) ? 'selected' : '' }}>
                                    Special</option>
                            </select>


                        @else

                            <select class="form-control choices-multiple-remove-button" required name="shopcategory[]"
                                multiple>

                                <option value="Computer">Computer</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Electronics">Electronics</option>
                                <option value="General">General</option>
                                <option value="Special">Special</option>
                            </select>

                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Owner Name</label>
                            <input type="text" name="ownername" value="{{ $shopadmin->ownername }}" class="form-control"
                                required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    @php
                        $permission_arr = json_decode($shopadmin->permission);
                    @endphp
                    @if (!empty($permission_arr))
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label>Permissions</label>
                                <select class="form-control choices-multiple-remove-button" placeholder="Select Permission"
                                     required name="permission[]" multiple>
                                    <option value="1" {{ in_array(1, $permission_arr) ? 'selected' : '' }}>Suppliers &
                                        Products</option>
                                    <option value="2" {{ in_array(2, $permission_arr) ? 'selected' : '' }}>Customers
                                    </option>
                                    <option value="3" {{ in_array(3, $permission_arr) ? 'selected' : '' }}>Generate
                                        Quotation
                                    </option>
                                    <option value="4" {{ in_array(4, $permission_arr) ? 'selected' : '' }}>Sell Product
                                    </option>
                                    <option value="5" {{ in_array(5, $permission_arr) ? 'selected' : '' }}>Generate
                                        Reports
                                    </option>
                                    <option value="6" {{ in_array(6, $permission_arr) ? 'selected' : '' }}>Employees
                                    </option>
                                    <option value="7" {{ in_array(7, $permission_arr) ? 'selected' : '' }}>Operators
                                    </option>
                                    <option value="8" {{ in_array(8, $permission_arr) ? 'selected' : '' }}>Expense
                                    </option>
                                </select>
                            </div>
                        </div>
                    @else

                        <div class="col-md-12">
                            <div class="form-group ">
                                <label>Permissions</label>
                                <select class="form-control choices-multiple-remove-button" placeholder="Select Permission"
                                    required name="permission[]" multiple>
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

                    @endif

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="number" name="mobile" value="{{ $shopadmin->mobile }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" name="address" rows="2" cols="40" value="{{ $shopadmin->address }}"
                                required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Country</label>
                        <select class="form-control" required value="{{ $shopadmin->country }}" id="country"
                            name="country">
                            <option value="101"> India</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label for="title">Select State:</label>
                            <select class="form-control" required name="state" id="state">
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ $state->id == $shopadmin->state ? 'selected' : '' }}>{{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label for="title">Select City:</label>
                            <select class="form-control" required name="city" id="city">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ $city->id == $shopadmin->city ? 'selected' : '' }}>{{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" value="{{ $shopadmin->password }}" name="password" class="form-control"
                                required>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button class="btn btn-success" type="submit" name="action" value="update"><i
                            class="fa fa-plus"></i>
                        Update</button>
                </div>
            </div>
    </form>

@section('script')

    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.choices-multiple-remove-button').select2();
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
