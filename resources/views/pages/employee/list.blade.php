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
                                <p class="h3 m-0">Employees</p>

                                <div>

                                    <a href="/employee/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                                        New
                                        Employee</a>
                                    {{-- @if ($button == true)
                                        <a href="/add-monthly-salary" class="btn btn-warning btn-sm"><i
                                                class="fa fa-plus"></i> Add Monthly Salary</a>
                                    @endif --}}
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
                                                <th class="text-left">Name</th>
                                                <th>Mobile</th>
                                                <th>Salary</th>
                                                <th>Salary Remaining</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td class="text-left">{{ $employee->name }}</td>
                                                    <td>{{ $employee->mobile }}</td>
                                                    <td>&#8377 {{ $converter::IND_money_format($employee->salary) }}</td>
                                                    <td><a class="btn btn-warning btn-sm mr-1 "
                                                            href="/employee/paymentdetails/{{ $employee->id }}"
                                                            role="button">&#8377
                                                            {{ $converter::IND_money_format($employee->salary_remaining) }}</a>
                                                    </td>
                                                    <td>

                                                        <a class="btn btn-success btn-sm mr-1" role="button"
                                                            data-toggle="modal"
                                                            data-target="#makepaymentModal{{ $employee->id }}"><i
                                                                class="fa fa-rupee-sign"></i> Make Payment</a>
                                                        <a class="btn btn-warning btn-sm mr-1 "
                                                            href="/employee/edit/{{ $employee->id }}" role="button"><i
                                                                class="fa fa-edit"></i> Edit</a>


                                                        <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                                            data-target="#deleteModal{{ $employee->id }}" role="button"><i
                                                                class="fa fa-trash"></i> Delete</a>
                                                    </td>


                                                    {{-- Receive payment modal --}}
                                                    <div class="modal fade " id="makepaymentModal{{ $employee->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Make
                                                                        Payment</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <form method="POST"
                                                                    action="/employee/makepayment/{{ $employee->id }}">
                                                                    @csrf
                                                                    <input type="hidden" name="doctor_id"
                                                                        value="{{ $employee->id }}">
                                                                    <div class="modal-body">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="">Date</label>
                                                                                            <input type="date" name="date"
                                                                                                value=""
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="">Amount</label>
                                                                                            <input type="number"
                                                                                                name="amount" min="0"
                                                                                                class="form-control"
                                                                                                required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-success" type="submit"
                                                                            class="btn btn-primary">Make Payment</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>

                                                {{-- delete modal --}}
                                                <div class="modal" id="deleteModal{{ $employee->id }}"
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
                                                                <p>Are you sure you want to delete this work??</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a class="btn btn-danger  mr-1 "
                                                                    href="/employee/delete/{{ $employee->id }}"
                                                                    role="button"><i class="fa fa-trash"></i> Delete</a>

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
