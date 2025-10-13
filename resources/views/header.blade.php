
<header>
    <div class="header-wrapper">
        <div class="control-buttons-wrapper">
            <div class="container">
                <div class="control-buttons">
                    <div class="phone-number"><a href="tel:+65 6904 8327"><i class="fa fa-phone" aria-hidden="true"></i><span>Call +65 6904 8327</span></a></div>
                    <div class="email"><a href="mailto:sales@tridentmarineasia.com"><i class="fa fa-envelope" aria-hidden="true"></i><span>sales@tridentmarineasia.com</span></a></div>
                    {{--<div class="login-region"><a href="#" data-toggle="modal" data-target="#loginModal">Login</a><a href="#" data-toggle="modal" data-target="#registerModal">Register</a></div>--}}
                    <div class="login-region">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <?php
                            $user = \Illuminate\Support\Facades\Auth::user();
                        ?>
                           <span class="welocmetext"> Hello, {{$user->name}}</span>
                            <span class="menu-item has-menu responsive_hide">
                                Account
                                <div class="dropdown">
                                    <a href="/my-account">My Profile</a>
                                    <a href="{{ url('upgrade-account') }}">Boat Owner Registration</a>
                                    <a href="{{ url('contact-us') }}">Feedback</a>
                                </div>
                            </span>
                            <span class="menu-item has-menu  responsive_hide">
                                My Charters
                                <div class="dropdown">
                                   <!-- <a href="{{ url('search/boat') }}">Charter a Boat</a> -->
                                    <a   href="{{ url('/my-credits') }}">My Credits</a>
                                    <a href="{{ url('my-bookings') }}">My Charter Listing</a>
                                </div>
                            </span>
                            <span class="menu-item has-menu  responsive_hide">
                                My Boats
                                <div class="dropdown">
                                    <a href="{{ url('my-boats') }}">My Boat Listing</a>
                                    <a href="{{ url('boat-book-calendar') }}">My Boat Calendar</a>
                                </div>
                            </span>
                            <a class="menu-item responsive_hide"  href="/logout" id="log-out">Logout</a>

                        <div class="dropdown show desktop_hide ">
                        <a class="btn border-0 dropdown-toggle text-white p-1" href="#" role="button" id="accountMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user text-white" aria-hidden="true"></i> Account
                        </a>

                        <div class="dropdown-menu" aria-labelledby="accountMenuLink">
                            <a class="dropdown-item" href="{{ url('my-account') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ url('upgrade-account') }}">Boat Owner Registration</a>
                            <a class="dropdown-item" href="{{ url('contact-us') }}">Feedback</a> 
                            <!--<a class="dropdown-item" href="{{ url('search/boat') }}">Charter a Boat</a>-->
                            <a class="dropdown-item" href="{{ url('/my-credits') }}">My Credits</a>
                            <a class="dropdown-item" href="{{ url('my-bookings') }}">My Charter Listing</a>
                            <a class="dropdown-item" href="{{ url('my-boats') }}">My Boat Listing</a> 
                            <a class="dropdown-item" href="{{ url('boat-book-calendar') }}">My Boat Calendar</a>
                            <a class="dropdown-item" href="{{ url('logout') }}">Logout</a> 
                        </div>
                        </div>
                    @else
                        <a href="#" id="loginpop" class="menu-item" data-toggle="modal" data-target="#loginModal">Login</a>
                        <a href="#" id="registerpop"  class="menu-item" data-toggle="modal" data-target="#registerModal">Register</a>
                        <a class="menu-item" href="/faq">FAQ</a>
                    @endif
		            </div>
                </div>
            </div>
        </div>
        <div class="menu-wrapper">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light"><a class="navbar-brand logo" href="/"><img src="{{ url('images/logo.png') }}" alt="Trident Marine Asia"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#pageNav" aria-controls="pageNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="pageNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item menu-item trident-fleet active"><a href="/search/boat">TRIDENT FLEET</a>
                                <div class="trident-fleet-filter">
                                    <div class="trident-fleet-item"><a href="/trident-fleet/Monohull"><img src="../images/nav-trident-fleet/1.png">
                                            <p>MONOHULL</p></a></div>
                                    <div class="trident-fleet-item"><a href="/trident-fleet/Catamaran"><img src="../images/nav-trident-fleet/2.png">
                                            <p>CATAMARAN</p></a></div>
                                    <div class="trident-fleet-item"><a href="/trident-fleet/Super Yacht"><img src="../images/nav-trident-fleet/3.png">
                                            <p>SUPER YACHTS</p></a></div>
                                </div>
                            </li>
                            <li class="nav-item menu-item"><a href="/trident-experiences">TRIDENT EXPERIENCES</a></li>
                            <li class="nav-item menu-item"><a href="/f&b">F&B</a></li>
                            <!-- <li class="nav-item menu-item"><a href="/trident-life-style">TRIDENT LIFESTYLE</a></li>-->
                            <!-- <li class="nav-item menu-item"><a href="/yacht-brokerage">YACHT BROKERAGE</a></li>-->
                            <li class="nav-item menu-item"><a href="/yacht-management">YACHT MANAGEMENT</a></li>
                            <!--<li class="nav-item menu-item"><a href="#">BOOKING CALENDAR</a></li>-->
                            <li class="nav-item menu-item"><a href="/contact-us">CONTACT US</a></li>
                            @if(\Illuminate\Support\Facades\Auth::check())
                            <li class="nav-item menu-item"><a  href="{{ url('logout') }}">LOGOUT</a> </li>
                            @endif
                            <li class="nav-item menu-item invisible"><a href="/trident-life-style">TRIDENT LIFESTYLE</a></li>
                            <li class="nav-item menu-item invisible"><a href="/yacht-brokerage">YACHT BROKERAGE</a></li>
			                <li class="nav-item menu-item invisible"><a href="/yacht-brokerage">F&B</a></li>
			</ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

