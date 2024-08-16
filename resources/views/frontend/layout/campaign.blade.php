@extends('frontend.app')

@section('title')
    Campaign
@endsection

@push('style')
    <style>
    section.campaign--description--area--wrapper {
    background-color: #000;
}
    </style>
@endpush

@section('content')
    <main>
        {{-- campaign page wrapper area starts --}}
        <section class="campaign--page--banner--area--wrapper">
            <div class="container">
                <h3 class="common--banner--title">CAMPAIGN</h3>
                @foreach ($campaings as $campaign)
                    <div class="campaign--page--banner--area--content">
                        <!--<h3 class="common--banner--title">-->
                        <!--    {{ $campaign->title ?? 'Please Help The Terror Victims of Netiv HaAsara' }}-->
                        <!--</h3>-->
                        <h3 class="common--banner--title">CAMPAIGN</h3>

                        {{-- campaign progress area --}}
                        <div class="campaign--progress--wrapper">
                            <div class="progress--track">
                                <div class="progress--bar" style="width: {{ $campaign->achieved_percentage ?? '50' }}%;">
                                </div>
                            </div>

                            <div class="campaign--amount">
                                <p class="goal">$<span>{{ $campaign->achive_goal ?? '2674,360' }}</span></p>
                                <p class="target">Pledged of $<span>{{ $campaign->target_goal ?? '2000000' }}</span> Goal
                                </p>
                            </div>
                        </div>

                        {{-- donation area --}}
                        <div class="dontaion--area--wrapper">
                            <div class="donation--btn">
                                <a href="#" class="btn--primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="309" height="66"
                                        viewBox="0 0 309 66" fill="none">
                                        <path
                                            d="M17.6744 0.5C4.98152 0.5 -2.95814 14.2328 3.3751 25.2328L21.7991 57.2328C24.7439 62.3476 30.1965 65.5 36.0984 65.5H272.902C278.804 65.5 284.256 62.3476 287.201 57.2328L305.625 25.2328C311.958 14.2328 304.018 0.5 291.326 0.5H17.6744Z"
                                            fill="#FDFE0D" stroke="url(#paint0_linear_4513_2217)" />
                                        <defs>
                                            <linearGradient id="paint0_linear_4513_2217" x1="-132.5" y1="121"
                                                x2="391.5" y2="17" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FDFE0D" />
                                                <stop offset="1" stop-color="white" />
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                    <p>DONATE NOW</p>
                                </a>
                            </div>

                            <div class="donation--timeline">
                                <div class="single--timeline">
                                    <p class="number">{{ $campaign->days_left ?? '08' }}</p>
                                    <p>days</p>
                                </div>
                                <div class="single--timeline">
                                    <p class="number">{{ $campaign->hours_left ?? '16' }}</p>
                                    <p>hours</p>
                                </div>
                                <div class="single--timeline">
                                    <p class="number">{{ $campaign->minutes_left ?? '55' }}</p>
                                    <p>minutes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        {{-- campaign page wrapper area ends --}}
        
        
        <section class="txt-blk fire">
            

            <div class="container">
                <h3 class="common--banner--title">CAMPAIGN</h3>
                <p>" The beginning of the war of The Rogue Assassin has almost begun! Sign up to be the first to know and don't miss out on exclusive events offers and prizes! "</p>
            </div>
        </section>


        {{-- campaign description area starts --}}
        <section class="campaign--description--area--wrapper">
            <div class="container">
                @foreach ($campaings as $campaign)
                    <div class="campaign--description--area--content">
                        {{-- campaign video wrapper --}}
                        <div class="campaign--video--wrapper">
                            @if ($campaign->embedUrl)
                                <iframe width="560" height="315" src="{{ $campaign->embedUrl }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"></iframe>
                            @else
                                <p style="font-weight: bold; background-color: yellow;">No video available for this
                                    campaign.</p>
                            @endif
                        </div>
                        {{-- campaign details --}}
                        <div class="campaign--details--wrapper">
                            {!! $campaign->description ?? 'No description provided.' !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        {{-- campaign description area ends --}}
    </main>
@endsection
