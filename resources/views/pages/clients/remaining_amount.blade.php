@extends('template')

@section('main')

<div class="card mx-auto">
    <div class="card-header d-flex align-item-center justify-content-between">
        <p class="h5 m-0"><a href="/client" class="btn btn-dark mr-2 btn-sm"><i class="fa fa-chevron-left"></i></a>
            Customer Info</p>
        @if (!sizeof($clients)==0)     
        <a href="/paymentdetails/{{$clients[0]->client_id}}" class="h5 m-0 btn btn-success mr-2 btn">Payment Details</a>
        @endif   
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead">
                    <tr>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Receipt Id</th>
                        <th scope="col">Amount Remaining</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!sizeof($clients)==0)                
                    
                    @foreach($clients as $client)
                    <tr>
                        <th scope="row">{{$client->client->name}}</th>
                        <td>{{$client->id}}</td>
                        <td>&#8377 {{$client->remaining_amount}}</td>                        
                        <td class="text-nowrap d-flex">
                            <a class="btn btn-warning btn-sm " href="/sellproduct/{{ $client->id  }}/view" role="button"><i class="fa fa-edit"></i> View Receipt</a>
                            
                        </td>
                    </tr>
                    @endforeach

                    @endif
                    
                </tbody>
            </table>
        </div>


    </div>
</div>


@stop