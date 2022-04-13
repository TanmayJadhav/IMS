@extends('template')

@section('main')

    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card p-0">

                            <div class="card-header d-flex align-item-center justify-content-between">
                                <p class="h5 m-0"><a href="/reason" class="btn btn-dark mr-2 btn-sm"><i
                                            class="fa fa-chevron-left"></i></a>
                                    Add Reason</p>
                            </div>
                            <form method="POST" action="/reason/add">
                                @csrf
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
                                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                                <a href="#" class="close" data-dismiss="alert"
                                                    aria-label="close">&times;</a></p>
                                        @endif
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Reason</label>
                                                <input type="text" name="name" value="{{ old('name') }}" required
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>    

                                    <div class="card-footer">
                                        <button class="btn btn-primary" type="submit" name="add"><i
                                                class="fa fa-plus"></i> Add</button>
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@stop
