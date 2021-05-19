<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pico App</title>

    <link rel="icon" type="image/svg" sizes="16x16" href="vendor/fontawesome-free/svgs/solid/cubes.svg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<style>
    html,body {
        height: 100%;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<body class="bg-gradient-primary text-center">

    <div class="container">

        <div class="row justify-content-center ">
            <div class="login-brand-icon">
                {{-- <i class="fas fa-cubes"></i> --}}
            </div>
            <h1 class="text-white">Pico Cluster App</h1>
        </div>

        <div class="row justify-content-center ">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-lg my-5">

                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="pt-5">
                                <h1 class="text-gray-900 mb-4">Login</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="p-5">

                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                    <div class="form-group">
                                        <input id="username" type="text" name="username" placeholder="Username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" name="password" placeholder="Password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            required autocomplete="current-password">

                                         @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary btn-user btn-block"> {{ __('Login') }}
                                        </div>
                                    </div>
                                </form>
                             </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="pt-2">
                                <h6 class="h6 text-gray-600 mb-4">Forgot password? Contact your system administrator.</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
