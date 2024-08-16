@extends('frontend.app')

@push('style')
<style>
    .extended--footer .extra--wrapper {
    display: none;
}
</style>
@endpush

@section('content')
    <main>
        <section class="login--area--wrapper">
            <div class="login--area--content">
                <h3 class="hero--text">Sign up</h3>
                <form action="{{ route('register') }}" method="POST" class="auth--form--wrapper">
                    @csrf
                    @if(!empty($_GET['affiliate_key']))
                    <input type="hidden" name="affiliate_key" value="{{$_GET['affiliate_key']}}" />
                    @endif
                    <div class="input--wrapper">
                        <input type="hidden" name="parent_id" value="{{ isset($parent) ? $parent->id : '' }}">
                        <input type="text" class="@error('name') is-invalid @enderror" placeholder="ENTER YOUR NAME" name="name"
                            value="{{ old('name') }}" required />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="email" class="@error('email') is-invalid @enderror" placeholder="ENTER YOUR EMAIL"
                            name="email" value="{{ old('email') }}" required />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="password" class="@error('password') is-invalid @enderror" id="exampleInputPassword"
                            placeholder="PASSWORD" name="password" value="{{ old('password') }}" required />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="password" class="@error('password_confirmation') is-invalid @enderror"
                            id="exampleInputPassword" placeholder="CONFIRM PASSWORD" name="password_confirmation"
                            value="{{ old('password_confirmation') }}" required />
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="agreemnt--checkbox">
                            <input type="checkbox" name="agreement" id="terms" />
                            <label for="terms">I agree with the <a href="#">terms and condition</a>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="submit--btn">SIGN UP</button>
                </form>


                <div class="instruction--text">
                    @if(!empty($_GET['affiliate_key']))
                    <p>Already have an account? <a href="{{ route('login',['affiliate_key'=> $_GET['affiliate_key']]) }}">Login</a></p>
                    @else
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                    @endif
                    <p>Or,</p>
                    <p><a href="#">Continue as guest</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection
