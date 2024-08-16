@extends('frontend.app')

@section('title')
    Dashboard
@endsection

@push('style')
    <style>
        .extended--footer .extra--wrapper {
            display: none;
        }

        .btn-primary {
            background: #0f0f00 !important;
            border: 1px solid !important;
            color: white !important;
            border-color: yellow !important;
        }

        .btn-primary:hover {
            background: rgb(253 254 13) !important;
            border: 1px solid !important;
            color: black !important;
        }
    </style>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-control {
            color: black !important;
        }
    </style>
@endpush

@push('script')
    <script>
        function copyToClipboard() {
            var copyText = document.querySelector('input[name="affiliate_link"]');
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
        }
    </script>
    <script>
        function openClaimModal() {
            document.getElementById('claimModal').style.display = "block";
        }

        function closeClaimModal() {
            document.getElementById('claimModal').style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById('claimModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">

    <style>
        .auth--form--wrapper .input--wrapper input {
            padding: 16px 32px;
            background-color: transparent;
            border-radius: 12px;
            border: 1px solid #0F0F00;
            color: #000;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 26.24px;
        }


        .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            color: white;
            background-color: transparent;
            background-clip: padding-box;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: 8px;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-control:focus {
            color: white;
            background-color: transparent;
            border-color: rgb(102, 102, 102);
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(79, 79, 79, 0.25);
        }

        .btn-primary {
            background: transparent;
            border: 1px solid;
        }

        .btn-primary:hover {
            background: rgb(102, 102, 102);
            border: 1px solid;
        }

        .modal-title {
            color: #fff;
            font-family: var(--font-oswald);
            font-size: 26px;
            font-weight: 700;
            text-align: center;
        }

        .active>.page-link,
        .page-link.active {
            z-index: 3;
            color: black;
            background-color: #FDFE0D;
            border-color: #FDFE0D;
        }

        .dropify-wrapper {
            background-color: #0F0F00 !important;
            color: #fff !important;
            border-color: #DEE2E6;
        }

        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush

@section('content')
    <main>
        <section class="product--categories--area--wrappper section--gap">
            <div class="container">
                <div class="container py-5">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-4" style="border-radius: 20px;">
                                <div class="card-body text-center">
                                    <div>
                                        <img src="{{ asset(Auth::user()->image ?? 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp') }}"
                                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                    </div>
                                    <h5 class="my-3">{{ Auth::user()->name }}</h5>
                                    <div class="d-flex justify-content-center mb-2" style="cursor: pointer;">
                                        <a class="btn--secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="140" height="48"
                                                viewBox="0 0 140 48" fill="none">
                                                <path
                                                    d="M17.4295 0.5C5.95433 0.5 -2.01675 11.9233 1.943 22.6936L7.09013 36.6937C9.47696 43.1857 15.6597 47.5 22.5766 47.5H117.423C124.34 47.5 130.523 43.1857 132.91 36.6937L138.057 22.6937C142.017 11.9233 134.046 0.5 122.57 0.5H17.4295Z"
                                                    fill="#050505" stroke="url(#paint0_linear_4513_2315)" />
                                                <defs>
                                                    <linearGradient id="paint0_linear_4513_2315" x1="-61.7234"
                                                        y1="87.25" x2="184.297" y2="56.07"
                                                        gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#FDFE0D" />
                                                        <stop offset="1" stop-color="white" />
                                                    </linearGradient>
                                                </defs>
                                            </svg>
                                            <p>Edit Profile</p>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            {{-- Start affiliate Product --}}


                            <div class="col-md-12">
                                {{-- Check authenticated user --}}
                                @if (auth()->check())
                                    {{-- Retrieve packages and orders --}}
                                    @php
                                        // Retrieve package associated with authenticated user's user_id
$package = \App\Models\Package::where('user_id', auth()->user()->id)->first();
                                    @endphp

                                    @if ($package && $package->affiliate_link)
                                        <div class="card mb-4 mb-md-0" style="border-radius: 20px;">
                                            <div class="card-body">
                                                <h4>Total Commissions: <strong class="text-success">${{number_format($commissions->sum('amount'),2)}}</strong></h4>
                                                @if($commissions->sum('amount')<100)
                                                <p class="mt-2 text-danger">You need to have atleast balance of $100 to submit withdrawal request</p>
                                                @else
                                                <button>Submit Withdrawal Request</button>
                                                @endif
                                                <button type="button">Submit Withdrawal Request</button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card mb-4 mb-md-0" style="border-radius: 20px;">
                                            <div class="card-body">
                                                <p class="mb-4" style="font-size: 18px; color: red;">Please subscribe to
                                                    the affiliate package to view your orders.</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>


                            {{-- End affiliate Product --}}

                        </div>

                        {{-- Modal for User profile update --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="background: var(--bg--deep); color: white;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Let’s share what going on your
                                            mind...
                                        </h5>
                                    </div>
                                    <form action="{{ route('update.profile') }}" method="POST" id="post"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="mb-4">
                                                <label for="name" class="col-form-label">Name:</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ Auth::user()->name ?? '' }}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tag" class="col-form-label">Email:</label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ Auth::user()->email ?? '' }}">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-4">
                                                <label for="title" class="col-form-label">Profile Picture:</label>
                                                <input type="file"
                                                    class="dropify form-control form-control-md border-left-0 @error('image') is-invalid @enderror"
                                                    name="image" id="image"
                                                    data-default-file="{{ isset(Auth::user()->image) ? asset(Auth::user()->image) : '' }}">
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn--secondary"
                                                style="background: var(--bg--deep); border:none;" data-bs-dismiss="modal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="140" height="48"
                                                    viewBox="0 0 140 48" fill="none">
                                                    <path
                                                        d="M17.4295 0.5C5.95433 0.5 -2.01675 11.9233 1.943 22.6936L7.09013 36.6937C9.47696 43.1857 15.6597 47.5 22.5766 47.5H117.423C124.34 47.5 130.523 43.1857 132.91 36.6937L138.057 22.6937C142.017 11.9233 134.046 0.5 122.57 0.5H17.4295Z"
                                                        fill="#050505" stroke="url(#paint0_linear_4513_2315)" />
                                                    <defs>
                                                        <linearGradient id="paint0_linear_4513_2315" x1="-61.7234"
                                                            y1="87.25" x2="184.297" y2="56.07"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FDFE0D" />
                                                            <stop offset="1" stop-color="white" />
                                                        </linearGradient>
                                                    </defs>
                                                </svg>
                                                <p>Close</p>
                                            </button>

                                            <button type="submit" class="btn--primary"
                                                style="background: var(--bg--deep); border:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="140" height="49"
                                                    viewBox="0 0 140 49" fill="none">
                                                    <path
                                                        d="M17.4295 1C5.95433 1 -2.01675 12.4233 1.943 23.1936L7.09013 37.1937C9.47696 43.6857 15.6597 48 22.5766 48H117.423C124.34 48 130.523 43.6857 132.91 37.1937L138.057 23.1937C142.017 12.4233 134.046 1 122.57 1H17.4295Z"
                                                        fill="#FDFE0D" stroke="url(#paint0_linear_4513_1248)"></path>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_4513_1248" x1="-61.7234"
                                                            y1="87.75" x2="184.297" y2="56.57"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FDFE0D"></stop>
                                                            <stop offset="1" stop-color="white"></stop>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>
                                                <p>Update</p>
                                            </button>
                                        </div>
                                        </from>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4 mb-md-20" style="border-radius: 20px;">
                                        <div class="card-body">
                                            <p class="mb-4" style="font-size: 18px;">Purchased Products</p>

                                            <ul class="list-group list-group-flush rounded-3">
                                                @foreach ($orders as $order)
                                                    @foreach ($order->carts as $cart)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 mb-2"
                                                            style="border: 1px solid #EFEFEF;">
                                                            <img class="img-fluid" style="width: 80px;"
                                                                src="{{ isset($cart->product->image) ? asset($cart->product->image) : '' }}">
                                                            <p style="margin-left:5px; padding:4px;" class="mb-0">
                                                                {{ $cart->product->title }}</p>
                                                            <p>${{ $cart->total_price }}</p>
                                                        </li>
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card mb-4 mb-4" style="border-radius: 20px;">
                                        <div class="card-body">
                                            <p class="mb-4" style="font-size: 18px;">Payment Pending </p>
                                            <ul class="list-group list-group-flush rounded-3">
                                                @foreach ($data as $data)
                                                    @foreach ($data->carts as $cart)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 mb-2"
                                                            style="border: 1px solid #EFEFEF;">
                                                            <img class="img-fluid" style="width: 80px;"
                                                                src="{{ isset($cart->image) ? asset($cart->image) : '' }}">
                                                            <p style="margin-left:5px; padding:4px;" class="mb-0">
                                                                {{ isset($cart->title) ? $cart->title : '--' }}</p>
                                                            <p>${{ $cart->total_price }}</p>
                                                        </li>
                                                        @if($data->payment_status == 'pending')
                                                        <a class="dropdown-item"
                                                        href="{{ route('remove-product', $data->id) }}"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Delete</a>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                    <div class="card mb-4 mb-md-20" style="border-radius: 20px;">
                                        <div class="card-body">
                                            <p class="mb-4" style="font-size: 18px;">Affiliate Links</p>
                                            <ul class="list-group list-group-flush rounded-3">
                                                @foreach ($links as $link)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3 mb-2"
                                                        style="border: 1px solid #EFEFEF;">
                                                        <p style="margin-left:5px; padding:4px;" class="mb-0"> {{ $link->user_code }} <button type="button" onclick="copyLink('{{$link->user_code}}')">Copy</button> <button type="button" onclick="gotoTree({{$link->id}})">View Tree</button></p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <br>
                                
                                <br>
                                @if (count($commissions))
                                    <div class="col-md-12" style="padding-top: 20px;">
                                        <div class="col-md-10">
                                            <div class="card mb-4 mb-md-0" style="border-radius: 20px;">
                                                <div class="card-body">
                                                    <p class="mb-4" style="font-size: 18px;">Commissions </p>
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Order Id</th>
                                                                <th>Affiliate Code</th>
                                                                <th>Commission Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($commissions as $key => $value)
                                                                <tr>
                                                                    <td>{{ ++$key }}</td>
                                                                    <td>{{ $value->order_id }}</td>
                                                                    <td>{{$value->shop_code}}</td>
                                                                    <td>${{ number_format($value->amount, 2) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script type="text/javascript" src="{{ asset('frontend/js/dropify.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
        async function copyLink(text){
            try {
                text = '{{route('affiliate-shop')}}/'+text
                await navigator.clipboard.writeText(text);
                console.log('Content copied to clipboard');
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }
        function gotoTree(id){
            window.location.href = '{{url('/')}}/user/view-tree/'+id
        }
    </script>
@endpush
