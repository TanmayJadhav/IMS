@extends('template')

@section('main')

    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card p-0">

                            <div class="card-header d-flex align-item-center justify-content-between">
                                <p class="h3 m-0">Reason</p>
                                <a href="/reason/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New
                                    Reason</a>
                            </div>
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if (Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                        <a href="#" class="close" data-dismiss="alert"
                                            aria-label="close">&times;</a>
                                    </p>
                                @endif
                            @endforeach
                            <div class="table-responsive">

                                <div class="card-body">

                                    <table class="table table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-left">Sr No.</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($reasons as $reason)
                                                <tr>
                                                    <td class="text-left">{{ $i++ }}</td>
                                                    <td>{{ $reason->reason}}</td>
                                                    <td>
                                                        <a class="btn btn-warning btn-sm mr-1 "
                                                            href="/reason/edit/{{ $reason->id }}" role="button"><i
                                                                class="fa fa-edit"></i> Edit</a>
                                                      
                                                        <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                                        data-target="#deleteModal{{ $reason->id }}"
                                                            role="button"><i
                                                                class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                                 {{-- remove modal --}}
                                                 <div class="modal" id="deleteModal{{ $reason->id }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Confirmation</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this reason??</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a class="btn btn-danger"
                                                                    href="/reason/delete/{{ $reason->id }}">Delete</a>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
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

                    </div>
                </div>
        </main>
    </div>


@stop
