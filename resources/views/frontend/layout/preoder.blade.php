@extends('frontend.app')

@section('title')
    Pre Order
@endsection

@push('style')
    <style>
        .extended--footer .extra--wrapper {
            display: none;
        }

        .extended--footer {
            padding-top: 70px !important;
        }

        section.recommneded--merchandaise--wrapper.section--gap {
            padding-bottom: 180px;
        }
        .sales--goal--progressbar--wrapper .star--wrapper {
    display: flex;
    align-items: center;
    justify-content: space-evenly !important;
    position: absolute;
    top: 17px;
    left: 0;
    width: 100%;
    height: fit-content;
    z-index: 6;
}
        /* .single--goal svg path {
    fill: none !important;
} */
    </style>
@endpush

@push('script')
{{-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        let wrapper = document.querySelector(".delay--popup--wrapper");
        if (wrapper) {
            let closeButton = wrapper.querySelector(".close");
            
            setTimeout(() => {
                wrapper.classList.add("active");
            }, 2000);
            
            // Ensure closeButton exists before adding the event listener
            if (closeButton) {
                closeButton.addEventListener("click", () => {
                    wrapper.classList.remove("active");
                });
            }
        }
    });
</script> --}}
<script>
    function salesGoalProgressBar(orderCount, salesGoals) {
        let wrapper = document.querySelector(".sales--goal--progressbar--wrapper");
        let progressBar = wrapper.querySelector(".progress--bar");
        let stars = wrapper.querySelectorAll(".star--wrapper svg");

        if (!progressBar || stars.length === 0) {
            console.error('Required elements for progress bar or stars are not found.');
            return;
        }

        // Sort sales goals by target to ensure proper star glowing
        salesGoals.sort((a, b) => a.sales_target - b.sales_target);

        // Define the percentage per star and starting percentage
        let percentagePerStar = 10; // Percentage increment per star
        let initialPercentage = 10; // Starting percentage for the first star

        // Determine how many stars should glow
        let starsLit = salesGoals.filter(goal => orderCount >= goal.sales_target).length;

        // Update stars in the progress bar
        stars.forEach((star, index) => {
            if (index < starsLit) {
                star.querySelector("path").setAttribute("fill", "yellow");
            } else {
                star.querySelector("path").setAttribute("fill", "#0F0F00");
            }
        });

        // Calculate the progress percentage
        let progressPercentage = initialPercentage + (starsLit - 1) * percentagePerStar;
        
        // If there are more sales goals and orderCount is between goals, calculate additional percentage
        let nextGoal = salesGoals.find(goal => goal.sales_target > orderCount);
        if (nextGoal) {
            let previousGoal = salesGoals[starsLit - 1] || { sales_target: 0 };
            let percentageRange = percentagePerStar;
            progressPercentage = (starsLit - 1) * percentagePerStar + initialPercentage + (orderCount - previousGoal.sales_target) / (nextGoal.sales_target - previousGoal.sales_target) * percentageRange;
        }

        // Set the progress bar width to the calculated percentage
        progressBar.style.width = `${Math.min(progressPercentage, 100)}%`;

        // Update the stars in the goals collection
        let goalStars = document.querySelectorAll(".goals--collection .single--goal svg");
        goalStars.forEach((star, index) => {
            if (index < starsLit) {
                star.querySelector("path").setAttribute("fill", "yellow");
            } else {
                star.querySelector("path").setAttribute("fill", "#0F0F00");
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        let orderCount = {{ $orderCount }};
        let salesGoals = @json($data['salesGoals']);

        console.log('Order Count:', orderCount); // Check values in console
        console.log('Sales Goals:', salesGoals); // Check values in console

        salesGoalProgressBar(orderCount, salesGoals);
    });
</script>
    
    
@endpush

@section('content')
    <main>
        {{-- banner area starts --}}
        <div class="pre--order--banner--area--wrapper">
            <div class="container">
                <div class="pre--order--banner--area--content">
                    <div class="img--wrapper">
                        <img src="{{ asset('frontend/images/pre-order-item.png') }}" alt="" />
                    </div>

                    <div class="bottom--part">
                        <h3 class="item--title">
                            CLAIM THE LIMITED EDITION OFFER BEFORE IT'S GONE!
                        </h3>

                        <div class="button--wrapper">
                            <a class="btn--primary add_cart" data-id="{{ $product->id }}" data-type="Shop"
                                href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="240" height="66" viewBox="0 0 240 66"
                                    fill="none">
                                    <path
                                        d="M17.6214 0.5C5.68075 0.5 -2.30622 12.7907 2.54386 23.702L16.7679 55.702C19.4163 61.6602 25.3251 65.5 31.8454 65.5H208.155C214.675 65.5 220.584 61.6602 223.232 55.702L237.456 23.702C242.306 12.7907 234.319 0.5 222.379 0.5H17.6214Z"
                                        fill="#FDFE0D" stroke="url(#paint0_linear_4513_2630)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_4513_2630" x1="-101.574" y1="121"
                                            x2="309.262" y2="58.0481" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDFE0D" />
                                            <stop offset="1" stop-color="white" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                                <p>PRE-ORDER</p>
                            </a>
                            <a href="#latest-video" class="btn--secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="205" height="66" viewBox="0 0 205 66"
                                    fill="transparent">
                                    <path
                                        d="M17.1908 0.5C5.64128 0.5 -2.33462 12.0605 1.76563 22.8577L13.9176 54.8577C16.3505 61.2642 22.49 65.5 29.3428 65.5H175.657C182.51 65.5 188.65 61.2642 191.082 54.8577L203.234 22.8577C207.335 12.0605 199.359 0.5 187.809 0.5H17.1908Z"
                                        stroke="#FDFE0D" />
                                </svg>

                                <p>WATCH TRAILER</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="banner--gradient"></div>
        </div>
        {{-- banner area ends --}}



        {{-- hero area starts --}}
        <section class="pre--order--hero--area--wrapper section--gap" id="pre-orderbook">
            <div class="container">
                <div class="pre--order--hero--area--content">
                    <div class="left">
                        <img src="{{ asset($product->image ?? 'frontend/images/new-pre-order-hero.png') }}"
                            alt="" />
                    </div>
                    <div class="right">
                        <h3 class="title">{{ $product->title ?? '' }}
                        </h3>
                        <div class="description">
                            <p>
                                {!! $product->description ?? '' !!}
                            </p>
                        </div>

                        <a data-id="{{ $product->id }}" data-type="Shop" href="javascript:void(0)"
                            class="btn--primary add_cart">
                            <svg xmlns="http://www.w3.org/2000/svg" width="240" height="66" viewBox="0 0 240 66"
                                fill="none">
                                <path
                                    d="M17.6214 0.5C5.68075 0.5 -2.30622 12.7907 2.54386 23.702L16.7679 55.702C19.4163 61.6602 25.3251 65.5 31.8454 65.5H208.155C214.675 65.5 220.584 61.6602 223.232 55.702L237.456 23.702C242.306 12.7907 234.319 0.5 222.379 0.5H17.6214Z"
                                    fill="#FDFE0D" stroke="url(#paint0_linear_4513_2642)" />
                                <defs>
                                    <linearGradient id="paint0_linear_4513_2642" x1="-101.574" y1="121"
                                        x2="309.262" y2="58.0481" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FDFE0D" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <p>PRE-ORDER</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        {{-- hero area ends --}}



        {{-- special area starts --}}
        <section class="pre--order--special--area--wrapper section--gap">
            <div class="container">
                <h3 class="affiliate--common-title">What you get in the pre-order special</h3>
                <div class="pre--order--special--area--content">
                    <div class="left">
                        <ul class="special--list">
                            {!! $data['preOrderSpecial']->description ??
                                '<li>Choose between 2 limited edition covers</li>
                             <li>3 free posters</li>
                             <li>5 entrys to win free prizes</li>
                            <li>Free bonus commentary</li>
                            <li>15% off the Revival shop!</li>' !!}
                        </ul>

                        <a class="btn--secondary add_cart" data-id="{{ $product->id }}" data-type="Shop"
                            href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="240" height="66" viewBox="0 0 240 66"
                                fill="none">
                                <path
                                    d="M17.6214 0.5C5.68075 0.5 -2.30622 12.7907 2.54386 23.702L16.7679 55.702C19.4163 61.6602 25.3251 65.5 31.8454 65.5H208.155C214.675 65.5 220.584 61.6602 223.232 55.702L237.456 23.702C242.306 12.7907 234.319 0.5 222.379 0.5H17.6214Z"
                                    fill="#0F0F00" stroke="url(#paint0_linear_4513_2692)" />
                                <defs>
                                    <linearGradient id="paint0_linear_4513_2692" x1="-101.574" y1="121"
                                        x2="309.262" y2="58.0481" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FDFE0D" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                </defs>
                            </svg>

                            <p>PRE-ORDER</p>
                        </a>
                    </div>
                    <div class="right book-imgs">
                      <div class="swiper mycover">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                              <img class="book-img" src="{{ asset('frontend/images/adwaw.jpg') }}" alt="" />
                              <h4>God Bless America Exclusive Pre-Order Edition</h4>
                          </div>
                          <div class="swiper-slide">
                              <img class="book-img" src="{{ asset('frontend/images/225.jpg') }}" alt="" />
                              <h4>The War Begins Exclusive Pre-Order Edition</h4>
                          </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- special area ends --}}



        {{-- sales goal area starts --}}
        <section class="sales--goal--area--wrapper section--gap">
            <div class="container">
                <div class="sales--goal--area--content">
                    <div class="top--part">
                        <h3 class="heading">Sales Goals</h3>
                        <p class="value">{{ $orderCount ?? '30000' }}</p>
                    </div>

                    <div class="sales--goal--progressbar--wrapper">
                        <div class="progress--bar--holder">
                            <div class="progress--bar"></div>
                        </div>




                        <div class="star--wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41" viewBox="0 0 43 41"
                                fill="none">
                                <path
                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                    fill="#0F0F00" stroke="white" />
                            </svg>
                        </div>
                    </div>

                    <div class="goals--collection">
                        @foreach ($data['salesGoals'] as $data['salesGoal'])
                            <div class="single--goal">
                                <div style="display: flex; justify-content: space-between;">
                                    <p class="intro">{{ $data['salesGoal']->sales_target ?? '' }}</p>
                                    <div>
                                        @if ($data['salesGoal']->sales_target <= $data['preOrderSpecial']->sales_goal)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41"
                                                viewBox="0 0 43 41" fill="none">
                                                <path
                                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                                    fill="yellow" stroke="white" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="41"
                                                viewBox="0 0 43 41" fill="none">
                                                <path
                                                    d="M21.5 1.61804L26.076 15.7016L26.1883 16.0471H26.5516H41.3599L29.3797 24.7513L29.0858 24.9648L29.1981 25.3103L33.7741 39.3939L21.7939 30.6897L21.5 30.4762L21.2061 30.6897L9.22589 39.3939L13.8019 25.3103L13.9142 24.9648L13.6203 24.7513L1.64007 16.0471H16.4484H16.8117L16.924 15.7016L21.5 1.61804Z"
                                                    fill="#0F0F00" stroke="white" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="description" style="color: white !important;">
                                    {!! $data['salesGoal']->description ?? '' !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        {{-- sales goal area ends --}}



        {{-- page samples area starts --}}
        <section class="page--samples--area--wrapper section--gap">
            <div class="container">
                <h3 class="affiliate--common-title">PAGE SAMPLES</h3>
                <div class="page--samples--area--content">
                    @foreach ($data['pageSamples'] as $data['pageSample'])
                        <div class="single--sample">
                            <img src="{{ $data['pageSample']->image ?? 'frontend/images/page-sample.png' }}"
                                alt="{{ asset('frontend/images/page-sample.png') }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        {{-- page samples area ends --}}



        {{-- latest video area starts --}}
        <section class="latest--video--area--wrapper section--gap" id="latest-video">
            <div class="container">
                <h3 class="affiliate--common-title">Latest Videos</h3>

                <div class="latest--video--area--content">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @if (!empty($data['latestVideos']))
                                @foreach ($data['latestVideos'] as $data['latestVideo'])
                                    <div class="swiper-slide">
                                        <div class="single--video--wrapper">
                                            <img src="{{ asset('frontend/images/videos.png') }}" alt="" />

                                            {{-- play button --}}
                                            <a class="play--btn" data-fancybox=""
                                                href="https://revivals.hexatechhub.com/uploads/latest_video/tmpphp2rwii0-dee23a80-bed0-4ed5-8593-da2019b9c1cd.mp4">
                                                <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <div class="single--video--wrapper">
                                        <img src="{{ asset('frontend/images/videos.png') }}" alt="" />

                                        {{-- play button --}}
                                        <a class="play--btn" data-fancybox=""
                                            href="https://revivals.hexatechhub.com/uploads/latest_video/tmpphp2rwii0-dee23a80-bed0-4ed5-8593-da2019b9c1cd.mp4">
                                            <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="single--video--wrapper">
                                        <video src="{{ asset('frontend/videos/landing-hero-banner.mp') }}4" loop
                                            muted></video>

                                        {{-- play button --}}
                                        <button class="play--btn">
                                            <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                        </button>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="single--video--wrapper">
                                        <video src="{{ asset('frontend/videos/landing-hero-banner.mp') }}4" loop
                                            muted></video>

                                        {{-- play button --}}
                                        <button class="play--btn">
                                            <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                        </button>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="single--video--wrapper">
                                        <video src="{{ asset('frontend/videos/landing-hero-banner.mp') }}4" loop
                                            muted></video>

                                        {{-- play button --}}
                                        <button class="play--btn">
                                            <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                        </button>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="single--video--wrapper">
                                        <video src="{{ asset('frontend/videos/landing-hero-banner.mp') }}4" loop
                                            muted></video>

                                        {{-- play button --}}
                                        <button class="play--btn">
                                            <img src="{{ asset('frontend/images/play-btn.png') }}" alt="" />
                                        </button>
                                    </div>
                                </div>
                            @endif
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



        {{-- happy users area starts --}}
        <section class="happy--users--area--wrapper section--gap">
            <div class="container">
                <div class="happy--users--area--content">
                    <h3 class="affiliate--common-title">
                        Join with our many happy readers
                    </h3>

                    <div class="happy--users--sliders--wrapper">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($data['happyusers'] as $data['happyuser'])
                                    @if ($data['happyuser']->type == 2)
                                        <div class="swiper-slide">
                                            <div class="single--slide">
                                                <div class="left">
                                                    <img src="{{ asset($data['happyuser']->image ?? 'frontend/images/reviewer1.png') }}"
                                                        alt="{{ $data['happyuser']->short_title }}" />
                                                </div>
                                                <div class="right">
                                                    <div class="star--wrapper">
                                                        @for ($i = 0; $i < $data['happyuser']->rating; $i++)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M23.3631 8.58308L15.9851 7.45608L12.6781 0.412078C12.4311 -0.113922 11.5681 -0.113922 11.3211 0.412078L8.0151 7.45608L0.637095 8.58308C0.500872 8.604 0.373049 8.66206 0.267662 8.75088C0.162274 8.83969 0.0833962 8.95583 0.0396894 9.08654C-0.0040174 9.21724 -0.0108633 9.35747 0.0199035 9.49181C0.0506702 9.62615 0.11786 9.74942 0.214095 9.84808L5.5741 15.3421L4.3071 23.1091C4.28447 23.248 4.30139 23.3905 4.35591 23.5202C4.41043 23.6499 4.50036 23.7617 4.61542 23.8428C4.73047 23.9238 4.86601 23.9709 5.00654 23.9785C5.14707 23.9862 5.28692 23.9541 5.4101 23.8861L12.0001 20.2441L18.5901 23.8871C18.7133 23.9551 18.8531 23.9872 18.9937 23.9795C19.1342 23.9719 19.2697 23.9248 19.3848 23.8438C19.4998 23.7627 19.5898 23.6509 19.6443 23.5212C19.6988 23.3915 19.7157 23.249 19.6931 23.1101L18.4261 15.3431L23.7861 9.84908C23.8826 9.75045 23.9501 9.6271 23.981 9.49262C24.0119 9.35813 24.0051 9.21772 23.9614 9.08683C23.9177 8.95595 23.8387 8.83967 23.7331 8.75079C23.6276 8.66191 23.4995 8.60388 23.3631 8.58308Z"
                                                                    fill="#D9DA01" />
                                                            </svg>
                                                        @endfor
                                                    </div>

                                                    <div class="review--content--text">
                                                        <p class="main--title">
                                                            {{ $data['happyuser']->short_title ?? 'Smooth App and Customer Support' }}
                                                        </p>

                                                        <p class="main--subtitle">
                                                            {!! $data['happyuser']->description ??
                                                                'Popupular works very smoothly. And it is very simple
                                                                                                                                                                                        and easy to use. I love it! Marco and the customer
                                                                                                                                                                                        support are responsive, responsible, competent and
                                                                                                                                                                                        to me very trustworthy.' !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        {{-- happy users area ends --}}



        <section class="recommneded--merchandaise--wrapper section--gap">
            <div class="container">
                <h3 class="affiliate--common-title">We thought you'd love this too.</h3>

                <div class="latest--video--area--content recommneded--merchandaise--content">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @if (Helper::getPrintifyProduct())
                                @foreach (Helper::getPrintifyProduct()->data as $printData)
                                    <div class="swiper-slide">
                                        <div class="single--merchandaise--wrapper">
                                            <div class="img--wrapper">
                                                <img src="{{ $printData->images[0]->src }}"
                                                    alt="{{ $printData->title }}" />
                                            </div>
                                            <div class="text--wrapper">
                                                <p class="subtitle">{{ $printData->variants[0]->price / 100 }}</p>
                                            </div>
                                            <div class="product--hover--info">
                                                <div class="action--button--wrapper">
                                                    <!-- Your action buttons here -->
                                                    <a data-id="{{ $printData->id . '-' . $printData->variants[0]->id }}"
                                                        data-type="Printify"
                                                        data-price="{{ $printData->variants[0]->price / 100 }}"
                                                        data-image="{{ $printData->images[0]->src }}"
                                                        data-title="{{ $printData->variants[0]->title }}"
                                                        data-print_areas=""
                                                        data-blueprint_id="{{ $printData->blueprint_id }}"
                                                        data-print_provider_id="{{ $printData->print_provider_id }}"
                                                        href="javascript:void(0)"
                                                        data-quantity_limit="{{ $printData->variants[0]->quantity }}"
                                                        class="cart--btn add_cart">
                                                        <img src="{{ asset('frontend/images/cart-icon.svg') }}"
                                                            alt="{{ $printData->variants[0]->title }}" />
                                                    </a>
                                                </div>
                                                <h3 class="prod--title">
                                                    <a class="prod--title product-preview"
                                                        data-desc="{{ $printData->description }}"
                                                        data-title="{{ $printData->title }}" data-type="Printify"
                                                        data-price="{{ $printData->variants[0]->price / 100 }}"
                                                        data-image="{{ $printData->images[0]->src }}"
                                                        data-quantity_limit="{{ $printData->variants[0]->quantity }}"
                                                        data-id="{{ $printData->id . '-' . $printData->variants[0]->id }}">{{ $printData->title }}
                                                        - Printify</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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

        {{-- recommended merchandise area ends --}}



        {{-- pre order small banner area starts --}}
        <section class="pre--order--small--banner--area--wrapper">
            <div class="container">
                <div class="pre--order--small--banner--area--content">
                    <div class="left">
                        <div class="top--part">
                            <div class="avatar--wrapper">
                                <ul>
                                    <li>
                                        <img src="{{ asset('frontend/images/avatar1.png') }}" alt="" />
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/avatar2.png') }}" alt="" />
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/avatar3.png') }}" alt="" />
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/avatar4.png') }}" alt="" />
                                    </li>
                                    <!--<li>-->
                                    <!--    <p>20+</p>-->
                                    <!--</li>-->
                                </ul>
                            </div>

                            <p>PRE-ORDER ROGUE ASSASSIN: A SPARK OF REVIVAL </p>
                        </div>

                        <a href="#pre-orderbook" class="btn--primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="309" height="66" viewBox="0 0 309 66"
                                fill="none">
                                <path
                                    d="M17.6744 0.5C4.98152 0.5 -2.95814 14.2328 3.3751 25.2328L21.7991 57.2328C24.7439 62.3476 30.1965 65.5 36.0984 65.5H272.902C278.804 65.5 284.256 62.3476 287.201 57.2328L305.625 25.2328C311.958 14.2328 304.018 0.5 291.326 0.5H17.6744Z"
                                    fill="#FDFE0D" stroke="url(#paint0_linear_4513_2869)" />
                                <defs>
                                    <linearGradient id="paint0_linear_4513_2869" x1="-132.5" y1="121"
                                        x2="391.5" y2="17" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FDFE0D" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                </defs>
                            </svg>

                            <p>ORDER NOW</p>
                        </a>
                    </div>
                    <div class="right">
                        <img src="{{ asset('frontend/images/new-pre-order-hero.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </section>
        {{-- pre order small banner area ends --}}
    </main>
@endsection
