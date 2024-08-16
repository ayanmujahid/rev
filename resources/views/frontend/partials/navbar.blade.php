@php
    $setting = App\Models\SystemSetting::first();
@endphp

<style>
    .user-name {
        color: white;
        font-size: 16px;
        text-decoration: underline;
        transition: all 0.3s;
        text-align: center;
        display: flex;
    }

    .user-name:hover {
        color: #FDFE0D;
    }


    .active a {
        color: #FDFE0D !important;
        font-weight: 700 !important;
    }

</style>

<header>
    <div class="container">
        <div class="header--content--area--wrapper">
            <!-- hamburger icon -->
            <div class="hamburger--icon">
                {{-- open svg --}}
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#e0ff00" fill-rule="evenodd" d="M3 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm0 6a1 1 0 0 1 1-1h10a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm0 6a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1z" clip-rule="evenodd" opacity="1" data-original="#000000" class=""></path></g></svg>

                {{-- closed svg --}}
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 329.269 329" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M194.8 164.77 323.013 36.555c8.343-8.34 8.343-21.825 0-30.164-8.34-8.34-21.825-8.34-30.164 0L164.633 134.605 36.422 6.391c-8.344-8.34-21.824-8.34-30.164 0-8.344 8.34-8.344 21.824 0 30.164l128.21 128.215L6.259 292.984c-8.344 8.34-8.344 21.825 0 30.164a21.266 21.266 0 0 0 15.082 6.25c5.46 0 10.922-2.09 15.082-6.25l128.21-128.214 128.216 128.214a21.273 21.273 0 0 0 15.082 6.25c5.46 0 10.922-2.09 15.082-6.25 8.343-8.34 8.343-21.824 0-30.164zm0 0" fill="#eff500" opacity="1" data-original="#000000" class=""></path></g></svg>
            </div>
            <!-- logo area -->
            <div class="logo--wrapper">
                <a href="{{route('homepage')}}">
                    <img src="{{ asset('frontend/images/logo.svg') }}" alt="" />
                </a>
            </div>
            <!-- navbar links area -->
            <div class="menu--links--wrapper">
                <ul>
                    <li class="{{ request()->routeIs('homepage') ? 'active' : '' }}"><a href="{{ route('homepage') }}">HOME</a></li>
                    <li class="{{ request()->routeIs('whoweare') ? 'active' : '' }}"><a href="{{ route('whoweare') }}">WHO WE ARE</a></li>
                    <li class="{{ request()->routeIs('continuity') ? 'active' : '' }}"><a href="{{ route('continuity') }}">CONTINUITY</a></li>
                    <li class="{{ request()->routeIs('affiliate') ? 'active' : '' }}"><a href="{{ route('affiliate') }}">AFFILIATE</a></li>
                    <li class="{{ request()->routeIs('campaign') ? 'active' : '' }}"><a href="{{ route('campaign') }}">CAMPAIGN</a></li>
                    <li class="{{ request()->routeIs('shop.category') ? 'active' : '' }}"><a href="{{ route('shop.category')}}">SHOP</a></li>
                    <li class="{{ request()->routeIs('post.index') ? 'active' : '' }}"><a href="{{ route('post.index')}}">COMMUNITY</a></li>
                    <li class="{{ request()->routeIs('announcement') ? 'active' : '' }}"><a href="{{ route('announcement') }}">ANNOUNCEMENTS</a></li>
                </ul>
            </div>
            <!-- button area -->
            <div class="button--area--wrapper">
                <!-- cart  -->
                <a href="#" class="cart--icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 22"
                        fill="none">
                        <path
                            d="M7.7325 14.0627H7.73362C7.73456 14.0627 7.7355 14.0625 7.73639 14.0625H20.4844C20.6372 14.0625 20.7858 14.0127 20.9077 13.9207C21.0297 13.8287 21.1184 13.6994 21.1604 13.5525L23.9729 3.7088C24.0028 3.60417 24.008 3.49404 23.9881 3.38707C23.9682 3.28009 23.9238 3.17919 23.8583 3.0923C23.7927 3.0054 23.7079 2.9349 23.6105 2.88635C23.5131 2.8378 23.4057 2.81252 23.2969 2.8125H6.11095L5.60836 0.550594C5.57363 0.39442 5.48668 0.254756 5.36188 0.154656C5.23707 0.0545557 5.08186 2.16079e-06 4.92187 0L0.703125 0C0.314766 0 0 0.314766 0 0.703125C0 1.09148 0.314766 1.40625 0.703125 1.40625H4.35792C4.44689 1.80703 6.76317 12.2305 6.89648 12.8302C6.14925 13.155 5.625 13.9001 5.625 14.7656C5.625 15.9287 6.57131 16.875 7.73437 16.875H20.4844C20.8727 16.875 21.1875 16.5602 21.1875 16.1719C21.1875 15.7835 20.8727 15.4688 20.4844 15.4688H7.73437C7.34672 15.4688 7.03125 15.1533 7.03125 14.7656C7.03125 14.3785 7.34564 14.0636 7.7325 14.0627ZM22.3647 4.21875L19.9539 12.6562H8.29837L6.42337 4.21875H22.3647ZM7.03125 18.9844C7.03125 20.1475 7.97756 21.0938 9.14062 21.0938C10.3037 21.0938 11.25 20.1474 11.25 18.9844C11.25 17.8213 10.3037 16.875 9.14062 16.875C7.97756 16.875 7.03125 17.8213 7.03125 18.9844ZM9.14062 18.2812C9.52828 18.2812 9.84375 18.5967 9.84375 18.9844C9.84375 19.372 9.52828 19.6875 9.14062 19.6875C8.75297 19.6875 8.4375 19.372 8.4375 18.9844C8.4375 18.5967 8.75297 18.2812 9.14062 18.2812ZM16.9687 18.9844C16.9687 20.1475 17.9151 21.0938 19.0781 21.0938C20.2412 21.0938 21.1875 20.1474 21.1875 18.9844C21.1875 17.8213 20.2412 16.875 19.0781 16.875C17.9151 16.875 16.9687 17.8213 16.9687 18.9844ZM19.0781 18.2812C19.4658 18.2812 19.7812 18.5967 19.7812 18.9844C19.7812 19.372 19.4658 19.6875 19.0781 19.6875C18.6905 19.6875 18.375 19.372 18.375 18.9844C18.375 18.5967 18.6905 18.2812 19.0781 18.2812Z"
                            fill="#FFFFEB" />
                    </svg>

                    <p class="items cart_items_number" id="cart-count">{{ session()->has('cart') ? count(session()->get('cart')) : '0' }}</p> 
                </a>

                <!-- login button -->
                @guest
                    <a href="{{ route('login') }}" class="btn--primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="140" height="49" viewBox="0 0 140 49"
                            fill="none">
                            <path
                                d="M17.4295 1C5.95433 1 -2.01675 12.4233 1.943 23.1936L7.09013 37.1937C9.47696 43.6857 15.6597 48 22.5766 48H117.423C124.34 48 130.523 43.6857 132.91 37.1937L138.057 23.1937C142.017 12.4233 134.046 1 122.57 1H17.4295Z"
                                fill="#FDFE0D" stroke="url(#paint0_linear_4513_1248)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_1248" x1="-61.7234" y1="87.75" x2="184.297"
                                    y2="56.57" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFE0D" />
                                    <stop offset="1" stop-color="white" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <p>LOG IN</p>
                    </a>
                @endguest

                @auth
                    <div class="{{ request()->routeIs('userprofile') ? 'active' : '' }}">
                        <a class="user-name" href="{{ route('userprofile') }}">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn--secondary" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="140" height="48" viewBox="0 0 140 48"
                            fill="none">
                            <path
                                d="M17.4295 0.5C5.95433 0.5 -2.01675 11.9233 1.943 22.6936L7.09013 36.6937C9.47696 43.1857 15.6597 47.5 22.5766 47.5H117.423C124.34 47.5 130.523 43.1857 132.91 36.6937L138.057 22.6937C142.017 11.9233 134.046 0.5 122.57 0.5H17.4295Z"
                                fill="#050505" stroke="url(#paint0_linear_4513_2315)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_2315" x1="-61.7234" y1="87.25" x2="184.297"
                                    y2="56.07" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFE0D" />
                                    <stop offset="1" stop-color="white" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <p>LOGOUT</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth


            </div>
        </div>
    </div>
</header>
