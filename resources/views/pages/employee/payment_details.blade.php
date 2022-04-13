@extends('template')

@section('main')

    @inject('converter', 'App\Http\Controllers\Controller')

<div class="card mx-auto">
    @if(auth()->user()->user_type == 'employee')
    <div class="card-header d-flex align-item-center justify-content-between">
        <p class="h5 m-0">
            Remaining Amount</p>
    </div>
    @else
    <div class="card-header d-flex align-item-center justify-content-between">
        <p class="h5 m-0"><a href="/employee" class="btn btn-dark mr-2 btn-sm"><i
                    class="fa fa-chevron-left"></i></a>
            Payment Details</p>
    </div>
    @endif
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->date->format('d/m/Y') }}</td>
                            <td>&#8377 {{ $converter::IND_money_format($payment->amount_paid) }}</td>
                        </tr>
                    @endforeach

                </tbody>
                <td colspan="2"></td>
                <td>Amount Remaining : &#8377 {{ $converter::IND_money_format($employee->salary_remaining) }}</td>
            </table>
        </div>
    </div>
</div>


@stop
