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

<main>
        <section class="login--area--wrapper">
            <div class="login--area--content">
                <h3 class="hero--text">Forget Password</h3>

                        <form method="POST" action="{{ route('forget_password_submit') }}" class="login__form">
                            @csrf
                            
                            
                              <div class="login_feild">
                                <input type="email" id="email" name="email" placeholder="Enter Your Email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="log__btn">
                            <button type="submit" class="btn">Submit</button>
                        </div>
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
