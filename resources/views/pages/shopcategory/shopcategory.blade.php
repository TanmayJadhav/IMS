@extends('template')

@section('main')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <p class="h3 m-0">Shop Category</p>
            <a href="/shopcategory/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Shop Category</a>
        </div>
        <div class="card-body">
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
                            <th scope="col">Shop Category</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shopcategories as $shopcategory)
                            <tr>
                                <th scope="row">{{ $shopcategory->name }}</th>

                                <td class="text-nowrap d-flex">
                                    <a class="btn btn-warning btn-sm " href="/shopcategory/edit/{{ $shopcategory->id }}"
                                        role="button"><i class="fa fa-edit"></i> Edit</a>
                                    <form action="/shopcategory/{{ $shopcategory->id }}/delete" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash"></i>
                                            Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>


        </div>
    </div>


@stop
