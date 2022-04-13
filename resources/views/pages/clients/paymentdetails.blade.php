@extends('template')

@section('main')

<div class="card mx-auto">
    <div class="card-header d-flex align-item-center justify-content-between">
        <p class="h5 m-0"><a href="/client/view/{{$client_id}}" class="btn btn-dark mr-2 btn-sm"><i class="fa fa-chevron-left"></i></a>
            Payment Details</p>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead">
                    <tr>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <th scope="row">{{$payment->client->name}}</th>
                        <td>{{$payment->date->format('d-m-Y')}}</td>                        
                        <td>&#8377 {{$payment->amount_paid}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
                <td colspan="2"></td>
                <td>Amount Remaining : &#8377  {{$remaining_amount}}</td>
            </table>
        </div>


    </div>
</div>


@stop