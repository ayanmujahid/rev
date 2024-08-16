@php
    $social_link = App\Models\SocialMedia::all();
    $pageData = App\Models\DynamicPage::where('status', 'active')->get();
    $setting = App\Models\SystemSetting::first();
@endphp

<footer class="extended--footer">
    <div class="extra--wrapper">
        <!-- we want section -->
        <div class="we--want--you--section--area--wrapper">
            <div class="container">
                <div class="we--want--you--content">
                    <div class="left">
                        <div class="img--wrapper">
                            <img src="{{ asset('frontend/images/we-want-you-intro.png') }}" alt="" />
                        </div>

                        <div class="join--btn">
                             <a href="https://revivals.hexatechhub.com/#scrollbtm" class="btn--secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="239" height="66"
                                    viewBox="0 0 239 66" fill="none">
                                    <path
                                        d="M17.1214 0.5C5.18075 0.5 -2.80622 12.7907 2.04386 23.702L16.2679 55.702C18.9163 61.6602 24.8251 65.5 31.3454 65.5H207.655C214.175 65.5 220.084 61.6602 222.732 55.702L236.956 23.702C241.806 12.7907 233.819 0.5 221.879 0.5H17.1214Z"
                                        fill="#0F0F00" stroke="url(#paint0_linear_4513_1474)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_4513_1474" x1="-102.074" y1="121"
                                            x2="308.762" y2="58.0481" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDFE0D" />
                                            <stop offset="1" stop-color="white" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <p>JOIN NOW</p>
                            </a>
                        </div>
                    </div>
                    <!-- banner image -->
                    <div class="banner--img">
                        <img src="{{ asset('frontend/images/robot.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer--content">
            <div class="footer--logo">
                <img src="{{ asset('frontend/images/logo.svg') }}" alt="" />
            </div>

            <div class="contact--us--wrapper">
                <h3>CONTACT US</h3>

                <div class="contact--btn--wrapper">
                    <a href="mailto:business@revivallaunch.com" class="btn--secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="144" height="48" viewBox="0 0 144 48"
                            fill="none">
                            <path
                                d="M17.1925 0.5C5.64247 0.5 -2.33346 12.0614 1.76767 22.8587L7.08524 36.8587C9.51837 43.2647 15.6576 47.5 22.5101 47.5H121.49C128.342 47.5 134.482 43.2647 136.915 36.8588L142.232 22.8587C146.333 12.0614 138.358 0.5 126.808 0.5H17.1925Z"
                                fill="#0F0F00" stroke="url(#paint0_linear_4513_1427)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_1427" x1="-64.0851" y1="87.25"
                                    x2="189.811" y2="54.0063" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFE0D" />
                                    <stop offset="1" stop-color="white" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <p>For Business</p>
                    </a>
                    <a href="mailto:support@revivallaunch.com" class="btn--secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="144" height="48" viewBox="0 0 144 48"
                            fill="none">
                            <path
                                d="M17.1925 0.5C5.64247 0.5 -2.33346 12.0614 1.76767 22.8587L7.08524 36.8587C9.51837 43.2647 15.6576 47.5 22.5101 47.5H121.49C128.342 47.5 134.482 43.2647 136.915 36.8588L142.232 22.8587C146.333 12.0614 138.358 0.5 126.808 0.5H17.1925Z"
                                fill="#0F0F00" stroke="url(#paint0_linear_4513_1427)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_1427" x1="-64.0851" y1="87.25"
                                    x2="189.811" y2="54.0063" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFE0D" />
                                    <stop offset="1" stop-color="white" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <p>For Support</p>
                    </a>
                    <a href="mailto:press@revivallaunch.com" class="btn--secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="144" height="48" viewBox="0 0 144 48"
                            fill="none">
                            <path
                                d="M17.1925 0.5C5.64247 0.5 -2.33346 12.0614 1.76767 22.8587L7.08524 36.8587C9.51837 43.2647 15.6576 47.5 22.5101 47.5H121.49C128.342 47.5 134.482 43.2647 136.915 36.8588L142.232 22.8587C146.333 12.0614 138.358 0.5 126.808 0.5H17.1925Z"
                                fill="#0F0F00" stroke="url(#paint0_linear_4513_1427)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_1427" x1="-64.0851" y1="87.25"
                                    x2="189.811" y2="54.0063" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFE0D" />
                                    <stop offset="1" stop-color="white" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <p>For Press</p>
                    </a>
                    <a href="mailto:eli@revivallaunch.com" class="btn--secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="144" height="48" viewBox="0 0 144 48"
                            fill="none">
                            <path
                                d="M17.1925 0.5C5.64247 0.5 -2.33346 12.0614 1.76767 22.8587L7.08524 36.8587C9.51837 43.2647 15.6576 47.5 22.5101 47.5H121.49C128.342 47.5 134.482 43.2647 136.915 36.8588L142.232 22.8587C146.333 12.0614 138.358 0.5 126.808 0.5H17.1925Z"
                                fill="#0F0F00" stroke="url(#paint0_linear_4513_1427)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_1427" x1="-64.0851" y1="87.25"
                                    x2="189.811" y2="54.0063" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFE0D" />
                                    <stop offset="1" stop-color="white" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <p>For Fans</p>
                    </a>
                </div>
            </div>

            <div class="footer--links--wrapper">
                <div class="footer--menu">
                    <ul>
                        <li class="{{ request()->routeIs('homepage') ? 'active' : '' }}"><a href="{{ route('homepage') }}">HOME</a></li>
                        <li class="{{ request()->routeIs('whoweare') ? 'active' : '' }}"><a href="{{ route('whoweare') }}">WHO WE ARE</a></li>
                        <li class="{{ request()->routeIs('continuity') ? 'active' : '' }}"><a href="{{ route('continuity') }}">CONTINUITY</a></li>
                        <li class="{{ request()->routeIs('affiliate') ? 'active' : '' }}"><a href="{{ route('affiliate') }}">AFFILIATE</a></li>
                        <li class="{{ request()->routeIs('campaign') ? 'active' : '' }}"><a href="{{ route('campaign') }}">CAMPAIGN</a></li>
                        <li class="{{ request()->routeIs('shop.category') ? 'active' : '' }}"><a href="{{ route('shop.category')}}">SHOP</a></li>
                        <li class="{{ request()->routeIs('post.index') ? 'active' : '' }}"><a href="{{ route('post.index')}}">COMMUNITY</a></li>
                        <li class="{{ request()->routeIs('announcement') ? 'active' : '' }}"><a href="{{ route('announcement') }}">ANNOUNCEMENTS</a></li>

                        @foreach ($pageData as $index => $item)
                            <li style=" text-transform: uppercase;" {{ request()->routeIs('custom.page', ['page_slug' => $item->page_slug]) ? 'active' : '' }}><a href="{{ route('custom.page', ['page_slug' => $item->page_slug]) }}">{{ $item->page_title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer--social--links">
                    <ul>
                        @foreach ($social_link as $index => $item)
                            <li class="cs-social-icon" style="font-size: 30px;">
                                <a href="{{ $item->profile_link }}" target="blank">
                                    <i style="color: white;" class="fa-brands fa-{{ $item->social_media }}"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="lower--footer">
                    <p>All Rights Reserved 2024.</p>
                    <p>Terms & Conditions</p>
                </div>
            </div>
        </div>
</footer>
