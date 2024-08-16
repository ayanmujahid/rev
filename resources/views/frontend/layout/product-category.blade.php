@extends('frontend.app')

@section('title')
Product Category
@endsection

@push('style')
<style>
    .btn-primary {
        --bs-btn-color: #fff;
        --bs-btn-bg: #0d6efd00;
        --bs-btn-border-color: #0d6efd00;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #0b5ed700;
        --bs-btn-hover-border-color: #0a58ca00;
        --bs-btn-focus-shadow-rgb: 49, 132, 253;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #0a58ca;
        --bs-btn-active-border-color: #0a53be;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #0d6efd;
        --bs-btn-disabled-border-color: #0d6efd;
    }

    .we--want--you--section--area--wrapper {
        padding-top: 80px;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 100px;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    .modal-dialog {
        position: relative;
        width: auto;
        pointer-events: none;
        max-width: 1000px !important;
        margin: auto;
    }

    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        width: 100% !important;
        max-width: unset !important;
    }

    /* @keyframes animatetop {
                                            from {top:-300px; opacity:0}
                                            to {top:0; opacity:1}
                                        } */
</style>
@endpush

@push('script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the URL has a hash (fragment identifier)
        if (window.location.hash) {
            // Scroll to the section with the ID from the hash
            document.querySelector(window.location.hash).scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>
<script>
    function openNewModal() {
        document.getElementById('myModal').style.display = 'block';
    }

    function closeNewModal() {
        $("#myModal").modal("hide")
    }

    window.onclick = function (event) {
        var modal = document.getElementById('myModal');
        if (event.target == modal) {
            modal.style.display = 'block';
        }
    }
</script>
@endpush

@section('content')
<main>
    {{-- banner area starts --}}
    <section class="shop--banner--area--wrapper">
        <div class="container">
            <div class="shop--banner--area--content">
                @if($selected_category)
    <h3 class="common--banner--title">{{ $selected_category->category_type }}</h3>
@else
    <h3 class="common--banner--title">All Products</h3>
@endif

                <a href="#shopnow" class="btn--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="205" height="67" viewBox="0 0 205 67" fill="none">
                        <path
                            d="M17.1908 1C5.64128 1 -2.33462 12.5605 1.76563 23.3577L13.9176 55.3577C16.3505 61.7642 22.49 66 29.3428 66H175.657C182.51 66 188.65 61.7642 191.082 55.3577L203.234 23.3577C207.335 12.5605 199.359 1 187.809 1H17.1908Z"
                            fill="#FDFE0D" stroke="url(#paint0_linear_4513_2955)" />
                        <defs>
                            <linearGradient id="paint0_linear_4513_2955" x1="-86.7979" y1="121.5" x2="266.381"
                                y2="75.2661" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FDFE0D" />
                                <stop offset="1" stop-color="white" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <p>SHOP NOW</p>
                </a>
            </div>
        </div>
    </section>
    {{-- banner area ends --}}


    {{-- latest produc area starts --}}
    
 <section id="latest-prouduct-area-wrapper" class="latest--prouduct--area--wrapper section--gap ctgr-pg">
     <div class="container">
     
        <div class="row filter-row">
                


                </div>
            

            <h3 class="affiliate--common-title">Category Products</h3>

            <div class="title-btn">
                <a href="{{ route('preoder.index') }}" class="btn--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="140" height="49" viewBox="0 0 140 49" fill="none">
                        <path
                            d="M17.4295 1C5.95433 1 -2.01675 12.4233 1.943 23.1936L7.09013 37.1937C9.47696 43.6857 15.6597 48 22.5766 48H117.423C124.34 48 130.523 43.6857 132.91 37.1937L138.057 23.1937C142.017 12.4233 134.046 1 122.57 1H17.4295Z"
                            fill="#FDFE0D" stroke="url(#paint0_linear_4513_1248)"></path>
                        <defs>
                            <linearGradient id="paint0_linear_4513_1248" x1="-61.7234" y1="87.75" x2="184.297"
                                y2="56.57" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FDFE0D"></stop>
                                <stop offset="1" stop-color="white"></stop>
                            </linearGradient>
                        </defs>
                    </svg>

                    <p>Preorder</p>
                </a>
            </div>

            <div class="popular--product--content">
            
    @foreach ($latest_product as $product)
        <div class="single--pouplar--product">
            <div class="img--wrapper">
                <img src="{{ Helper::getImage($product->image) }}" alt="{{ $product->title }}" />
            </div>

            <div class="description--wrapper">
                <p class="prod--title">{{ $product->title }}</p>

                <div class="pricing">
                    <p class="past">$ <span>{{ $product->original_price }}</span></p>
                    <p class="current">$ <span>{{ $product->discount_price }}</span></p>
                </div>
            </div>

            {{-- Add the hovering info and image sections here --}}
            <div class="product--hover--info">
                <div class="action--button--wrapper">
                    <a data-id="{{ $product->id }}" data-type="Shop" href="javascript:void(0)"
                        class="cart--btn add_cart">
                        <img src="{{ asset('frontend/images/cart-icon.svg') }}" alt="" />
                    </a>

                    {{-- <a href="javascript:void(0)" class="share--btn">
                        <img src="{{ asset('frontend/images/share-icon.svg') }}" alt="" />
                    </a> --}}
                </div>
                <h3 class="prod--title">{{ $product->title }}</h3>

                <div class="prod--pricing">
                    <p class="past">$ <span>{{ $product->original_price }}</span></p>
                    <p class="current">$ <span>{{ $product->discount_price }}</span></p>
                </div>
            </div>

            {{-- Hovering image --}}
            <div class="hovering--image">
                <img src="{{ asset($product->image) }}" />
            </div>
        </div>
    @endforeach

        </div>

                        </div>
</section>

</main>


{{-- dely popup end --}}
@endsection