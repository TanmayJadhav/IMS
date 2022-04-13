@extends('template')

@section('main')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <p class="h3 m-0">Products</p>
            <div>

                <a href="/product/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Product</a>
                <a href="/product/add" data-toggle="modal" data-target="#productcsvModal" class="btn btn-warning btn-sm"><i
                        class="fa fa-plus"></i> Upload CSV</a>
                <a href="/info" class="btn btn-primary btn-sm"><i class="fa fa-info"></i> Info</a>
            </div>
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

            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="thead">
                        <tr>
                            {{-- <th scope="col">Shop Name</th> --}}
                            <th scope="col">Product Name</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Product Category</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Purchase Price/Unit</th>
                            <th scope="col">Selling Price/Unit</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                {{-- <th scope="row">{{$product->shop->name}}</th> --}}
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->vendor->name }}</td>
                                <td>{{ $product->product_category }}</td>
                                <td>{{ $product->brand }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->purchase_price }}</td>
                                <td>{{ $product->selling_price }}</td>
                                {{-- @php
                        $city = DB::table('cities')->select('name')->where('id',$shopadmin->city)->get();
                        @endphp
                        <td>{{$city[0]->name}}</td>
                        @php
                        $state = DB::table('states')->select('name')->where('id',$shopadmin->state)->get();
                        @endphp
                        <td>{{$state[0]->name}}</td>
                        <td>{{$shopadmin->password}}</td> --}}
                                <td class="text-nowrap d-flex">
                                    <a class="btn btn-warning btn-sm " href="/product/edit/{{ $product->id }}"
                                        role="button"><i class="fa fa-edit"></i> Edit</a>

                                    <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                        data-target="#deleteModal{{ $product->id }}" role="button"><i
                                            class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>



                            {{-- delete modal --}}
                            <div class="modal" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this work??</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/product/{{ $product->id }}/delete" method="post">
                                                @csrf
                                                <button class="btn  btn-danger mx-1"><i class="fa fa-trash"></i>
                                                    Delete</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- CSV modal --}}
            <div class="modal" id="productcsvModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Product CSV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                    <div class="custom-file text-left">
                                        <label for="myfile">Select a file:</label>
                                        <input type="file" name="file" id="myfile" name="myfile">
                                    </div>
                                </div>
                                <button class="btn btn-primary">Import data</button>

                            </form>
                        </div>
                        {{-- <div class="modal-footer">
                <form action="/product/{{ $product->id }}/delete" method="post">
                    @csrf
                    <button class="btn  btn-danger mx-1"><i class="fa fa-trash"></i>
                        Delete</button>
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </form>
            </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
