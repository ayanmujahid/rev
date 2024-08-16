@extends('frontend.app')

@section('title')
    Thankyou
@endsection

@push('style')
    <style>
        .extended--footer .extra--wrapper {
            display: none;
        }

        .extended--footer {
            padding-top: 70px !important;
        }
        .newsletter-thankyou a {
    border: 2px solid #fdfe0d;
    color: #fdfe0d;
    display: inline-block;
    margin-top: 30px;
    padding: 14px 40px;
    border-radius: 30px;
}
    </style>
@endpush
@section('content')
    <main>

        
        <div class="newsletter-thankyou">
            <div class="container">
                <h1>Thank You for Subscribing!</h1>
        <p>Your subscription to our newsletter is now confirmed. You can look forward to receiving exciting updates, exclusive content, and valuable insights right in your inbox.</p>
        <a href="{{ route('homepage') }}">Back To Home</a>
            </div>
        </div>
        
    </main>
@endsection
@section('css')
    <style type="text/css">
        /*in page css here*/
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        (() => {
            /*in page js here*/
        })()
    </script>
@endsection
