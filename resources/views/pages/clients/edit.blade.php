@extends('template')

@section('main')

    <form method="POST" action="">
        @csrf
        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/client" class="btn btn-dark mr-2 btn-sm"><i class="fa fa-chevron-left"></i></a>
                    Edit Customer</p>
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
                    @if (Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#"
                                class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Customer Name</label>
                            <input type="text" name="name" value="{{$client->name}}" required
                                class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="number" name="mobile" value="{{ $client->mobile }}" class="form-control" required>
                        </div>
                    </div>
                 

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" name="address" value="{{ $client->address }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success"  type="submit" name="action" value="update"><i class="fa fa-plus"></i> Update</button>
                </div>
            </div>
    </form>


@stop
