@extends('frontend.app')

@section('title')
    Thank you
@endsection

@push('style')
    <style>
        .login--area--content {
            width: 100%;
            max-width: 915px;
            margin: 0 auto;
            border-radius: 24px;
            background: rgb(5 5 5 / 41%);
            box-shadow: 0px 15px 140px 0px rgb(0 0 0 / 0%);
            backdrop-filter: blur(4.5px);
            padding: 105px 56px;
        }

        .extended--footer .extra--wrapper {
            display: none;
        }

        .extended--footer {
            padding-top: 70px !important;
        }

        section.thankyou-pg {
            height: 100vh;
            background-color: #0f0f00;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        section.thankyou-pg h3 {
            font-size: 34px;
            line-height: 50px;
        }

        section.thankyou-pg h3 i {
            color: #fdfe0d;
            margin-left: 14px;
        }

        .thankyou-pg a {
            margin-top: 32px;
        }

        .thankyou-pg a p {
            width: 100%;
            text-transform: uppercase;
        }

        section.thankyou-pg::before {
            content: '';
            height: 100%;
            width: 100%;
            position: absolute;
            background-image: url(../frontend/images/logo.svg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: 500px;
            opacity: 0.1;
        }

        footer,
        header {
            display: none;
        }

        .log__btn {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .thankyou-pg a {
            margin-top: 0px;
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

        function shareToFacebook() {
            var affiliateLink = document.querySelector('input[name="affiliate_link"]').value;
            var url = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(affiliateLink);
            window.open(url, '_blank');
        }

        function shareToWhatsApp() {
            var affiliateLink = document.querySelector('input[name="affiliate_link"]').value;
            var url = "whatsapp://send?text=" + encodeURIComponent(affiliateLink);

            // Check if the device supports the whatsapp:// URI scheme
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                window.location.href = url;
            } else {
                toastr.error("WhatsApp sharing is supported only on mobile devices.");
            }
        }
    </script>
@endpush

@section('content')
    <main>
        {{-- landing hero area starts --}}
        <section class="thankyou-pg">
            <div class="container">
                {{-- <h3>Thank You for Successfully Subscribe<br> Check your Email<i class="fa fa-smile" aria-hidden="true"></i>
                </h3> --}}
                <div class="login--area--content">
                    <h3 class="hero--text">Thank You For Successfully Subscribing.<br> Your Affiliate Link</h3>
                    <div class="auth--form--wrapper">
                        <div class="input--wrapper">
                            {{-- <div class="container">
                                <h1>Your Affiliate Link</h1>
                                <p>Share this link with others to become your children:</p>
                                <input type="text" value="{{ $affiliateLink }}" readonly>
                            </div> --}}

                            <input type="text" placeholder="Your Affiliate Link" name="affiliate_link"
                                value="{{ $package->affiliate_link }}" readonly>
                            @error('affiliate_link')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <a href="{{ route('homepage') }}">Back To Home</a>
                            </div>
                            <div class="log__btn col-md-6">
                                <button type="submit" class="submit--btn" onclick="copyToClipboard()">Copy</button>
                                <button type="button" class="submit--btn" onclick="shareToFacebook()">Share on
                                    Facebook</button>
                                <button type="button" class="submit--btn" onclick="shareToWhatsApp()">Share on
                                    WhatsApp</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>









        {{-- landing hero area ends --}}




    </main>
@endsection
