@extends('frontend.app')

@section('title')
    Password Reset
@endsection
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
                <h3 class="hero--text">Forget Password</h3>



                        <form method="POST" action="{{ route('forget-password-reset') }}" class="login__form">
                            @csrf
                            <input name="email" value="{{ $reset_email->email }}" type="hidden">
                            <input name="token" value="{{ $token }}" type="hidden">


                            <div class="login_feild">
                                <input type="password" placeholder="Enter Your new Password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="log__btn">
                                <button type="submit" class="btn">Submit</button> 
                            </div>
                    </div>
                    </form>

        </div>
    </section>
    </main>
@endsection
