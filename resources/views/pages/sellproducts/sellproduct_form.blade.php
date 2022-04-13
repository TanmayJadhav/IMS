@extends('template')

@section('main')

    {{-- <form method="POST" action="/quotation/add"> --}}
    @csrf
    <div class="card">
        <div class="card-header">
            <p class="h5 m-0"><a href="/sellproduct" class="btn btn-dark mr-2 btn-sm"><i
                        class="fa fa-chevron-left"></i></a>
                Sell New Product</p>
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


            {{-- product table --}}
            <div class="row">
                <div class="text-center">
                    <button type="button" class="btn btn-warning mb-4" style="width: 700px">Select Products to
                        Add</button>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead class="thead">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Category</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_category }}</td>
                                    <td>{{ $product->brand }}</td>
                                    {{-- @php
                                                $product_exists = DB::table('sessions')->where('product_id',$product->id)->count() > 0;
                                            @endphp --}}
                                    @if (DB::table('sessions')->where('product_id', $product->id)->count() > 0)
                                        <td class="text-nowrap d-flex">
                                            <a class="btn btn-danger btn-sm disabled" data-toggle="modal"
                                                data-target="#exampleModal{{ $product->id }}" role="button"><i
                                                    class="fa fa-plus"></i> Add</a>

                                        </td>
                                    @else
                                        @if ($product->quantity == 0)
                                            <td class="text-nowrap d-flex">
                                                <a class="btn btn-danger btn-sm disabled" data-toggle="modal"
                                                    data-target="#exampleModal{{ $product->id }}" role="button"><i
                                                        class="fa fa-plus"></i> Add</a>
                                            </td>
                                        @else

                                            <td class="text-nowrap d-flex">
                                                <a class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#exampleModal{{ $product->id }}" role="button"><i
                                                        class="fa fa-plus"></i> Add</a>

                                            </td>
                                        @endif
                                    @endif
                                </tr>



                                <!-- Modal -->
                                <div class="modal fade " id="exampleModal{{ $product->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form method="POST" action="/sellproduct/sessionadd">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name='id' value="{{ $product->id }}">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="">Product Name</label>
                                                                        <input type="text" disabled name="product_name"
                                                                            value="{{ $product->product_name }}" required
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="">Product Category</label>
                                                                        <input type="text" disabled name="product_category"
                                                                            value="{{ $product->product_category }}"
                                                                            required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="">Purchase Price</label>
                                                                        <input type="number" disabled name="purchase_price"
                                                                            value="{{ $product->purchase_price }}"
                                                                            class="form-control" required>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for=""> Original Selling Price</label>
                                                                        <input type="number" disabled name="selling_price"
                                                                            value="{{ $product->selling_price }}"
                                                                            class="form-control" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for=""> Available Quantity</label>
                                                                        <input type="number" name="quantity"
                                                                            class="form-control"
                                                                            value="{{ $product->quantity }}" readonly>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="">Quantity to be sold <small
                                                                                class="text-danger">(select quantity less
                                                                                than available quantity)</small></label>
                                                                        <input type="number" name="sell_quantity"
                                                                            class="form-control" min="1" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="">Enter Selling Price</label>
                                                                        <input type="number" name="new_price"
                                                                            class="form-control" min="1" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit"
                                                        class="btn btn-primary">Add</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- selected product --}}
            @if (!sizeof($sessions) == 0)
                <div class="row">
                    <div class="text-center">
                        <button type="button" class="btn btn-success mb-4" style="width: 700px">Added Products</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead class="thead">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Quantity</th>
                                    <th scope="col">Selling Price</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_price = 0;
                                    $total_price_with_gst = 0;
                                @endphp
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>{{ $session->product->product_name }}</td>
                                        <td>{{ $session->quantity }}</td>
                                        <td>{{ $session->selling_price }}</td>
                                        @php
                                            $price = $session->quantity * $session->selling_price;
                                            $total_price = $total_price + $price;
                                            $gst_price = $price + $price * ($session->product->tax_slab / 100);
                                            $total_price_with_gst = $total_price_with_gst + $gst_price;
                                        @endphp

                                        <td>
                                            <button data-toggle="modal" data-target="#deleteModal{{ $session->id }}"
                                                class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash"></i>
                                                Remove</button>

                                        </td>

                                    </tr>


                                    <div class="modal fade" id="deleteModal{{ $session->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Remove Product</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Remove this product?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST"
                                                        action="/session_product/{{ $session->id }}/delete">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Yes</button>
                                                    </form>
                                                    <button class="btn btn-secondary" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <input type="text" hidden id="total_price_with_gst" value="{{ $total_price_with_gst }}">

                                <input type="text" hidden id="total_price_without_gst" value="{{ $total_price }}">
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <br>

            @endif

            <br>
            {{-- add new customer --}}

            <br>
            <form method="POST" action="/sellproduct/add">
                @csrf
                <div class="row">
                    @if (App\Http\Controllers\Controller::getCurrentCategory() == 'Special')
                        <div class="col-4">
                            <label for="">Referal Name</label>
                            <select class="form-control" name="referal_name" id="special_referal_name">
                                @foreach ($referals as $referal)
                                    <option value="{{ $referal->name }}">{{ $referal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Add New Referal Name</label>
                            <button data-toggle="modal" data-target="#addreferalModal" onclick="prevent()"
                                class="btn btn-primary form-control"><i class="fa fa-plus"></i>
                                Add</button>
                        </div>
                    @endif
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Transportation Charges</label>
                            <input type="number" min="0" name="transportation_charge" id="transportation_charge"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Labour Charges</label>
                            <input type="number" min="0" name="labour_charge" id="labour_charge" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="gst">Do you want quotation with GST?</label>

                            <select class="form-control" name="gst" id="gst">
                                <option selected disabled>Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Total Price</label>
                            <input type="text" name="total_price" id="total_price" readonly value="" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Amount Paid</label>
                            <input type="text" name="amount_paid" required class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div class="card-footer text-center">
                    <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Make Receipt</button>
                </div>
            </form>


            <!--Add Customer Modal -->
            <div class="modal fade " id="addcustomerModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form method="POST" action="/client/add">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Customer Name</label>
                                                    <input type="text" name="name" value="{{ old('name') }}" required
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Mobile</label>
                                                    <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Address</label>
                                                    <textarea name="address" rows="2" cols="40"
                                                        value="{{ old('address') }}" required
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit" class="btn btn-primary">Add
                                    Customer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            <!-- Add Referal Modal -->
            <div class="modal fade " id="addreferalModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Referal Name</h5>
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
                                                <label for="">Referal Name</label>
                                                <input type="text" name="referal_name" id="referal_name"
                                                    value="{{ old('name') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" onclick="add_referal();prevent()" type="submit"
                                class="btn btn-primary">Add</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        {{-- </form> --}}

        <script>
            $("#gst").change(function() {
                if ($(this).val() == "1") {
                    $('#total_price').val(parseInt($('#total_price_with_gst').val()) + parseInt($('#labour_charge')
                        .val() ? $('#labour_charge').val() : 0) + parseInt($('#transportation_charge').val() ?
                        $(
                            '#transportation_charge').val() : 0));
                }
                if ($(this).val() == "0") {
                    $('#total_price').val(parseInt($('#total_price_without_gst').val()) + parseInt($('#labour_charge')
                        .val() ? $('#labour_charge').val() : 0) + parseInt($('#transportation_charge').val() ?
                        $('#transportation_charge').val() : 0));
                }
            });

            function prevent() {
                $('#form').submit(function(event) {
                    event.preventDefault();
                });
            }


            function enable() {
                $("#form").unbind("submit");
            }

            function add_referal() {
                $name = $('#referal_name').val();

                $.ajax({
                    url: '/addreferal/' + $name,
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data['status'] == "success") {
                            //notifier("Added successfully!!");

                            // for (var i = 0; i < data['customers'].length; i++) {
                            $("#special_referal_name").append('<option value=' + data['referal'][0].name +
                                '>' +
                                data['referal'][0].name + '</option>');
                            // $("#customer_dropdown").append("<option" +
                            //     "' value='" + data['customers'][i]['id'] + "'>" +
                            //     data['customers'][i]['name'] + "</option>");
                            // }

                            // '<option value=' + key + '>' + value + '</option>'
                            alert('Referal Added Sucessfully');
                            $("#addreferalModal").modal('hide');


                        } else {

                        }

                    }
                    // $('#form').submit(function(event) {
                    //     event.preventDefault();
                    // });
                });
            }
        </script>
    @stop
