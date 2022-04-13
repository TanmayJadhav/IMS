@extends('template')

@section('main')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <p class="h3 m-0">Suppliers</p>
            <a href="/vendors/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Supplier</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="thead">
                        <tr>
                            {{-- <th scope="col">Shop Admin</th> --}}
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Product Category</th>
                            <th scope="col">Address</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $vendor)
                            <tr>
                                {{-- <th scope="row">{{$vendor->shopadmin->ownername}}</th> --}}
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->mobile }}</td>
                                <td>{{ $vendor->product_category->name }}</td>
                                <td>{{ $vendor->address }}</td>
                                <td class="text-nowrap d-flex">
                                    <a class="btn btn-warning btn-sm" href="/vendors/edit/{{ $vendor->id }}"
                                        role="button"><i class="fa fa-edit"></i> Edit</a>

                                    <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                        data-target="#deleteModal{{ $vendor->id }}" role="button"><i
                                            class="fa fa-trash"></i> Delete</a>


                                </td>
                            </tr>

                            {{-- delete modal --}}
                            <div class="modal" id="deleteModal{{ $vendor->id }}" tabindex="-1" role="dialog">
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
                                            <form action="/vendors/{{ $vendor->id }}/delete" method="post">
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


        </div>
    </div>


@stop
