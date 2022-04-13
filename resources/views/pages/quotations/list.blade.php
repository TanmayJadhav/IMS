@extends('template')

@section('main')

<div class="card mx-auto">
    <div class="card-header d-flex align-item-center justify-content-between">
        <p class="h3 m-0">Quotations</p>
        <a href="/quotation/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Quotation</a>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead">
                    <tr>
                        <th scope="col">Quotation Number</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>   
                @php
                    $i=0;
                @endphp 
                <tbody>
                    @foreach($quotation as $quotation)
                    <tr>
                        <th scope="row">{{++$i}}</th>
                        <td>{{$quotation->client->name }}</td>
                        <td>{{$quotation->created_at->format('d/M/Y') }}</td>
                        <td class="text-nowrap d-flex ">
                            <a class="btn btn-success btn-sm mr-1 " href="/quotation/{{ $quotation->id  }}/view" role="button"><i class="fa fa-eye"></i> View</a>
                            <a class="btn btn-warning btn-sm " href="/quotation/{{ $quotation->id }}/pdfdownload" role="button"><i class="fa fa-edit"></i>Download PDF</a>
                            
                            <a class="btn btn-danger btn-sm mr-1 " data-toggle="modal"
                            data-target="#deleteModal{{ $quotation->id }}" role="button"><i
                                class="fa fa-trash"></i> Delete</a>
                            {{-- @foreach ($users as $user)
                            <form action="/quotation/{{ $quotation->id }}/block" method="post">
                                @csrf
                                @if($shopadmin->mobile==$user->username)
                                <button class="btn btn-sm  mx-1 {{!$user->status==1 ? 'bg-danger' : 'bg-success'}} " ><i class="fa fa-trash"></i> {{$user->status==0 ? 'blocked' : 'block'}}</button>
                                @endif
                            </form>
                            @endforeach --}}
                        </td>
                    </tr>

                     {{-- delete modal --}}
                     <div class="modal" id="deleteModal{{ $quotation->id }}" tabindex="-1" role="dialog">
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
                                    <form action="/quotation/{{ $quotation->id }}/delete" method="post">
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