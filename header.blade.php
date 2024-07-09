<!-- Header Area -->
<header class="header_area">
    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-6">
                    <div class="welcome-note">
                        @php
                            $settings = DB::table('settings')->get();
                        @endphp
                        <div class="contact-info">
                            <span class="text">
                                <i class="ti-headphone-alt"></i>@foreach($settings as $data) {{$data->phone}} @endforeach
                            </span>
                        </div>
                        <div class="contact-info">
                            <span class="text">
                                <i class="ti-email"></i>@foreach($settings as $data) {{$data->email}} @endforeach
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <div class="topbar-info">
                        <ul class="list-inline mb-0">
                            @auth 
                                @if(Auth::user()->role == 'admin')
                                    <li class="list-inline-item"><i class="ti-user"></i><a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                                @else 
                                    <li class="list-inline-item"><i class="ti-user"></i><a href="{{route('user')}}" target="_blank">Dashboard</a></li>
                                @endif
                                <li class="list-inline-item"><i class="ti-power-off"></i><a href="{{route('user.logout')}}">Logout</a></li>
                            @else
                                <li class="list-inline-item"><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a><a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Menu -->
    <div class="bigshop-main-menu">
        <div class="container">
            <div class="classy-nav-container breakpoint-off">
                <nav class="classy-navbar" id="bigshopNav">

                    <!-- Nav Brand -->
                    <a href="{{route('home')}}" class="nav-brand"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo"></a>

                    <!-- Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav -->
                        <div class="classynav">
                            <ul>
                                <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li>
                                <li class="{{ in_array(Request::path(), ['product-grids', 'product-lists']) ? 'active' : '' }}"><a href="{{ route('product-grids') }}">Products</a></li>
                                {{ Helper::getHeaderCategory() }}
                                <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>
                                <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Hero Meta -->
                    <div class="hero_meta_area ml-auto d-flex align-items-center justify-content-end">
                        <!-- Search -->
                        <div class="search-area">
                            <div class="search-btn"><i class="icofont-search"></i></div>
                            <!-- Form -->
                            <div class="search-form">
                                <form method="POST" action="{{route('product.search')}}">
                                    @csrf
                                    <input name="search" placeholder="Search Products Here....." type="search">
                                    <button class="btnn" type="submit"><i class="ti-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Wishlist -->
                        <div class="wishlist-area">
                            <a href="{{route('wishlist')}}" class="wishlist-btn"><i class="icofont-heart"></i><span class="total-count">{{Helper::wishlistCount()}}</span></a>
                        </div>

                        <!-- Cart -->
                        <div class="cart-area">
                            <div class="cart--btn"><i class="icofont-cart"></i><span class="cart_quantity">{{Helper::cartCount()}}</span></div>
                            <!-- Cart Dropdown Content -->
                            @auth
                                <div class="cart-dropdown-content">
                                    <ul class="cart-list">
                                        @foreach(Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo = explode(',', $data->product['photo']);
                                            @endphp
                                            <li>
                                                <div class="cart-item-desc">
                                                    <a href="#" class="image">
                                                        <img src="{{$photo[0]}}" class="cart-thumb" alt="{{$photo[0]}}">
                                                    </a>
                                                    <div>
                                                        <a href="{{route('product-detail', $data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a>
                                                        <p>{{$data->quantity}} x - <span class="price">${{number_format($data->price, 2)}}</span></p>
                                                    </div>
                                                </div>
                                                <span class="dropdown-product-remove"><i class="icofont-bin"></i></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="cart-pricing my-4">
                                        <ul>
                                            <li>
                                                <span>Total:</span>
                                                <span>${{number_format(Helper::totalCartPrice(), 2)}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="cart-box">
                                        <a href="{{route('checkout')}}" class="btn btn-primary d-block">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                        </div>

                        <!-- Account -->
                        <div class="account-area">
                            @auth
                                <div class="user-thumbnail">
                                    <img src="img/bg-img/user.jpg" alt="">
                                </div>
                                <ul class="user-meta-dropdown">
                                    <li class="user-title"><span>Hello,</span> {{ Auth::user()->name }}</li>
                                    <li><a href="{{route('user')}}"><i class="ti-user"></i> Dashboard</a></li>
                                    <li><a href="{{route('order.track')}}">Track Order</a></li>
                                    <li><a href="{{route('wishlist')}}">Wishlist</a></li>
                                    <li><a href="{{route('user.logout')}}"><i class="icofont-logout"></i> Logout</a></li>
                                </ul>
                            @else
                                <ul class="user-meta-dropdown">
                                    <li><a href="{{route('login.form')}}">Login</a></li>
                                    <li><a href="{{route('register.form')}}">Register</a></li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header Area End -->
