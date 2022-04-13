@extends('template')

@section('main')

    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card p-0">

                            <div class="card-header d-flex align-item-center justify-content-between">
                                <p class="h5 m-0"><a href="/expense" class="btn btn-dark mr-2 btn-sm"><i
                                            class="fa fa-chevron-left"></i></a>
                                    Edit Expense</p>
                            </div>
                            <form method="POST" action="">
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
                                            <label for="">Reason</label>
                                            <select class="form-control " required name="reason_id">
                                                @foreach ($reasons as $reason)
                                                <option value="{{$reason->id}}" {{$reason->id == $expense->reason_id ? 'selected' : ''}}> {{$reason->reason}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Date </label>
                                                <input type="date" name="date" value="{{ date('d-m-Y',strtotime($expense->date)) }}"
                                                    class="form-control" required>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Amount</label>
                                                <input type="number" name="amount" min="1" value="{{ $expense->amount }}"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="card-footer">
                                        <button class="btn btn-primary" type="submit" name="action" value="update"><i
                                                class="fa fa-plus"></i> Update</button>
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
