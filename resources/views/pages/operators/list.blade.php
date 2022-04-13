@extends('template')

@section('main')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <p class="h3 m-0">Operators</p>
            <a href="/operator/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Operator</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#"
                                class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <table class="table table-bordered datatable">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Operator Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Password</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operators as $operator)
                            <tr>
                                <th scope="row">{{ $operator->name }}</th>
                                <td>{{ $operator->mobile }}</td>
                                <td>{{ $operator->password }}</td>
                                <td class="text-nowrap d-flex">
                                    <a class="btn btn-warning btn-sm " href="/operator/edit/{{ $operator->id }}"
                                        role="button"><i class="fa fa-edit"></i> Edit</a>
                                   
                                    <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                        data-target="#deleteModal{{ $operator->id }}" role="button"><i
                                            class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>

                             {{-- delete modal --}}
                             <div class="modal" id="deleteModal{{ $operator->id }}" tabindex="-1" role="dialog">
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
                                            <form action="/operator/{{ $operator->id }}/delete" method="post">
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
