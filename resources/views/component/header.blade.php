<div class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="nav_section">
                    <div class="navbar navbar-default navbar-static-top navbar-expand-md">
                        <div class="navbar-header">

                            <div class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('images/logo.svg') }}"
                                        alt="Logo" /></a>
                            </div>

                        </div>
                        <nav class="navbar navbar-expand-lg navbar-light navbar-desktop">
                            <div class="container-fluid">
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('know') }}">know us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('service') }}">service</a>
                                        </li>
                                        <!-- <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="{{ route('service') }}"
                                                id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Services
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                <li><a class="dropdown-item" href="{{ route('service') }}">Services</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">About Us</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('contact') }}">Contact</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Other</a></li>
                                                <li>
                                                    <div class="dropdown-item" href="#">
                                                        <form method="POST" action="{{ route('logout') }}">
                                                            @csrf
                                                            <button type="submit" style="background-color: red; color: white; padding: 5px;">Logout</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="mobile_menu d-block d-md-none"><a href="#" id="menu__opener"></a></div>
                </div><!--nav_section-->
            </div>
        </div>
    </div>
</div>


<div class="sidebar_content hidden" id="sidebar_content">
    <div class="menu-overlay"></div>
    <div class="sidebar_content">
        <a href="#" id="sidebar_hide"></a>
        <div class="sidebar_content_inner">
            <div class="panner_top normalLogin">
                <div class="logo">
                    <!-- <a href="index.html"><img src="images/Logo.svg" alt="Logo" /></a> -->
                </div>

            </div><!--normalLogin-->
            <div id="mobile_nav_wrapper">
                <div class="common-nav-bar">
                    <nav class="navbar navbar-light">
                        <div class="container-fluid">
                            <div class="" id="">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Know Us</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle dts-arrow" href="#" id="" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Services
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="">
                                            <li><a class="dropdown-item" href="about-us.html">Service 1</a></li>
                                            <li><a class="dropdown-item" href="#">Service 2</a></li>
                                            <li><a class="dropdown-item" href="#">Service 3</a></li>
                                            <li><a class="dropdown-item" href="#">Service 4</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div> <!--common-nav-bar-->
            </div>
        </div><!--sidebar_content_inner-->

    </div><!--sidebar_content-->

</div><!--sidebar_content-->