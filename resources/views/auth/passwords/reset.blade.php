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
                <h3 class="hero--text">ENTER YOUR NEW PASSWORD</h3>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="auth--form--wrapper" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="input--wrapper">
                        <input type="password" @error('password') is-invalid @enderror" name="password"
                        required autocomplete="new-password" placeholder="ENTER YOUR PASSWORD"/>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input--wrapper">
                        <input type="password" @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" name="password_confirmation" required autocomplete="new-password" placeholder="CONFIRM YOUR PASSWORD"/>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="submit--btn">RESET PASSWORD</button>
                </form>

            </div>
        </section>
    </main>
@endsection
