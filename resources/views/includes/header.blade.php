<!--Main Navigation-->
<header class="">
    <!-- Jumbotron -->
    <div class=" text-center text-white" style="background-color: #131921">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
                    <a href="{{ route('homepage') }}" class="ms-md-2">
                        <img src="{{ asset('images/logos/logo_user.png') }}" class="img img-fluid" width="100px" />
                    </a>
                </div>

                <div class="col-md-4">
                    <form class="d-flex input-group w-auto my-auto mb-3 mb-md-0">
                        <input autocomplete="off" type="search" class="form-control rounded bg-white" placeholder=" Search Product" />
                        <span class="input-group-text border-0 d-none d-lg-flex" style="background-color: transparent"><i class="fa fa-search text-white"></i></span>
                    </form>
                </div>

                <div class="col-md-4 d-flex justify-content-center justify-content-md-end align-items-center">
                    <ul class="d-flex align-items-center">
                        <!-- Cart -->
                        <li class="nav-item">
                            <a class="text-reset me-3" href="{{ route('cart') }}">
                                <span><i class="fa fa-shopping-cart"></i></span>
                                <span class="badge rounded-pill badge-notification bg-danger">{{ count(session()->get('cart') ?? []) }}</span>
                            </a>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-cyan" aria-labelledby="navbarDropdownMenuLink-4">
                                <a class="dropdown-item" href="#">Facebook</a>
                                <a class="dropdown-item" href="#">Instagram</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-cyan" aria-labelledby="navbarDropdownMenuLink-4">
                                @auth
                                    <a class="dropdown-item" href="{{ route('my-account') }}">My Account</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                @endauth

                                @guest
                                        <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                        <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                    @endguest


                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #232f3e">
        <!-- Container wrapper -->
        <div class="container justify-content-center justify-content-md-between">
            <div></div>
            <button class="btn btn-outline-light border-white" type="button">
                Download app<i class="fa fa-download ms-2 ml-2"></i>
            </button>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->


</header>
<!--Main Navigation-->
