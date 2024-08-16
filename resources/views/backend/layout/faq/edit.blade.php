@extends('backend.app')

@section('title')
    FAQ Update
@endsection

@push('style')
    <style>
        /* Styling for the form inputs */
        .form-control {
            border-radius: 8px;
        }

        /* Styling for error messages */
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Frequently Asked Questions</h4>
                        <form action="{{ route('faq.update', ['id' => $faq->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div id="faq_fields_container">
                                <div class="form-group mb-3">
                                    <label for="question">Question:</label>
                                    <input type="text"
                                        class="form-control question @error('question') is-invalid @enderror" id="question"
                                        placeholder="Enter your question" name="question"
                                        value="{{ old('question', $faq->question) }}">
                                    @error('question')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="answer">Answer:</label>
                                    <input type="text" class="form-control answer @error('answer') is-invalid @enderror"
                                        id="answer" placeholder="Enter your answer" name="answer"
                                        value="{{ old('answer', $faq->answer) }}">
                                    @error('answer')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('faq.index') }}" class="btn btn-danger ">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
