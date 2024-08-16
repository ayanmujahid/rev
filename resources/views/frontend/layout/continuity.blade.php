@extends('frontend.app')

@section('title')
    Continuity
@endsection
@push('style')
    <style>
        .extended--footer .extra--wrapper {
            display: none;
        }
        .extended--footer {
    padding-top: 70px !important;
}
    </style>
@endpush

@section('content')
    <main>
        {{-- main video area --}}
        <section class="continuity--banner--area--wrapper">
            <video loop muted autoplay src="{{ asset('frontend/videos/continuity-banner.mp4') }}"></video>
        </section>
        {{-- main video area --}}



        {{-- hero area starts --}}
        <section class="continuity--hero--area--wrapper section--gap">
            <div class="container">
                <div class="continuity--hero--area--content">
                    <div class="text--wrapper">
                        <p>MISS ORIGINAL IDEAS IN MOVIES?</p>
                        <p>MISS FRIENDLY COMMUNITIES IN FANDOMS?</p>
                        <p>
                            MISS MOVIES THAT YOU CAN LOSE YOURSELF IN AND THAT YOU CAN THEORISE WITH EXCITEMENT ABOUT?
                        </p>
                    </div>
                    <h3 class="hero--text">THE REVIVAL CONTINUITY DOES A LOT MORE THAN JUST THAT.</h3>
                </div>
            </div>
        </section>
        {{-- hero area ends --}}



        {{-- about continuity area starts --}}
        <section class="about--continuity--area--wrapper section--gap">
            <div class="container">
                <div class="about--continuity--area--content">
                    <div class="left">
                        <img src="{{ asset('frontend/images/about-continuity.png') }}" alt="" />
                    </div>
                    <div class="right">
                        <h3 class="hero--text">ABOUT CONTINUITY</h3>
                        <p class="sub--text">
                            The emotional, gritty, and action packed world you’ve been
                            dreaming of is finally hear. This is not just another cinematic
                            universe. The revival continuity is made up of all original
                            characters that were created separately to maximize their
                            creativity quality. We let all of these separate storylines
                            naturally blend together to form one ground breaking story. What
                            happens in a movie, show, or book will eventually impact
                            everyone, and in the same time, every product is complete
                            without you having to catch up on anything.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        {{-- about continuity area ends --}}



        {{-- revival saga area starts --}}
        <section class="revival--saga--banner--area logo-imgs">
            <img src="{{ asset('frontend/images/revival-saga-banner.png') }}" alt="" />
        </section>
        {{-- revival saga area ends --}}



        {{-- upcoming area starts --}}
        <section class="upcoming--area--wrapper section--gap" style="cursor: pointer;">
            <h3 class="hero--text">upcoming Projects</h3>

            <div class="container">
                <!-- slider wrapper -->
                <div class="upcoming--project--slider--wrapper">

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($upcomingProjects as $upcomingProject)
                                <div class="swiper-slide">
                                    <div class="single--slide">
                                        <img src="{{ asset($upcomingProject->image) }}" alt />

                                        <div class="text--wrapper">
                                            <p class="title">{{ $upcomingProject->title ?? '' }}</p>
                                            <p class="date">Streaming on {{ $upcomingProject->releas_date ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="slider">

                    </div>
                </div>
            </div>
        </section>
        {{-- upcoming area ends --}}



        {{-- no gimmick section area starts --}}
        <section class="no--gimmicks--area--wrapper section--gap">
            <div class="container">
                <div class="no--gimmicks--area--content">
                    <div class="single--card">
                        <p class="title">
                            WHAT SETS US APART FROM THE OTHER MILLIONS OF CINEMATIC
                            UNIVERSES?
                        </p>
                        <ul>
                            <li>
                                We have the beginning middle and end planned out for every
                                character and every story.
                            </li>
                            <li>
                                We do not have a political agenda, and we do not play identity
                                politics.
                            </li>
                            <li>
                                Our number one priority is to blow your mind every single
                                time.
                            </li>
                        </ul>
                    </div>
                    <div class="single--card">
                        <p class="title">NO GIMICKS:</p>
                        <ul>
                            <li>There are real human steaks.</li>
                            <li>Dead characters stay dead.</li>
                            <li>There is no multiverse or time travel.</li>
                            <li>
                                We do not rely on nostalgia since we are all new and all
                                original.
                            </li>
                            <li>
                                The revival continuity is made by it’s creators, so we
                                understand and respect the source material.
                            </li>
                            <li>
                                We do not use a copy paste formula. Each installment is risky
                                and unique.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        {{-- no gimmick section area ends --}}
        
        
         {{-- latest video area starts --}}
        <section class="latest--video--area--wrapper section--gap" id="latest-video">
            <div class="container">
                <h3 class="affiliate--common-title">Latest Videos</h3>

                <div class="latest--video--area--content">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            {{-- @if (!empty($data['latestVideos']))
                                @foreach ($data['latestVideos'] as $data['latestVideo'])
                                    <div class="swiper-slide">
                                        <div class="single--video--wrapper">
                                            <!--<video src="{{ asset($data['latestVideo']->video) }}" loop controls="true"></video>-->
                                            
                                             <img src="{{ asset( asset($video->vid_thumbnails) }}" alt="" />

                                            {{-- play button --}}
                                            {{-- 
                                                <a class="play--btn" data-fancybox="" href="{{ asset($data['latestVideo']->video) }}">
                                                <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                            </a> 
                                        </div>
                                    </div>
                                @endforeach
                            @else --}} 
                            @foreach ($videos as $video)
                                
                            
                                <div class="swiper-slide">
                                    <div class="single--video--wrapper">
                                        <img src="{{ asset($video->vid_thumbnails) }}" alt="" />

                                        {{-- play button --}}
                                        <a class="play--btn" data-fancybox="" href="{{ asset($video->video) }}">
                                                <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                            </a> 
                                    </div>
                                </div>
                                @endforeach
                            {{-- @endif --}}
                        </div>
                    </div>

                    <button class="button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                            fill="none">
                            <g filter="url(#filter0_d_4513_2903)">
                                <g clip-path="url(#clip0_4513_2903)">
                                    <path
                                        d="M16 31C16 26.975 16.175 23.3 16.875 21.2C17.575 18.75 18.45 16.475 20.55 14.375C23.175 11.925 25.45 11.225 28.95 10.525C31.4 10.175 34.375 10 36.125 10H37.7C39.625 10 42.425 10.175 45.05 10.525C48.55 11.225 51 12.1 53.45 14.375C55.725 16.475 56.425 18.75 57.125 21.2C57.825 23.3 58 26.975 58 31C58 35.025 57.825 38.7 57.125 40.8C56.425 43.25 55.55 45.525 53.45 47.625C50.825 50.075 48.55 50.775 45.05 51.475C42.25 52 38.75 52 37 52C35.25 52 31.75 52 28.775 51.475C25.45 50.775 23 50.075 20.375 47.625C18.275 45.7 17.4 43.425 16.7 40.8C16.175 38.7 16 35.025 16 31Z"
                                        fill="#FDFE0D" />
                                    <path
                                        d="M31.7484 21.7242C32.4484 21.0242 33.4984 21.0242 34.1984 21.7242L42.2484 29.7742C42.9484 30.4742 42.9484 31.5242 42.2484 32.2242L34.1984 40.2742C33.4984 40.9742 32.4484 40.9742 31.7484 40.2742C31.0484 39.5742 31.0484 38.5242 31.7484 37.8242L38.5734 30.9992L31.7484 24.1742C31.0484 23.4742 31.0484 22.4242 31.7484 21.7242Z"
                                        fill="#141414" />
                                </g>
                            </g>
                            <defs>
                                <filter id="filter0_d_4513_2903" x="0" y="0" width="74" height="74"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                    <feOffset dy="6" />
                                    <feGaussianBlur stdDeviation="8" />
                                    <feComposite in2="hardAlpha" operator="out" />
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0" />
                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                        result="effect1_dropShadow_4513_2903" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4513_2903"
                                        result="shape" />
                                </filter>
                                <clipPath id="clip0_4513_2903">
                                    <rect width="42" height="42" rx="16"
                                        transform="matrix(-1 0 0 1 58 10)" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <button class="button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                            fill="none">
                            <g filter="url(#filter0_d_4513_2899)">
                                <g clip-path="url(#clip0_4513_2899)">
                                    <path
                                        d="M58 31C58 26.975 57.825 23.3 57.125 21.2C56.425 18.75 55.55 16.475 53.45 14.375C50.825 11.925 48.55 11.225 45.05 10.525C42.6 10.175 39.625 10 37.875 10H36.3C34.375 10 31.575 10.175 28.95 10.525C25.45 11.225 23 12.1 20.55 14.375C18.275 16.475 17.575 18.75 16.875 21.2C16.175 23.3 16 26.975 16 31C16 35.025 16.175 38.7 16.875 40.8C17.575 43.25 18.45 45.525 20.55 47.625C23.175 50.075 25.45 50.775 28.95 51.475C31.75 52 35.25 52 37 52C38.75 52 42.25 52 45.225 51.475C48.55 50.775 51 50.075 53.625 47.625C55.725 45.7 56.6 43.425 57.3 40.8C57.825 38.7 58 35.025 58 31Z"
                                        fill="#FDFE0D" />
                                    <path
                                        d="M42.2516 21.7242C41.5516 21.0242 40.5016 21.0242 39.8016 21.7242L31.7516 29.7742C31.0516 30.4742 31.0516 31.5242 31.7516 32.2242L39.8016 40.2742C40.5016 40.9742 41.5516 40.9742 42.2516 40.2742C42.9516 39.5742 42.9516 38.5242 42.2516 37.8242L35.4266 30.9992L42.2516 24.1742C42.9516 23.4742 42.9516 22.4242 42.2516 21.7242Z"
                                        fill="#141414" />
                                </g>
                            </g>
                            <defs>
                                <filter id="filter0_d_4513_2899" x="0" y="0" width="74" height="74"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                    <feOffset dy="6" />
                                    <feGaussianBlur stdDeviation="8" />
                                    <feComposite in2="hardAlpha" operator="out" />
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0" />
                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                        result="effect1_dropShadow_4513_2899" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4513_2899"
                                        result="shape" />
                                </filter>
                                <clipPath id="clip0_4513_2899">
                                    <rect x="16" y="10" width="42" height="42" rx="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        {{-- latest video area ends --}}



        {{-- touch history area style starts --}}
        <section class="touch--history--area--wrapper">
            <div class="container">
                <div class="touch--history--area--content">
                    <div class="left">
                        <img src="{{ asset($ProductPromotions->image ?? 'frontend/images/touch-history.png') }}"
                            alt="{{ $ProductPromotions->title ?? '' }}" />
                    </div>
                    <div class="right">
                        <h3 class="hero--text">{{ $ProductPromotions->title ?? 'TOUCH HISTORY IN THE MAKING' }}</h3>

                        <p class="sub--text">
                            {{ $ProductPromotions->short_description ?? 'STEP INTO THE WORLD OF THE REVIVAL SAGA WITH THE LONG AWAITED ROGUE ASSASSIN: A SPARK OF REVIVAL AND CHOOSE BETWEEN TWO' }}
                        </p>

                        <a href="{{route('preoder.index')}}" class="btn--primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="275" height="66" viewBox="0 0 275 66"
                                fill="none">
                                <path
                                    d="M17.1847 0.5C4.84563 0.5 -3.12762 13.5486 2.50229 24.5284L18.9103 56.5284C21.7343 62.0361 27.4032 65.5 33.5927 65.5H241.407C247.597 65.5 253.266 62.0361 256.09 56.5284L272.498 24.5284C278.128 13.5486 270.154 0.5 257.815 0.5H17.1847Z"
                                    fill="#FDFE0D" stroke="url(#paint0_linear_4513_1690)" />
                                <defs>
                                    <linearGradient id="paint0_linear_4513_1690" x1="-118.096" y1="121"
                                        x2="352.255" y2="37.8629" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FDFE0D" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <p>LEARN MORE</p>
                        </a>
                    </div>

                    <div class="limited--offer--text">LIMITED TIME OFFER</div>
                </div>
            </div>
        </section>
        {{-- touch history area style ends --}}
    </main>
@endsection
