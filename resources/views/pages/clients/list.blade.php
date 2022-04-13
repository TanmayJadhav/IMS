@extends('template')

@section('main')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <p class="h3 m-0">Customers</p>
            <a href="/client/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Customer</a>
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
                            <th scope="col">Customer Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Address</th>
                            <th scope="col">Amount Remaining</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <th scope="row">{{ $client->name }}</th>
                                <td>{{ $client->mobile }}</td>
                                <td>{{ $client->address }}</td>
                                @php
                                    $remaining_amount = 0;
                                    $amount_paid = 0;
                                    $receipt = DB::table('receipts')
                                        ->where('client_id', $client->id)
                                        ->get();
                                    foreach ($receipt as $receipt) {
                                        $remaining_amount = $remaining_amount + $receipt->remaining_amount;
                                    }
                                    
                                    // amount paid
                                    
                                    $payments = DB::table('payments')
                                        ->where('client_id', $client->id)
                                        ->get();
                                    foreach ($payments as $payment) {
                                        $amount_paid = $amount_paid + $payment->amount_paid;
                                    }
                                    
                                    $remaining_amount = $remaining_amount - $amount_paid;
                                @endphp
                                <td><a class="btn btn-warning btn-sm btn-block mx-1 "
                                        href="/client/view/{{ $client->id }}"> &#8377 {{ $remaining_amount }}</a></td>
                                <td class="text-nowrap d-flex">
                                    <button class="btn btn-success btn-sm mx-1" data-toggle="modal"
                                        data-target="#makepaymentModal{{ $client->id }}"><i class="fa fa-rupee-sign"></i>
                                        Make Payment</button>
                                    <a class="btn btn-warning btn-sm " href="/client/edit/{{ $client->id }}"
                                        role="button"><i class="fa fa-edit"></i> Edit</a>

                                    <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                                        data-target="#deleteModal{{ $client->id }}" role="button"><i
                                            class="fa fa-trash"></i> Delete</a>
                                </td>

                                {{-- Make payment modal --}}
                                <div class="modal fade " id="makepaymentModal{{ $client->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form method="POST" action="/payment">
                                                @csrf
                                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">Date</label>
                                                                        <input type="date" name="date" value="" required
                                                                            class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">Amount</label>
                                                                        <input type="number" name="amount" min="0"
                                                                            class="form-control" required>
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
                            <div class="modal" id="deleteModal{{ $client->id }}" tabindex="-1" role="dialog">
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
                                            <form action="/client/{{ $client->id }}/delete" method="post">
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
