@extends('frontend.app')

@section('title')
    Post
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
        <section class="announcemnet--main--content--wrapper single--announcemnet--main--content--wrapper">
            <div class="container">
                <div class="announcemnet--main--content single--announcment--main--content">
                    <h3 class="main--title">{{ $post->title }}</h3>

                    <div class="single--announcement--banner--wrapper">
                        <img src="{{ asset($post->image) }}" alt="Post Image" />
                    </div>

                    <div class="single--announcement--text--wrapper">
                        <p>{{ $post->message }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
