@extends('template')

@section('main')

    @inject('converter', 'App\Http\Controllers\Controller')

    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card p-0">

                            <div class="card-header d-flex align-item-center justify-content-between">
                                <p class="h3 m-0">Expenses</p>
                                <div>
                                    <a href="/expense/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                                        New
                                        Expense</a>

                                    <button class="btn btn-warning btn-sm mr-1 " onclick="prevent()" role="button"
                                        data-toggle="modal" data-target="#filterModal"><i class="fa fa-filter"></i>
                                        Filter</button>
                                </div>
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
                                                <th class="text-left">Reason</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenses as $expense)
                                                <tr>
                                                    <td class="text-left">{{ $expense->reason->reason }}</td>
                                                    <td>&#8377 {{ $converter::IND_money_format($expense->amount) }}</td>
                                                    <td>{{ $expense->date->format('d-m-Y') }}</td>
                                                    <td>
                                                        <a class="btn btn-warning btn-sm mr-1 "
                                                            href="/expense/edit/{{ $expense->id }}" role="button"><i
                                                                class="fa fa-edit"></i> Edit</a>
                                                        {{-- <button class="btn btn-success btn-sm mr-1 " role="button"
                                                            data-toggle="modal"
                                                            data-target="#makepaymentModal{{ $expense->user->id }}"><i
                                                                class="fa fa-rupee-sign"></i> Make Payment</button> --}}
                                                        <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                                            data-target="#deleteModal{{ $expense->id }}" role="button"><i
                                                                class="fa fa-trash"></i> Delete</a>
                                                    </td>

                                                </tr>
                                                {{-- remove modal --}}
                                                <div class="modal" id="deleteModal{{ $expense->id }}"
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
                                                                    href="/expense/delete/{{ $expense->id }}">Delete</a>
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

    {{-- filter modal --}}
    <div class="modal fade " id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Work
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="GET" action="/expense/filter">
                    @csrf

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input type="date" name="start_date" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">End Date</label>
                                            <input type="date" name="end_date" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop
