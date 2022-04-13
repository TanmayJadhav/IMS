@extends('template')

@section('main')

    <form method="POST" action="/operator/add">
        @csrf
        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/operator" class="btn btn-dark mr-2 btn-sm"><i class="fa fa-chevron-left"></i></a>
                    Add New Operator</p>
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
                            <label for="">Operator Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirmpassword" class="form-control" required>
                        </div>
                    </div>

                </div>
                

                <div class="card-footer">
                    <button class="btn btn-success" type="submit" name="add"><i class="fa fa-plus"></i> Add</button>
                </div>
            </div>
        </div>    
    </form>


@stop
