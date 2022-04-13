@extends('template')

@section('main')

<div class="card mx-auto">
    <div class="card-header d-flex align-item-center justify-content-between">
        <p class="h3 m-0">Shop Admin</p>
        <a href="{{ route('addshopadmin') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Shop Admin</a>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead">
                    <tr>
                        <th scope="col">Shop Name</th>
                        {{-- <th scope="col">Category</th> --}}
                        <th scope="col">Owner Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">State</th>
                        <th scope="col">Password</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shop_admins as $shopadmin)
                    <tr>
                        <th scope="row">{{$shopadmin->shop->name}}</th>
                        {{-- <td>{{$shopadmin->shopcategory->name}}</td> --}}
                        <td>{{$shopadmin->ownername}}</td>
                        <td>{{$shopadmin->mobile}}</td>
                        <td>{{$shopadmin->address}}</td>
                        @php
                        $city = DB::table('cities')->select('name')->where('id',$shopadmin->city)->get();
                        @endphp
                        <td>{{ !empty($city[0]->name) ? $city[0]->name : '-'}} </td>
                        @php
                        $state = DB::table('states')->select('name')->where('id',$shopadmin->state)->get();
                        @endphp
                        <td>{{$state[0]->name}}</td>
                        <td>{{$shopadmin->password}}</td>
                        <td class="text-nowrap d-flex">
                            <a class="btn btn-warning btn-sm " href="/shopadmin/edit/{{$shopadmin->id}}" role="button"><i class="fa fa-edit"></i> Edit</a>
                            <form action="/shopadmin/{{ $shopadmin->id }}/delete" method="post">
                                @csrf
                                <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                            @foreach ($users as $user)
                            <form action="/shopadmin/{{ $shopadmin->id }}/block" method="post">
                                @csrf
                                @if($shopadmin->mobile==$user->username)
                                <button class="btn btn-sm  mx-1 {{!$user->status==1 ? 'bg-danger' : 'bg-success'}} " ><i class="fa fa-trash"></i> {{$user->status==0 ? 'blocked' : 'block'}}</button>
                                @endif
                            </form>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>


    </div>
</div>


@stop