@extends('template')

@section('main')

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="row flex-lg-nowrap">

            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
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
                                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a
                                                href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        </p>
                                    @endif
                                @endforeach
                                <div class="e-profile">
                                    <form method="POST" action="/profile/edit/{{ $shopadmin[0]->id }}" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-sm-auto mb-3">
                                                <div class="mx-auto" style="width: 150px;">
                                                    <div class="d-flex justify-content-center align-items-center rounded"
                                                        style="height: 150px; border-style: solid; border-color: rgb(66, 111, 235);">
                                                        <span ><img src="/uploads/profile/{{$shopadmin[0]->id}}.{{$shopadmin[0]->image_ext}}" height="120" width="140" alt=""></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap text-primary">
                                                        {{ $shopadmin[0]->shop->name }}
                                                    </h4>
                                                    <span>Upload Profile Image <small class="text-danger">(Upload Image of size below 120x140.Upload PNG Image if possible)</small></span>
                                                    <div class="mt-2">
                                                        <input class="btn btn-primary" type="file" name="profilephoto">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="" class="active nav-link">Profile</a></li>
                                        </ul>
                                        <div class="tab-content pt-3">
                                            <div class="tab-pane active">

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Owner Name</label>
                                                                    <input class="form-control" type="text" name="ownername"
                                                                        value="{{ $shopadmin[0]->ownername }}">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Mobile Number</label>
                                                                    <input class="form-control" type="number"
                                                                        name="username" disabled
                                                                        value="{{ $shopadmin[0]->mobile }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input class="form-control" type="text"
                                                                        placeholder="user@example.com">
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        {{-- <div class="row">
                                                            <div class="col mb-3">
                                                                <div class="form-group">
                                                                    <label>About</label>
                                                                    <textarea class="form-control" rows="5"
                                                                        placeholder="My Bio"></textarea>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 ">

                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Shop Name</label>
                                                                    <input class="form-control" name="shopname" type="text"
                                                                        value="{{ $shopadmin[0]->shop->name }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 ">
                                                        <div class="mb-2"><b>Change Password</b></div>
                                                        <div class="row">
                                                            {{-- <div class="col">
                                                                <div class="form-group">
                                                                    <label>Current Password</label>
                                                                    <input class="form-control" type="password">
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>New Password</label>
                                                                    <input class="form-control" type="password"
                                                                        name="password">
                                                                </div>
                                                            </div>


                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Confirm Password</label>
                                                                    <input class="form-control" type="password"
                                                                        name="confirmpassword">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row  mt-3">
                                                        <div class="col-6">
                                                            <div class="mx-auto" style="width: 350px;">
                                                                <div class="d-flex justify-content-center align-items-center rounded"
                                                                    style="height: 150px; border-style: solid; border-color: rgb(66, 111, 235);">
                                                                    <span ><img src="/uploads/signature/{{$shopadmin[0]->id}}.{{$shopadmin[0]->signature_image_ext}}" height="120" width="140" alt="signature"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                            <div class="text-center text-sm-left mt-3">
                                                                
                                                                <span>Upload Signature <small class="text-danger">(Upload PNG Image if possible)</small></span>
                                                                <div class="mt-2">
                                                                    <input class="btn btn-primary" type="file" name="signaturephoto">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center mt-5">
                                                            <button class="btn btn-primary" type="submit">Save
                                                                Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>




@stop
