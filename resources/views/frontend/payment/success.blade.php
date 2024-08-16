@extends('frontend.app')
@section('title')
    Payment Completed Successfully
@endsection

@push('style')
    <style>
        ._failed {
            border-bottom: solid 4px red !important;
        }

        ._failed i {
            color: red !important;
        }

        ._success {
            box-shadow: 0 15px 25px #00000019;
            padding: 45px;
            width: 100%;
            text-align: center;
            margin: 40px auto;
            border-bottom: solid 4px #28a745;
        }

        ._success i {
            font-size: 55px;
            color: #28a745;
        }

        ._success h2 {
            margin-bottom: 12px;
            font-size: 40px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 10px;
        }

        ._success p {
            margin-bottom: 0px;
            font-size: 18px;
            color: #495057;
            font-weight: 500;
        }

        .message-box {
            margin-top: 200px;
            margin-bottom: 200px;
            padding: 200px;
        }
    </style>
@endpush
@section('content')
    <main>
        <section>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="message-box _success">
                            <i class="bi bi-check-circle" aria-hidden="true"></i>
                            <h2> Your payment was successful </h2>
                            <p>Thank you for your purchase. Your order has been placed and is being processed. You will
                                receive an email confirmation shortly.</p>
                                <div style="margin-top: 40px;">
                                    <a href="{{ route('homepage') }}" class="btn btn-primary">Return to Home</a>
                                </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
