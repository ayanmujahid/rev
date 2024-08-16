@extends('frontend.app')

@section('title')
    Announcement
@endsection

@push('style')
    <style>
       

    </style>
@endpush

@section('content')
    <main>
        <section class="announcemnet--main--content--wrapper">
            <div class="container">
                <div class="announcemnet--main--content">
                    <h3 class="main--title">ANNOUNCEMENTS</h3>
                    <div class="announcement--card--area">
                        @foreach ($announcements as $announcement)
                            <a href="{{ route('single-announcement', ['slug' => $announcement->slug]) }}">
                                <div class="single--announcement--card">
                                    <div class="img--wrapper">
                                        <img src="{{ asset($announcement->image) }}" alt="{{ $announcement->title }}" />
                                    </div>
                                    <div class="text--content">
                                        <p class="tag">{{ $announcement->short_title }}</p>
                                        <h3 class="title">{{ $announcement->title }}</h3>
                                        <p class="date">{{ $announcement->date }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="archived--news--area">
                        <h3 class="title">Archived News</h3>

                        <div class="archived--news--button--wrapper">
                            <button class="single--btn">2024</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
