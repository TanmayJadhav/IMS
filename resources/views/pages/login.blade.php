<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Login</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary" style="background: linear-gradient(45deg, #1bb1dc, #006d8c);">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5 mx-auto" style="max-width:500px">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <div class="text-center">
                                    <img src="init_logo.jpg" class="mx-auto" alt="">
                                </div>
                                <h1 class="h4 text-gray-900 mb-4">Inventory Management</h1>
                                <h1 class="h5 text-gray-900 mb-5 font-weight-light">Login</h1>
                            </div>
                            <form class="user" action="/" method="POST">
                                @csrf
                                
                                <div class="flash-message">
                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                    @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" name="username" required placeholder="Enter Your Mobile Number">
                                </div>
                                {{-- <div class="form-group">
                                    <input type="email" class="form-control form-control-user"aria-describedby="emailHelp" name="email" placeholder="Enter Your Email...">
                                </div> --}}
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" required placeholder="Password">
                                </div>
                                <input type="submit" value="Login" class="btn btn-primary btn-user btn-block">
                                <input type="submit" value="Forgot Password?" class="btn btn-warning btn-user btn-block">
                                <hr>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>