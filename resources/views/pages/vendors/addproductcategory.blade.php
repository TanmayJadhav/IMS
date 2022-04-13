@extends('template')

@section('main')

    <form method="POST" action="/vendors/addproductcategory">
        @csrf
        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/vendors" class="btn btn-dark mr-2 btn-sm"><i class="fa fa-chevron-left"></i></a>
                    Add New Supplier Category</p>
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
                            <label for="">Supplier Category Name</label>
                            <input type="text" name="categoryname" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6" hidden>
                        <label for="">Shopadmin</label>
                        @php
                            $shopadmin = DB::table('shopadmins')
                                ->where('mobile', auth()->user()->username)
                                ->get();
                            
                            $vendor = DB::table('vendors')
                                ->where('shopadmin_id', $shopadmin[0]->id)
                                ->get();
                        @endphp
                        <select class="form-control" name="shopadmin_id">
                            <option value="{{ $shopadmin[0]->id }}"> {{ $shopadmin[0]->ownername }}</option>
                        </select>
                    </div>
                </div>


                <div class="card-footer">
                    <button class="btn btn-success" type="submit" name="add"><i class="fa fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
        <br>
    </form>
    <br>
    <br>



    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead">
                    @php
                        $i =0;
                    @endphp
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        {{-- <th scope="col">Action</th> --}}

                    </tr>
                </thead>
                <tbody>
                    @foreach ($productcategory as $category)
                        <tr>
                            <td scope="row">{{ ++$i }}</td>
                            <td scope="row">{{ $category->name }}</td>
                            {{-- <td>
                                <form action="/vendors/productcategory/{{ $category->id }}/delete" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </td> --}}

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>


    {{-- </div> --}}



@stop
