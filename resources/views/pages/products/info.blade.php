@extends('template')

@section('main')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <div class="card-header">
                <p class="h5 m-0"><a href="/product" class="btn btn-dark mr-2 btn-sm"><i
                            class="fa fa-chevron-left"></i></a>
                    Product Related Info</p>
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

            <div class="row ">
                <div class="col">
                    <h5><b>Shop Id : {{$shopId}}</b></h5>
                </div>
                <div class="col">
                    <h5><b>ShopAdmin Id : {{$shopadmin_id}}</b></h5>
                </div>
            </div>

            <hr>
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Supplier Id</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Shop Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $vendor->id }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->shop_type }}</td>
                               
                            </tr>                           
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@stop
