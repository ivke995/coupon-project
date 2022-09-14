<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Welcome</title>
        <!-- Favicon-->
        <link rel="icon" type="../dist/image/x-icon" href="../dist/assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('/dist/css/styles.css') }}" rel="stylesheet" />
        
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">Welcome Admin</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{route('coupon.create')}}">Create new coupon</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{route('coupon.active')}}">Active coupons</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{route('coupon.all')}}">All coupons</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{route('coupon.used')}}">Used coupons</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{route('coupon.non_used')}}">Non-used coupons</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{route('email.addresse')}}">Email addresses</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        {{-- <button class="btn btn-primary" id="home">Home</button> --}}
                        <a href="{{route('admin.dashboard')}}" class="btn btn-primary" id="home">Home</a>
                        {{-- <button class="btn btn-primary" id="logout">Logout</button> --}}
                        <a href="{{ route('auth.logout') }}" class="btn btn-primary" id="logout">Logout</a>

                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid">
                  {{$slot}}
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->

    </body>
</html>