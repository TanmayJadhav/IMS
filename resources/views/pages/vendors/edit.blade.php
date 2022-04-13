@extends('template')

@section('main')

<form method="POST" action=" " >
    @csrf
    <div class="card">
        <div class="card-header">
            <p class="h5 m-0"><a href="/vendors" class="btn btn-dark mr-2 btn-sm"><i class="fa fa-chevron-left"></i></a> Edit Supplier</p>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger" class="close" data-dismiss="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Supplier Name</label>
                        <input type="text" name="name" value="{{$vendors->name}}" required class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">Shop Admin</label>
                    @php
                        $shopadmin = DB::table('shopadmins')->where('mobile',auth()->user()->username)->get();
                    @endphp
                     <select class="form-control"  name="shopadmin_id">
                        <option value="{{$shopadmin[0]->id}}"> {{$shopadmin[0]->ownername}}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Mobile</label>
                        <input type="number" name="mobile" value="{{ $vendors->mobile}}" class="form-control" required>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="address" value="{{ $vendors->address}}" required class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">Product Category</label>
                    <select class="form-control" required id="product_category_id" name="product_category_id">
                        <option value="" selected disabled>Select Product Category</option>
                        @php
                            $product_category = DB::table('product_categories')->where('shopadmin_id',$shopadmin[0]->id)->get()
                        @endphp
                        @foreach ($product_category as $product)
                        <option value="{{$product->id}}" {{$vendors->product_category_id == $product->id ? 'selected':''}}> {{$product->name}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
           
            <div class="card-footer">
                <button class="btn btn-success" type="submit" name="action" value="update"><i class="fa fa-plus"></i> Update</button>
            </div>
        </div>
</form>

@stop