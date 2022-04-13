@extends('template')

@section('main')

    <form method="POST" id="form" action="/product/add">
        @csrf

        @php
            $shopadmin = App\Models\Shopadmin::where('mobile', auth()->user()->username)->first();
            
            $permissions_arr = [];
            $permission_id = json_decode($shopadmin->shopcategory);
            if (empty($permission_id)) {
                array_push($permissions_arr, 'No Category Available');
            } else {
                foreach ($permission_id as $permission) {
                    array_push($permissions_arr, $permission);
                }
            }
            
        @endphp


        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/product" class="btn btn-dark mr-2 btn-sm"><i
                            class="fa fa-chevron-left"></i></a>
                    Add New Product</p>
            </div>
            <div class="card-body">
                @if ($permissions_arr[0] == 'No Category Available')
                    <p class="alert alert-danger">Please Add a Shop Category To Add New Product . Contact Admin ! <a href="#"
                            class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
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
                @if ($permissions_arr[0] != 'No Category Available')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input type="text" name="product_name" value="{{ old('product_name') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4" hidden>
                            <label for="">Shop</label>
                            <select class="form-control" name="shop_id">
                                {{-- <option selected disabled>-----Select Shop-----</option> --}}
                                @foreach ($shopnames as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="">Supplier (<small class="text-danger">If new Supplier add it in
                                    Suppliers</small>)</label>
                            <select class="form-control" name="vendor_id">
                                <option selected disabled>-----Select Supplier-----</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }} (Category :
                                        {{ $vendor->product_category->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Add New Supplier</label>
                            <button data-toggle="modal" data-target="#addsupplierModal" onclick="prevent()"
                                class="btn btn-primary"><i class="fa fa-plus"></i>
                                Add</button>
                        </div>
                    </div>
                    @if (in_array('Special', $permissions_arr) || in_array('General', $permissions_arr))

                        <div class="row">
                            <div class="col-md-8">
                                <label for="">Product Category</label>
                                <select class="form-control" name="product_category" id="special_product_category">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Add New Category</label>
                                <button data-toggle="modal" data-target="#addcategoryModal" onclick="prevent()"
                                    class="form-control btn btn-primary"><i class="fa fa-plus"></i>
                                    Add</button>
                            </div>
                        </div>
                    @endif
                    @if (in_array('Computer', $permissions_arr) || in_array('Electronics', $permissions_arr) || in_array('Mobile', $permissions_arr))
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Product Category</label>

                                <select class="form-control" name="product_category" id="product_category">
                                    <option selected disabled>-----Select Category-----</option>
                                    <option value="CPU">CPU</option>
                                    <option value="Monitor">Monitor</option>
                                    <option value="Keyboard">Keyboard</option>
                                    <option value="CCTV">CCTV</option>
                                    <option value="Mouse">Mouse</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Product Brand</label>
                                    <input type="text" name="brand" value="{{ old('brand') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Model</label>
                                    <input type="text" name="model" value="{{ old('model') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Basic Price</label>
                                <input type="number" min="1" id="basic_price" name="basic_price"
                                    value="{{ old('basic_price') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Purchase GST</label>
                                <input type="number" min="1" id="purchase_gst" name="purchase_gst"
                                    value="{{ old('purchase_gst') }}" class="form-control">
                            </div>
                        </div>
                        @if (in_array('Special', $permissions_arr) || in_array('General', $permissions_arr))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Manufacturer</label>
                                    <input type="text" name="manufacturer" value="{{ old('manufacturer') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Batch No</label>
                                    <input type="text" name="batch_no" value="{{ old('batch_no') }}"
                                        class="form-control">
                                </div>
                            </div>
                        @else

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Warranty</label>
                                    <input type="number" min="0" name="warranty" value="{{ old('warranty') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Shortage</label>
                                    <input type="number" min="0" name="shortage" value="{{ old('shortage') }}"
                                        class="form-control">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Purchase Price</label>
                                <input type="text" name="purchase_price" id="purchase_price" readonly
                                    value="{{ old('purchase_price') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Selling Price/Unit</label>
                                <input type="text" name="selling_price" value="{{ old('selling_price') }}"
                                    class="form-control">
                            </div>
                        </div>
                        @if (in_array('Computer', $permissions_arr) || in_array('Electronics', $permissions_arr) || in_array('Mobile', $permissions_arr))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tax Slab (GST)</label>
                                    <input type="text" name="tax_slab" value="{{ old('tax_slab') }}"
                                        class="form-control">
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    @if (in_array('Computer', $permissions_arr) || in_array('Electronics', $permissions_arr) || in_array('Mobile', $permissions_arr))
                        {{-- Mouse --}}
                        <div class="row" id="mouse_div">
                            <div class="col-md-4">
                                <label for="">Category</label>
                                <select class="form-control" name="category">
                                    <option selected disabled>-----Select Category-----</option>
                                    <option>Wired</option>
                                    <option>Wireless</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Type</label>
                                <select class="form-control" name="type">
                                    <option selected disabled>-----Select Type-----</option>
                                    <option>New</option>
                                    <option>Used</option>
                                </select>
                            </div>
                        </div>

                        {{-- Keyboard --}}
                        <div class="row" id="keyboard_div">
                            <div class="col-md-4">
                                <label for="">Category</label>
                                <select class="form-control" name="category">
                                    <option selected disabled>-----Select Category-----</option>
                                    <option>Wired</option>
                                    <option>Wireless</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Type</label>
                                <select class="form-control" name="type">
                                    <option selected disabled>-----Select Type-----</option>
                                    <option>New</option>
                                    <option>Used</option>
                                </select>
                            </div>
                        </div>


                        {{-- Monitor --}}
                        <div class="row" id="monitor_div">
                            <div class="col-md-4" id="keyboard_category">
                                <label for="">Display</label>
                                <select class="form-control" name="display">
                                    <option selected disabled>-----Select Display Category-----</option>
                                    <option>LCD</option>
                                    <option>LED</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Screen Size</label>
                                    <input type="text" name="screen_size" value="{{ old('screen_size') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4" id="keyboard_type">
                                <label for="">Type</label>
                                <select class="form-control" name="type">
                                    <option selected disabled>-----Select Type-----</option>
                                    <option>New</option>
                                    <option>Used</option>
                                </select>
                            </div>
                        </div>

                        {{-- CCTV --}}
                        <div class="row" id="cctv_div">
                            <div class="col-md-4">
                                <label for="">Category</label>
                                <select class="form-control" name="category">
                                    <option selected disabled>-----Select Category-----</option>
                                    <option>Dome Camera</option>
                                    <option>Bullet Type</option>
                                    <option>C Mount</option>
                                    <option>Day/Night</option>
                                    <option>Infrared/Night Vision</option>
                                    <option>Varifocal Camera</option>
                                    <option>Wireless Camera</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Type</label>
                                <select class="form-control" name="type">
                                    <option selected disabled>-----Select Type-----</option>
                                    <option>New</option>
                                    <option>Used</option>
                                </select>
                            </div>
                        </div>

                        {{-- CPU --}}
                        <div class="row" id="cpu_div">
                            <div class="col-md-4">
                                <label for="">Category</label>
                                <select class="form-control" name="category">
                                    <option selected disabled>-----Select Category-----</option>
                                    <option>HDD in GB</option>
                                    <option>SSD in GB</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Type</label>
                                <select class="form-control" name="type">
                                    <option selected disabled>-----Select Type-----</option>
                                    <option>New</option>
                                    <option>Used</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Processor</label>
                                    <input type="text" name="processor" value="{{ old('processor') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">OS</label>
                                    <input type="text" name="os" value="{{ old('os') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">RAM</label>
                                    <input type="text" name="ram" value="{{ old('ram') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (in_array('Special', $permissions_arr) || in_array('General', $permissions_arr))
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Selling GST</label>
                                    <input type="number" min="0" value="0" name="selling_gst" id="selling_gst"
                                        value="{{ old('selling_gst') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Manufacture Date</label>
                                    <input type="date" name="manufacture_date" value="{{ old('manufacture_date') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Expiry Date</label>
                                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="card-footer">
                        <button class="btn btn-success" onclick="enable()" type="submit" name="add"><i
                                class="fa fa-plus"></i>
                            Add</button>
                    </div>
                @endif



            </div>
        </div>
    </form>



    <!-- Add Supplier Modal -->
    <div class="modal fade " id="addsupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="/vendors/add">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Supplier Name</label>
                                            <input type="text" name="vendorname" value="{{ old('vendorname') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4" hidden>
                                        <label for="">Shop Admin</label>
                                        @php
                                            $shopadmin = DB::table('shopadmins')
                                                ->where('mobile', auth()->user()->username)
                                                ->get();
                                        @endphp
                                        <select class="form-control" name="shopadmin_id">
                                            <option value="{{ $shopadmin[0]->id }}"> {{ $shopadmin[0]->ownername }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Mobile</label>
                                            <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <textarea name="address" rows="2" cols="40" value="{{ old('address') }}"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Product Category</label>
                                        <select class="form-control" value="{{ old('product_category_id') }}"
                                            id="product_category_id" name="product_category_id">
                                            <option value="" selected>Select Product Category</option>
                                            @php
                                                $product_category = DB::table('product_categories')
                                                    ->where('shopadmin_id', $shopadmin[0]->id)
                                                    ->get();
                                            @endphp

                                            @foreach ($product_category as $product)
                                                <option value="{{ $product->id }}"> {{ $product->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit" class="btn btn-primary">Add Supplier</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Add Category Modal -->
    <div class="modal fade " id="addcategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Category Name</label>
                                        <input type="text" name="name" id="categoryname" value="{{ old('name') }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="add_category();prevent()" type="submit"
                        class="btn btn-primary">Add Category</button>
                </div>


            </div>
        </div>
    </div>


@section('script')

    <script>
        function prevent() {
            $('#form').submit(function(event) {
                event.preventDefault();
            });
        }


        function enable() {
            $("#form").unbind("submit");
        }

        function add_category() {
            $name = $('#categoryname').val();

            $.ajax({
                url: '/addcategory/' + $name,
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    // console.log(data);
                    if (data['status'] == "success") {
                        //notifier("Added successfully!!");

                        // for (var i = 0; i < data['customers'].length; i++) {
                        $("#special_product_category").append('<option value=' + data['categories'][0].name +
                            '>' +
                            data['categories'][0].name + '</option>');
                        // $("#customer_dropdown").append("<option" +
                        //     "' value='" + data['customers'][i]['id'] + "'>" +
                        //     data['customers'][i]['name'] + "</option>");
                        // }

                        // '<option value=' + key + '>' + value + '</option>'
                        alert('Category Added Sucessfully');
                        $("#addcategoryModal").modal('hide');


                    } else {

                    }

                }
                // $('#form').submit(function(event) {
                //     event.preventDefault();
                // });
            });
        }


        $("#product_category").change(function() {
            if ($(this).val() == "Mouse") {
                $('#mouse_div').show();
                $('#keyboard_div').hide();
                $('#monitor_div').hide();
                $('#cctv_div').hide();
                $('#cpu_div').hide();

            } else if ($(this).val() == "Keyboard") {
                $('#keyboard_div').show();
                $('#mouse_div').hide();
                $('#monitor_div').hide();
                $('#cctv_div').hide();
                $('#cpu_div').hide();

            } else if ($(this).val() == "Monitor") {
                $('#monitor_div').show();
                $('#mouse_div').hide();
                $('#keyboard_div').hide();
                $('#cctv_div').hide();
                $('#cpu_div').hide();

            } else if ($(this).val() == "CPU") {
                $('#cpu_div').show();
                $('#mouse_div').hide();
                $('#keyboard_div').hide();
                $('#monitor_div').hide();
                $('#cctv_div').hide();

            } else if ($(this).val() == "CCTV") {
                $('#cctv_div').show();
                $('#mouse_div').hide();
                $('#keyboard_div').hide();
                $('#monitor_div').hide();
                $('#cpu_div').hide();
            } else {
                $('#mouse_div').hide();
                $('#keyboard_div').hide();
                $('#monitor_div').hide();
                $('#cpu_div').hide();
                $('#cctv_div').hide();


                // $('#keyboard').show();
                // $('#authorphone').hide();
                // $('#authoremail').hide();
                // $('#authorSearhTag').hide();
                // $('#authormentor').hide();

            }

        });
        $("#product_category").trigger("change");


        var basic_price = 0
        var purchase_gst = 0

        $('#basic_price').change(function() {
            basic_price = $('#basic_price').val()

            var purchase_price = parseInt(basic_price) + parseInt(purchase_gst)

            $('#purchase_price').val(purchase_price)
        })
        $('#purchase_gst').change(function() {
            purchase_gst = $('#purchase_gst').val()

            var purchase_price = parseInt(basic_price) + parseInt(purchase_gst)

            $('#purchase_price').val(purchase_price)
        })
    </script>

@endsection

@stop
