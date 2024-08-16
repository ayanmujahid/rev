@php
    $setting = App\Models\SystemSetting::first();
@endphp
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1"
    />
    <link rel="icon" type="image/x-icon" href="{{ $setting->favicon ?? 'frontend/images/logo.svg' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    {{-- Style --}}
    @include('frontend.partials.style')

</head>

<body>
    {{-- Navbar --}}
    @include('frontend.partials.navbar')
    {{-- Main Content --}}
    @yield('content')
    {{-- Footer Section --}}
    @include('frontend.partials.footer')
    {{-- Add to cart section --}}
    @include('frontend.partials.cart')
    {{-- Scripts --}}
    @include('frontend.partials.scripts')
</body>

</html>
