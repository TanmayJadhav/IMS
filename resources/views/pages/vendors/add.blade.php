@extends('template')

@section('main')

    <form method="POST" action="/vendors/add">
        @csrf
        <div class="card">
            <div class="card-header">
                <p class="h5 m-0"><a href="/vendors" class="btn btn-dark mr-2 btn-sm"><i
                            class="fa fa-chevron-left"></i></a>
                    Add New Supplier</p>
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
                            <label for="">Supplier Name</label>
                            <input type="text" name="vendorname" value="{{ old('vendorname') }}" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4" hidden>
                        <label for="">Shop Admin</label>
                        @php
                            $shopadmin = DB::table('shopadmins')
                                ->where('mobile', auth()->user()->username)
                                ->get();
                        @endphp
                        <select class="form-control" name="shopadmin_id">
                            <option value="{{ $shopadmin[0]->id }}"> {{ $shopadmin[0]->ownername }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control"
                                required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" rows="2" cols="40" value="{{ old('address') }}" required
                                class="form-control"></textarea>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="">Product Category</label>
                            <select class="form-control" required value="{{ old('product_category_id') }}"
                                id="product_category_id" name="product_category_id">
                                <option value="" selected>Select Product Category</option>
                                @php
                                    $currentCategory = session('currentCategory');
                                    if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
                                        $product_category = DB::table('product_categories')
                                            ->where('shopadmin_id', $shopadmin[0]->id)
                                            ->where('shop_type', null)
                                            ->get();
                                    } else {
                                        $product_category = DB::table('product_categories')
                                            ->where('shopadmin_id', $shopadmin[0]->id)
                                            ->where('shop_type', session('currentCategory'))
                                            ->get();
                                    }
                                    
                                @endphp

                                @foreach ($product_category as $product)
                                    <option value="{{ $product->id }}"> {{ $product->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label class=" col-form-label text-danger">If New Supplier Category Add Here</label>
                            <button onclick="prevent()" class="btn form-control btn-warning btn-sm mr-1 " role="button"
                                data-toggle="modal" data-target="#addcategoryModal"><i class="fa fa-plus"></i> Add New
                                Supplier Category Name</button>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success" type="submit" name="add"><i class="fa fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
    </form>

    {{-- Add new category modal --}}
    <div class="modal fade " id="addcategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Add Supplier Category Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Supplier Category Name</label>
                                        <input type="text" id="name" name="name" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" onclick="add_category()" type="submit"
                        class="btn btn-primary">Add</button>
                </div>


            </div>
        </div>
    </div>


@section('script')

    <script>
        function prevent() {
            $('#form').submit(function(event) {
                event.preventDefault();
            });
        }


        function enable() {
            $("#form").unbind("submit");
        }


        function add_category() {
            $name = $('#name').val();

            $.ajax({
                url: '/add_category/' + $name,
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    // console.log(data);
                    if (data['status'] == "success") {
                        //notifier("Added successfully!!");
                        // console.log(data['category'])
                        // for (var i = 0; i < data['customers'].length; i++) {
                        $("#product_category_id").append('<option value=' + data['category'][0].id + '>' +
                            data['category'][0].name +
                            '</option>');
                        // $("#customer_dropdown").append("<option" +
                        //     "' value='" + data['customers'][i]['id'] + "'>" +
                        //     data['customers'][i]['name'] + "</option>");
                        // }

                        // '<option value=' + key + '>' + value + '</option>'
                        alert('Category Added Sucessfully');



                    } else {

                    }


                    $('#addcategoryModal').modal('hide');
                }

            });
        }
    </script>


@endsection

@stop
