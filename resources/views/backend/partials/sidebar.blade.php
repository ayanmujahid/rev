@php
    function isActiveRoute($routeNames, $output = 'active')
    {
        foreach ((array) $routeNames as $routeName) {
            if (Route::currentRouteName() == $routeName) {
                return $output;
            }
        }
        return null;
    }

    function areActiveRoutes($routeNames, $output = 'active')
    {
        foreach ((array) $routeNames as $routeName) {
            if (Route::currentRouteName() == $routeName) {
                return $output;
            }
        }
        return null;
    }
@endphp
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ isActiveRoute(['dashboard']) }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-house-fill menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>


        {{-- Mainstream Menu  --}}
        <li class="nav-item {{ isActiveRoute(['mainstream.entertainment.index']) }}">
            <a class="nav-link" href="{{ route('mainstream.entertainment.index') }}">
                <i class="bi bi-joystick menu-icon"></i>
                <span class="menu-title">Mainstream</span>
            </a>
        </li>
        {{-- Promotions Menu  --}}
        <li class="nav-item {{ isActiveRoute(['product.promotion.index']) }}">
            <a class="nav-link" href="{{ route('product.promotion.index') }}">
                <i class="bi bi-gift menu-icon"></i>
                <span class="menu-title">Promotions</span>
            </a>
        </li>

        {{-- Product Category Menu --}}
        <li class="nav-item {{ isActiveRoute(['productcategory.index']) }}">
            <a class="nav-link" href="{{ route('productcategory.index') }}">
                <i class="bi bi-tag menu-icon"></i>
                <span class="menu-title">Product Category</span>
            </a>
        </li>
        
         {{-- This is for Subscribes Module in Admin Panel --}}
        <li class="nav-item {{ isActiveRoute(['user.index']) }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="bi bi-person-plus menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
        
        {{-- schedule a meeting --}}
        <li class="nav-item {{ isActiveRoute(['schedule.index']) }}">
            <a class="nav-link" href="{{ route('schedule.index') }}">
                <i class="bi bi-tag menu-icon"></i>
                <span class="menu-title">Schedule A Meeting</span>
            </a>
        </li>

        {{-- Product Menu --}}
        <li class="nav-item {{ isActiveRoute(['product.index']) }}">
            <a class="nav-link" href="{{ route('product.index') }}">
                <i class="bi bi-cart3 menu-icon"></i>
                <span class="menu-title">Product</span>
            </a>
        </li>

        {{-- Order Menu --}}
        <li class="nav-item {{ isActiveRoute(['order.index']) }}">
            <a class="nav-link" href="{{ route('order.index') }}">
                <i class="bi bi-truck menu-icon"></i>
                <span class="menu-title">Orders</span>
            </a>
        </li>

        {{-- Affiliate Subscriber --}}
        <li class="nav-item {{ isActiveRoute(['affiliate_subscriber.index']) }}">
            <a class="nav-link" href="{{ route('affiliate_subscriber.index') }}">
                <i class="bi bi-truck menu-icon"></i>
                <span class="menu-title">Affiliate Subscriber</span>
            </a>
        </li>


        {{-- Affiliate Subscriber --}}
        <li class="nav-item {{ isActiveRoute(['claim_request.index']) }}">
            <a class="nav-link" href="{{ route('claim_request.index') }}">
                <i class="bi bi-truck menu-icon"></i>
                <span class="menu-title">Affiliate Claim Request</span>
            </a>
        </li>

        {{-- FAQ Menu --}}
        <li class="nav-item {{ isActiveRoute(['faq.index']) }}">
            <a class="nav-link" href="{{ route('faq.index') }}">
                <i class="bi bi-question-circle menu-icon"></i>
                <span class="menu-title">FAQ</span>
            </a>
        </li>
        {{-- Happy Users Menu --}}
        <li class="nav-item {{ isActiveRoute(['happyuser.index']) }}">
            <a class="nav-link" href="{{ route('happyuser.index') }}">
                <i class="bi bi-emoji-laughing menu-icon"></i>
                <span class="menu-title">Happy Users</span>
            </a>
        </li>

        {{-- Announcement Menu --}}
        <li class="nav-item {{ isActiveRoute(['announcement.index']) }}">
            <a class="nav-link" href="{{ route('announcement.index') }}">
                <i class="bi bi-megaphone menu-icon"></i>
                <span class="menu-title">Announcement</span>
            </a>
        </li>

        {{-- Upcoming Project Menu --}}
        <li class="nav-item {{ isActiveRoute(['upcomingproject.index']) }}">
            <a class="nav-link" href="{{ route('upcomingproject.index') }}">
                <i class="bi bi-folder-plus menu-icon"></i>
                <span class="menu-title">Upcoming Project</span>
            </a>
        </li>

        {{-- Campaign Menu --}}
        <li class="nav-item {{ isActiveRoute(['campaign.index']) }}">
            <a class="nav-link" href="{{ route('campaign.index') }}">
                <i class="bi bi-award menu-icon"></i>
                <span class="menu-title">Campaign</span>
            </a>
        </li>

        {{-- Pre Order Products Menu --}}
        <li class="nav-item {{ isActiveRoute(['pre_order_product.index']) }}">
            <a class="nav-link" href="{{ route('pre_order_product.index') }}">
                <i class="bi bi-calendar2-check menu-icon"></i>
                <span class="menu-title">Pre Order Products</span>
            </a>
        </li>

        {{-- Pre Order Special Menu --}}
        <li class="nav-item {{ isActiveRoute(['pre_order_special.index']) }}">
            <a class="nav-link" href="{{ route('pre_order_special.index') }}">
                <i class="bi bi-gift menu-icon"></i>
                <span class="menu-title">Pre Order Special</span>
            </a>
        </li>

        {{-- Pre Order Sales Goals --}}
        <li class="nav-item {{ isActiveRoute(['sales.goal.index']) }}">
            <a class="nav-link" href="{{ route('sales.goal.index') }}">
                <i class="bi bi-cash menu-icon"></i>
                <span class="menu-title">Sales Target</span>
            </a>
        </li>

        {{-- Page Samples Menu --}}
        <li class="nav-item {{ isActiveRoute(['page_sample.index']) }}">
            <a class="nav-link" href="{{ route('page_sample.index') }}">
                <i class="bi bi-file-earmark-text menu-icon"></i>
                <span class="menu-title">Page Samples</span>
            </a>
        </li>

        {{-- Latest Video Menu --}}
        <li class="nav-item {{ isActiveRoute(['latest_video.index']) }}">
            <a class="nav-link" href="{{ route('latest_video.index') }}">
                <i class="bi bi-play-btn menu-icon"></i>
                <span class="menu-title">Latest Video</span>
            </a>
        </li>
        
        
        {{-- Gifts Menu --}}
        <li class="nav-item {{ isActiveRoute(['gifts.index']) }}">
            <a class="nav-link" href="{{ route('gifts.index') }}">
                <i class="bi bi-play-btn menu-icon"></i>
                <span class="menu-title">Gifts Products</span>
            </a>
        </li>

        {{-- This is for Subscribes Module in Admin Panel --}}
        <li class="nav-item {{ isActiveRoute(['subscribes.index']) }}">
            <a class="nav-link" href="{{ route('subscribes.index') }}">
                <i class="bi bi-person-plus menu-icon"></i>
                <span class="menu-title">Subscribes</span>
            </a>
        </li>

        {{-- Settings  --}}
        <li class="nav-item nav-category">Settings</li>

        <li
            class="nav-item {{ areActiveRoutes(['settings.system', 'settings.mail', 'settings.social-media', 'settings.dynamic-page', 'setting.stripe-index'], 'active show') }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#e-commerce" aria-expanded="false"
                aria-controls="e-commerce">
                <i class="menu-icon bi bi-gear-fill"></i>
                <span class="menu-title">Settings</span>
                <i class="bi bi-menu-arrow"></i>
            </a>
            <div class="collapse {{ areActiveRoutes(['settings.system', 'settings.mail', 'settings.social-media', 'settings.dynamic-page', 'setting.stripe-index'], 'show') }}"
                id="e-commerce">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ isActiveRoute(['settings.system']) }}"
                            href="{{ route('system.setting') }}">System Settings</a></li>

                    <li class="nav-item"><a class="nav-link {{ isActiveRoute(['settings.mail']) }}"
                            href="{{ route('mailsetting') }}">Mail Setting</a></li>

                    <li class="nav-item"><a class="nav-link {{ isActiveRoute(['settings.social-media']) }}"
                            href="{{ route('socialmedia') }}">Social Media</a></li>

                    <li class="nav-item"><a class="nav-link {{ isActiveRoute(['settings.dynamic-page']) }}"
                            href="{{ route('dynamic_page') }}">Add Dynamic Page</a></li>

                    <li class="nav-item"><a class="nav-link {{ isActiveRoute(['setting.stripe-index']) }}"
                            href="{{ route('stripe.index') }}">Stripe</a></li>
                </ul>
            </div>
        </li>
        {{-- Profile Setting --}}
        <li class="nav-item {{ isActiveRoute(['profilesetting']) }}">
            <a class="nav-link" href="{{ route('profilesetting') }}">
                <i class="bi bi-person-lines-fill menu-icon"></i>
                <span class="menu-title">Profile Setting</span>
            </a>
        </li>
    </ul>
</nav>
