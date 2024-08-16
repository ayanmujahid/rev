@extends('frontend.app')

@section('title', 'LogIn')

@push('style')
<style>
    .extended--footer .extra--wrapper {
    display: none;
}
</style>
@endpush

@section('content')

    <!-- Main Area Starts -->
    <main>
        <section class="login--area--wrapper">
            <div class="login--area--content">
                <h3 class="hero--text">Log In</h3>

                <!-- auth form -->
                <form class="auth--form--wrapper" action="{{ route('login') }}" method="POST">
                    @csrf
                    @if(!empty($_GET['affiliate_key']))
                    <input type="hidden" name="affiliate_key" value="{{$_GET['affiliate_key']}}" />
                    @endif
                    <div class="input--wrapper">

                        <input type="email" class="@error('email') is-invalid @enderror" id="exampleInputEmail1"
                            placeholder="ENTER YOUR EMAIL" name="email" value="{{ old('email') }}" autocomplete="email"
                            autofocus required />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="password" class="@error('password') is-invalid @enderror" id="exampleInputPassword1"
                            placeholder="ENTER YOUR PASSWORD" name="password" required autocomplete="current-password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <a href="{{ route('forget-password') }}">Forgot password ?</a>
                    </div>

                    <button type="submit" class="submit--btn">LOG IN</button>
                </form>

                <!-- instruction text -->
                <div class="instruction--text">
                    @if(!empty($_GET['affiliate_key']))
                    <p>New to this site? <a href="{{ route('register',['affiliate_key'=> $_GET['affiliate_key']]) }}">Sign Up</a></p>
                    @else
                    <p>New to this site? <a href="{{ route('register') }}">Sign Up</a></p>
                    @endif
                    <p>Or,</p>
                    @if(!empty($_GET['affiliate_key']))
                    <p><a href="{{route('affiliate-shop',$_GET['affiliate_key'])}}">Continue Shopping</a></p>
                    @else
                    <p><a href="{{route('shop.category')}}">Continue Shopping</a></p>
                    @endif
                    
                </div>
            </div>
        </section>
    </main>
    <!-- Main Area Ends -->
@endsection
