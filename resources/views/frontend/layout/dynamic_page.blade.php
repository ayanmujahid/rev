@extends('frontend.app')

@section('title', $pageData ? $pageData->page_title : 'Default Title')

@push('style')
    <style>
        .extended--footer .extra--wrapper {
            display: none;
        }
    </style>
@endpush

@section('content')
    <main>
        <section class="announcemnet--main--content--wrapper">
            <div class="container">
                <h2 class="content-title">{{ $pageData ? $pageData->page_title : 'Default Title' }}</h2>
                <p>{!! $pageData ? $pageData->page_content : 'Default Content' !!}</p>
            </div>
        </section>
    </main>
@endsection
