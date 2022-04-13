@extends('template')

@section('main')

    <form method="POST" action="/product/edit/{{ $product->id }}">
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
                    Edit Product</p>
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
                            <label for="">Product Name</label>
                            <input type="text" name="product_name" value="{{ $product->product_name }}" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Shop</label>
                        <select class="form-control" name="shop_id">
                            <option selected disabled>-----Select Shop-----</option>
                            @foreach ($shopnames as $shop)
                                <option value="{{ $shop->id }}"
                                    {{ $product->shop_id == $shop->id ? 'selected' : '' }}>
                                    {{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">Supplier </label>
                        <select class="form-control" name="vendor_id">
                            <option selected disabled>-----Select Supplier-----</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}"
                                    {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}
                                    (Category :
                                    {{ $vendor->product_category->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    @if (in_array('Computer', $permissions_arr) || in_array('Electronics', $permissions_arr) || in_array('Mobile', $permissions_arr))
                        <div class="col-md-4">
                            <label for="">Product Category</label>

                            <select class="form-control" name="product_category" id="product_category">
                                <option selected disabled>-----Select Vendor-----</option>
                                <option value="CPU" {{ $product->product_category == 'CPU' ? 'selected' : '' }}>CPU
                                </option>
                                <option value="Monitor" {{ $product->product_category == 'Monitor' ? 'selected' : '' }}>
                                    Monitor</option>
                                <option value="Keyboard"
                                    {{ $product->product_category == 'Keyboard' ? 'selected' : '' }}>
                                    Keyboard</option>
                                <option value="CCTV" {{ $product->product_category == 'CCTV' ? 'selected' : '' }}>CCTV
                                </option>
                                <option value="Mouse" {{ $product->product_category == 'Mouse' ? 'selected' : '' }}>Mouse
                                </option>
                                <option value="Other" {{ $product->product_category == 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                        </div>
                    @endif

                    @if (in_array('Special', $permissions_arr) || in_array('General', $permissions_arr))
                        <div class="col-md-4">
                            <label for="">Product Category</label>
                            <select class="form-control" name="product_category" id="special_product_category">
                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->name }} {{ $product->product_category == $category->name ? 'selected' : '' }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if (in_array('Computer', $permissions_arr) || in_array('Electronics', $permissions_arr) || in_array('Mobile', $permissions_arr))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Product Brand</label>
                                <input type="text" name="brand" value="{{ $product->brand }}" required
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Model</label>
                                <input type="text" name="model" value="{{ $product->model }}" required
                                    class="form-control">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Basic Price</label>
                            <input type="number" min="1" id="basic_price" value="{{ $product->basic_price }}"
                                name="basic_price" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Purchase GST</label>
                            <input type="number" min="1" id="purchase_gst" value="{{ $product->purchase_gst }}"
                                name="purchase_gst" class="form-control">
                        </div>
                    </div>
                    @if (in_array('Special', $permissions_arr) || in_array('General', $permissions_arr))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Manufacturer</label>
                                <input type="text" name="manufacturer" value="{{ $product->manufacturer }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Batch No</label>
                                <input type="text" name="batch_no" value="{{ $product->batch_no }}"
                                    class="form-control">
                            </div>
                        </div>
                    @else

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Warranty</label>
                                <input type="number" min="0" name="warranty" value="{{ $product->warranty }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Shortage</label>
                                <input type="number" min="0" name="shortage" value="{{ $product->shortage }}"
                                    class="form-control">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Purchase Price</label>
                            <input type="text" readonly name="purchase_price" id="purchase_price"
                                value="{{ $product->purchase_price }}" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Selling Price/Unit</label>
                            <input type="text" name="selling_price" value="{{ $product->selling_price }}" required
                                class="form-control">
                        </div>
                    </div>
                    @if (in_array('Computer', $permissions_arr) || in_array('Electronics', $permissions_arr) || in_array('Mobile', $permissions_arr))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tax Slab</label>
                                <input type="text" name="tax_slab" value="{{ $product->tax_slab }}" required
                                    class="form-control">
                            </div>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="text" name="quantity" value="{{ $product->quantity }}" required
                                class="form-control">
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
                                <option {{ $product->category == 'Wired' ? 'selected' : '' }}>Wired</option>
                                <option {{ $product->category == 'Wireless' ? 'selected' : '' }}>Wireless</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option selected disabled>-----Select Type-----</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>New</option>
                                <option {{ $product->type == 'Used' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>
                    </div>

                    {{-- Keyboard --}}
                    <div class="row" id="keyboard_div">
                        <div class="col-md-4">
                            <label for="">Category</label>
                            <select class="form-control" name="category">
                                <option selected disabled>-----Select Category-----</option>
                                <option {{ $product->category == 'Wired' ? 'selected' : '' }}>Wired</option>
                                <option {{ $product->category == 'Wireless' ? 'selected' : '' }}>Wireless</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option selected disabled>-----Select Type-----</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>New</option>
                                <option {{ $product->type == 'Used' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>
                    </div>


                    {{-- Monitor --}}
                    <div class="row" id="monitor_div">
                        <div class="col-md-4" id="keyboard_category">
                            <label for="">Display</label>
                            <select class="form-control" name="display">
                                <option selected disabled>-----Select Display Category-----</option>
                                <option {{ $product->display == 'LCD' ? 'selected' : '' }}>LCD</option>
                                <option {{ $product->display == 'LED' ? 'selected' : '' }}>LED</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Screen Size</label>
                                <input type="text" name="screen_size" value="{{ $product->screen_size }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option selected disabled>-----Select Type-----</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>New</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>
                    </div>

                    {{-- CCTV --}}
                    <div class="row" id="cctv_div">
                        <div class="col-md-4">
                            <label for="">Category</label>
                            <select class="form-control" name="category">
                                <option selected disabled>-----Select Category-----</option>
                                <option {{ $product->category == 'Dome Camera' ? 'selected' : '' }}>Dome Camera</option>
                                <option {{ $product->category == 'Bullet Type' ? 'selected' : '' }}>Bullet Type</option>
                                <option {{ $product->category == 'C Mount' ? 'selected' : '' }}>C Mount</option>
                                <option {{ $product->category == 'Day/Night' ? 'selected' : '' }}>Day/Night</option>
                                <option {{ $product->category == 'Infrared/Night Vision' ? 'selected' : '' }}>
                                    Infrared/Night
                                    Vision</option>
                                <option {{ $product->category == 'Varifocal Camera' ? 'selected' : '' }}>Varifocal Camera
                                </option>
                                <option {{ $product->category == 'Wireless Camera' ? 'selected' : '' }}>Wireless Camera
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option selected disabled>-----Select Type-----</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>New</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>
                    </div>

                    {{-- CPU --}}
                    <div class="row" id="cpu_div">
                        <div class="col-md-4">
                            <label for="">Category</label>
                            <select class="form-control" name="category">
                                <option selected disabled>-----Select Category-----</option>
                                <option {{ $product->category == 'HDD in GB' ? 'selected' : '' }}>HDD in GB</option>
                                <option {{ $product->category == 'SSD in GB' ? 'selected' : '' }}>SSD in GB</option>

                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option selected disabled>-----Select Type-----</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>New</option>
                                <option {{ $product->type == 'New' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Processor</label>
                                <input type="text" name="processor" value="{{ $product->processor }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">OS</label>
                                <input type="text" name="os" value="{{ $product->os }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">RAM</label>
                                <input type="text" name="ram" value="{{ $product->ram }}" class="form-control">
                            </div>
                        </div>
                    </div>
                @endif

                @if (in_array('Special', $permissions_arr) || in_array('General', $permissions_arr))
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Selling GST</label>
                                <input type="number" min="1" name="selling_gst" id="selling_gst"
                                    value="{{ $product->selling_gst }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Manufacture Date</label>
                                <input type="date" name="manufacture_date" value="{{ $product->manufacture_date }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Expiry Date</label>
                                <input type="date" name="expiry_date" value="{{ $product->expiry_date }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                @endif
                <br>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit" name="action" value="update"><i
                            class="fa fa-plus"></i>
                        Update</button>
                </div>
            </div>
    </form>


@section('script')

    <script>
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

            }

        });
        $("#product_category").trigger("change");


        var basic_price = $('#basic_price').val()
        var purchase_gst = $('#purchase_gst').val()

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
