@extends('frontend.app')

@section('title')
    Pre Order
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
                <h3 class="hero--text">Affiliate Code Generator</h3>
                <form action="{{ route('code-verification') }}" method="POST" class="auth--form--wrapper">
                    @csrf
                    <div class="input--wrapper">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter Your Email"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        {{-- <div class="sign_feild">
                                    <label for="pass">Password</label>
                                    <input type="password" name="sign_up_password" id="pass" placeholder="**************">
                                    @error('sign_up_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                        <div class="log__btn">
                            <button type="submit" class="submit--btn">Enter Your Redeem Code</button>
                        </div>
                        {{-- <div class="forget">Already have an account? <a href="{{route('login')}}">Login</a></div> --}}

                    </div>
                </form>
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
