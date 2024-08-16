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
                <h3 class="hero--text">FORGET PASSWORD</h3>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="auth--form--wrapper" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input--wrapper">
                        <input type="email" @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus required
                            placeholder="ENTER YOUR EMAIL" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="submit--btn">EMAIL PASSWORD RESET LINK</button>
                </form>

            </div>
        </section>
    </main>
@endsection
