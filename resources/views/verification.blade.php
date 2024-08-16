@extends('frontend.app')

@section('title')
    Verification
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

        <section class="login--area--wrapper">
            <div class="login--area--content">
                <h3 class="hero--text">Enter Your Redeem Code</h3>
                <form action="{{ route('otp-submit') }}" class="auth--form--wrapper" method="POST">
                    @csrf
                    <div class="input--wrapper">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        
                            <input type="password" name="verification" placeholder="******">
                            @error('verification')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        
                    </div>
                    <button type="submit" class="submit--btn">Submit</button>

                </form>
            </div>
        </section>
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
