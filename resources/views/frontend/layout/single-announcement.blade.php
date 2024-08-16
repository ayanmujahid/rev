@extends('frontend.app')

@section('title')
    Announcemnet
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
                    <p class="single--announcement--tag">{{ $announcement->short_title }}</p>
                    <h3 class="main--title">{{ $announcement->title }}</h3>

                    <div class="single--announcement--banner--wrapper">
                        <img src="{{ asset($announcement->image) }}" alt="{{ $announcement->title }}" />
                    </div>

                    <div class="single--announcement--text--wrapper">
                        <p>{!! $announcement->description !!}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
