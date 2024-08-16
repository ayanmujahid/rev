@extends('frontend.app')

@section('title', 'Two Factor Auth')

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
                <h3 class="hero--text">Two Factor Authentication</h3>


        <form class="auth--form--wrapper" action="{{ route('2fa.verify') }}" method="POST">
            @csrf
            <div class="input--wrapper">
            <label for="otp">Enter OTP:</label>
            <input type="text" name="otp" id="otp" required>
            </div>
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <button class="submit--btn" type="submit">Verify</button>
        </form>
            </div>
        </section>
    </main>
    <!-- Main Area Ends -->
@endsection