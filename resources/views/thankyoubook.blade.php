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
    </style>
@endpush
@section('content')
    <main>

        
        <div class="newsletter-thankyou">
            <div class="container">
                <h1>Thank You</h1>
        <p>Your meeting is schedule.</p>
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
