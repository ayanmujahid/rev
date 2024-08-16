@extends('frontend.app')

@section('title')
    Home
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

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        homepageDelayPopUp();
    });

    function homepageDelayPopUp() {
        let wrapper = document.querySelector(".delay--popup--wrapper");

        if (wrapper) {
            let closeButton = wrapper.querySelector(".submit--btn");

            // Check if the popup has been previously closed
            if (!localStorage.getItem('homepopup')) {
                setTimeout(() => {
                    wrapper.classList.add("active");
                }, 2000);
            }

            // Close the popup when clicking on the close button
            closeButton.addEventListener("click", () => {
                localStorage.setItem('homepopup', 'closed');
                wrapper.classList.remove("active");
            });
        }
    }
</script>
@endpush

@section('content')
    <main>
        {{-- landing hero area starts --}}
        <section class="landing--hero--area--wrapper">
            <div class="container">
                <div class="landing--hero--area--content">
                    <div class="intro--area">
                        <div class="intro--text">
                            <h3>COME ALIVE WITH REVIVAL'S RISKY AND POWERFUL STORIES</h3>
                        </div>

                        <div class="intro--btn--wrapper">
                            <a href="{{ route('preoder.index') }}" class="btn--primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="309" height="66" viewBox="0 0 309 66"
                                    fill="none">
                                    <path
                                        d="M17.6744 0.5C4.98152 0.5 -2.95814 14.2328 3.3751 25.2328L21.7991 57.2328C24.7439 62.3476 30.1965 65.5 36.0984 65.5H272.902C278.804 65.5 284.256 62.3476 287.201 57.2328L305.625 25.2328C311.958 14.2328 304.018 0.5 291.326 0.5H17.6744Z"
                                        fill="#FDFE0D" stroke="url(#paint0_linear_4513_1256)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_4513_1256" x1="-132.5" y1="121"
                                            x2="391.5" y2="17" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDFE0D" />
                                            <stop offset="1" stop-color="white" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                                <p>PRE-ORDER ROGUE ASSASSIN</p>
                            </a>

                            <a href="#scrollbtm" class="btn--secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="205" height="66" viewBox="0 0 205 66"
                                    fill="transparent">
                                    <path
                                        d="M17.1908 0.5C5.64128 0.5 -2.33462 12.0605 1.76563 22.8577L13.9176 54.8577C16.3505 61.2642 22.49 65.5 29.3428 65.5H175.657C182.51 65.5 188.65 61.2642 191.082 54.8577L203.234 22.8577C207.335 12.0605 199.359 0.5 187.809 0.5H17.1908Z"
                                        stroke="url(#paint0_linear_4513_1259)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_4513_1259" x1="-86.7979" y1="121"
                                            x2="266.381" y2="74.7661" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDFE0D" />
                                            <stop offset="1" stop-color="white" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                                <p>REVIVE NOW</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- landing hero banner video -->
            <div class="landing--hero--banner--video">
                <video autoplay muted loop src="{{ asset('frontend/videos/landing-hero-banner.mp4') }}"></video>
            </div>

            <!-- gradient overlay -->
            <div class="landing--hero--gradient--overlay"></div>
        </section>
        {{-- landing hero area ends --}}



        {{-- mainstream section area starts --}}
        <section class="mainstream--area--wrapper section--gap">
            <div class="container">
                <div class="mainstream--area--content">
                    <h3 class="common--section--intro">WATCHING MAINSTREAM ENTERTAINMENT IS TUFF</h3>

                    <div class="mainstream--slider--wrapper">
                        <div class="swiper">
                            {{-- Additional required wrapper --}}
                            <div class="swiper-wrapper">
                                {{-- Slides --}}
                                @foreach ($MainstreamEntertainments as $MainstreamEntertainment)
                                    <div class="swiper-slide">
                                        <div class="img--wrapper">
                                            <img src="{{ asset($MainstreamEntertainment->image) ?? 'frontend/images/new-mainstream-slider1.png' }}"
                                                alt="{{ $MainstreamEntertainment->title ?? '' }}" />
                                            {{-- text wrapper --}}
                                            <div class="text--wrapper">
                                                <p>{{ $MainstreamEntertainment->title ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- mainstream section area ends --}}



        {{-- confidence steps area starts --}}
        <section class="landing--confidence--step--area--wrapper section--gap">
            <div class="container">
                <div class="landing--confidence--step--content">
                    <h3 class="common--section--intro">
                        AT REVIVAL YOU CAN EMERSE YOURSELF WITH CONFIDENCE
                    </h3>

                    <div class="confidence--step--holder">
                        <div class="single--column">
                            <div class="confidence--step">
                                <p>
                                    WE STRICTLY FOLLOW OUR CODE OF HONOR THAT ENSURES THAT WE
                                    NEVER LET YOU DOWN
                                </p>
                            </div>
                            <div class="confidence--step">
                                <p>
                                    WE ARE PROUD OF OUR ART AND WE WILL NEVER SUBVERT YOUR
                                    EXPECTATIONS
                                </p>
                            </div>
                            <div class="confidence--step">
                                <p>NO POLITICAL CORRECTNESS</p>
                            </div>
                        </div>
                        <div class="single--column">
                            <div class="confidence--step">
                                <p>
                                    WE PLAN THE BEGINNING MIDDLE AND END OF EVERYTHING BEFORE WE
                                    RELEASE THEM
                                </p>
                            </div>
                            <div class="confidence--step">
                                <p>
                                    GIVING YOU AN UNFORGETTABLE EXPERIENCE IS OUR NUMBER ONE
                                    GOAL
                                </p>
                            </div>
                            <div class="confidence--step arrow--holder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="77" height="44" viewBox="0 0 77 44"
                                    fill="none">
                                    <path d="M71.75 5.375L38.5 38.625L5.25 5.375" stroke="#FFFFEB" stroke-width="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <div class="single--column">
                            <div class="confidence--step">
                                <p>WE WELCOME CHALLENGES AND RISKS</p>
                            </div>
                            <div class="confidence--step">
                                <p>
                                    WE LOVE YOUR FEEDBACK AND WILL NEVER LABLE YOU FOR BEING
                                    GENEROUS ENOUGH TO OFFER IT
                                </p>
                            </div>
                            <div class="confidence--step">
                                <p>NO TROPES FORMULAS OR GIMMICKS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- confidence steps area ends --}}



        {{-- death revival section starts --}}
        <section class="death--revival--area--wrapper section--gap">
            <div class="container">
                <h3 class="common--section--intro">
                    THE DEATH AND REVIVAL OF ENTERTAINMENT
                </h3>

                <div class="death--revival--text--wrapper">
                    <p>
                        WE KNOW HOW IT FEELS LIKE TO PRETEND THAT A LONG-AWAITED MOVIE WAS GREAT. WE TELL OUR FRIENDS THAT WE DRAGGED TO THE THEATER, "OK, MAYBE IT COULD HAVE BEEN BETTER, BUT THEY JUST SET UP THEIR NEXT 79 MOVIES. THEY ARE DEFINITELY GOING TO BE BETTER." (THEY AREN'T)
                    </p>

                    <p>
                       "I'M SURE THEY HAVE A PLAN." (THEY DON'T) "THEY WANT OUR MONEY, RIGHT?" (YES, BUT THEY DON'T WANT YOU) AND IT WILL NEVER GET BETTER, BECAUSE ENTERTAINMENT IS DEAD AND THE INDUSTRY KILLED IT WITH THEIR FEAR OF RISK AND LACK OF RESPECT. 
                    </p>

                    <p>
                        BUT DON'T BE SAD. REVIVAL IS REVIVING ENTERTAINMENT BY BRINGING CREATIVE FREEDOM AND ACTUAL EQUALITY TO THE INDUSTRY. 
                    </p>
                    <p>YOU CAN NOW SETTLE FOR ONLY THE BEST BY PEOPLE WHO PRIORITIZE YOU! OUR CODE OF HONOR ENSURES IT. WE WILL NEVER LET YOU DOWN BECAUSE WE KNOW HOW IT FEELS.</p>
                </div>
            </div>
        </section>
        {{-- death revival section ends --}}



        {{-- hurry up section starts --}}
        <section class="hurry--up--area--wrapper section--gap">
            <div class="extra--wrapper">
                <!-- we want section -->
                <div class="we--want--you--section--area--wrapper">
                    <div class="container">
                        <div class="we--want--you--content">
                            <div class="left">
                                <div class="img--wrapper badge-img">
                                    <img src="{{ asset('frontend/images/we-want-you-intro.png') }}" alt="" />
                                </div>
                                <div class="join--btn">
                                    <a href="#scrollbtm" class="btn--secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="239" height="66"
                                            viewBox="0 0 239 66" fill="none">
                                            <path
                                                d="M17.1214 0.5C5.18075 0.5 -2.80622 12.7907 2.04386 23.702L16.2679 55.702C18.9163 61.6602 24.8251 65.5 31.3454 65.5H207.655C214.175 65.5 220.084 61.6602 222.732 55.702L236.956 23.702C241.806 12.7907 233.819 0.5 221.879 0.5H17.1214Z"
                                                fill="#0F0F00" stroke="url(#paint0_linear_4513_1474)" />
                                            <defs>
                                                <linearGradient id="paint0_linear_4513_1474" x1="-102.074"
                                                    y1="121" x2="308.762" y2="58.0481"
                                                    gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#FDFE0D" />
                                                    <stop offset="1" stop-color="white" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <p>JOIN NOW</p>
                                    </a>
                                </div>
                            </div>
                            <!-- banner image -->
                            <div class="banner--img">
                                <img src="{{ asset('frontend/images/robot.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="hurry--up--area--content">
                    <div class="left">
                        <div class="free--text" style="text-transform: uppercase;">{{ $ProductPromotions->promotion_type ?? 'Free' }}</div>
                        <img src="{{ $ProductPromotions->image ?? 'frontend/images/hurry-up-baner.png' }}"
                            alt="{{ $ProductPromotions->title ?? '' }}" />
                    </div>
                    <div class="right">
                        <h3 class="intro--text">{{ $ProductPromotions->title ?? 'HURRY UP!' }}</h3>
                        <p class="intro--subtext">
                            {{ $ProductPromotions->short_description ?? 'We are only giving away 772 limited edition movie in books aways then its gone!' }}
                        </p>
                        <p class="intro--subtext">
                            JOIN THOUSANDS OF PEOPLE WHO ARE SHOWING THEIR SUPPORT AND HAVE
                            ALREADY CLAIMED THEIR FREE MOVIE TIE IN BOOK, FREE DOCUMENTARY
                            AND MORE!
                        </p>
                    </div>
                </div>
            </div>
        </section>
        {{-- hurry up section ends --}}



        {{-- join revival section area starts --}}
        <section class="join--revival--area--wrapper section--gap" id="scrollbtm">
            <div class="container">
                <div class="btn--area">
                    <a href="javascript:void(0)" class="btn--secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="380" height="66" viewBox="0 0 380 66"
                            fill="none">
                            <path
                                d="M17.4443 0.5C4.03386 0.5 -3.77516 15.6492 4.00479 26.5723L26.7968 58.5723C29.8927 62.919 34.8998 65.5 40.2363 65.5H339.573C344.91 65.5 349.917 62.919 353.013 58.5723L375.805 26.5723C383.585 15.6493 375.776 0.5 362.365 0.5H17.4443Z"
                                fill="url(#paint0_linear_4513_1318)" stroke="url(#paint1_linear_4513_1318)" />
                            <defs>
                                <linearGradient id="paint0_linear_4513_1318" x1="189.905" y1="1"
                                    x2="189.905" y2="65" gradientUnits="userSpaceOnUse">
                                    <stop />
                                    <stop offset="1" stop-color="#1F1F00" />
                                </linearGradient>
                                <linearGradient id="paint1_linear_4513_1318" x1="-165.138" y1="121"
                                    x2="470.32" y2="-35.0225" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#0E0E0E" />
                                    <stop offset="1" stop-color="#8D8D8D" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <p>JOIN THE REVIVAL NOW</p>
                    </a>
                </div>

                <div class="card--area--wrapper" id="join-email-section">
                    <div class="single--card">
                        <div class="intro">
                            <img src="{{ asset('frontend/images/card-intro.png') }}" alt="" />
                        </div>

                        <!-- content holder  -->
                        <div class="content--wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                                fill="none">
                                <g clip-path="url(#clip0_4513_1324)">
                                    <path
                                        d="M66.9775 11.7559H6.99129C3.45709 11.7559 0.594666 14.636 0.594666 18.1525V56.5323C0.594666 60.0696 3.47812 62.9289 6.99129 62.9289H66.9775C70.4821 62.9289 73.3741 60.0817 73.3741 56.5323V18.1525C73.3741 14.6423 70.523 11.7559 66.9775 11.7559ZM66.0816 16.0203L41.5075 40.4649C40.2993 41.6732 38.693 42.3384 36.9844 42.3384C35.2758 42.3384 33.6695 41.673 32.4573 40.4609L7.88711 16.0203H66.0816ZM4.85909 55.6643V19.0231L23.2868 37.3537L4.85909 55.6643ZM7.88981 58.6645L26.3103 40.3612L29.4459 43.4803C31.4595 45.494 34.1367 46.6028 36.9844 46.6028C39.832 46.6028 42.5092 45.494 44.5189 43.4843L47.6585 40.3612L66.0789 58.6645H7.88981ZM69.1097 55.6643L50.682 37.3537L69.1097 19.0231V55.6643Z"
                                        fill="#0F0F00" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_4513_1324">
                                        <rect width="72.7794" height="72.7794" fill="white"
                                            transform="translate(0.602478 0.953125)" />
                                    </clipPath>
                                </defs>
                            </svg>

                            <p>ENTER EMAIL</p>
                        </div>
                    </div>
                    <div class="single--card">
                        <div class="intro">
                            <img src="{{ asset('frontend/images/card-intro2.png') }}" alt="" />
                        </div>

                        <!-- content holder  -->
                        <div class="content--wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                                fill="none">
                                <path
                                    d="M36.416 70.8909C35.9268 70.8905 35.4507 70.7326 35.0583 70.4406C34.6658 70.1485 34.3779 69.7378 34.2372 69.2693L20.591 23.7821C20.4732 23.3887 20.464 22.9708 20.5644 22.5726C20.6649 22.1745 20.8713 21.8109 21.1616 21.5206C21.452 21.2302 21.8156 21.0238 22.2137 20.9234C22.6119 20.8229 23.0298 20.8321 23.4232 20.95L68.9103 34.5961C69.3237 34.7203 69.6933 34.9594 69.9761 35.2856C70.2588 35.6117 70.4431 36.0115 70.5075 36.4383C70.5712 36.8653 70.5121 37.3016 70.3371 37.6963C70.1621 38.091 69.8785 38.4277 69.5193 38.6672L58.1822 46.2255L69.8661 57.9105C70.0774 58.1216 70.2451 58.3723 70.3595 58.6482C70.4738 58.9241 70.5327 59.2198 70.5327 59.5185C70.5327 59.8172 70.4738 60.1129 70.3595 60.3889C70.2451 60.6648 70.0774 60.9154 69.8661 61.1265L60.7687 70.2239C60.5576 70.4352 60.307 70.6029 60.0311 70.7173C59.7551 70.8316 59.4594 70.8905 59.1607 70.8905C58.862 70.8905 58.5663 70.8316 58.2904 70.7173C58.0145 70.6029 57.7638 70.4352 57.5527 70.2239L45.8677 58.54L38.3094 69.8771C38.1016 70.1888 37.8201 70.4445 37.4898 70.6213C37.1595 70.7982 36.7907 70.8908 36.416 70.8909ZM45.5134 52.696C46.1144 52.696 46.6927 52.9337 47.1214 53.3624L59.1596 65.4006L65.0405 59.5191L53.0029 47.4809C52.7647 47.2431 52.5824 46.9553 52.469 46.6384C52.3556 46.3215 52.314 45.9833 52.3471 45.6484C52.3803 45.3134 52.4875 44.99 52.6609 44.7015C52.8342 44.413 53.0695 44.1666 53.3497 43.9801L62.9737 37.5647L26.1632 26.5216L37.2064 63.332L43.6217 53.7081C43.8292 53.3966 44.1105 53.1412 44.4405 52.9646C44.7706 52.788 45.1391 52.6957 45.5134 52.696ZM15.2804 15.6399C15.4917 15.4288 15.6594 15.1782 15.7738 14.9023C15.8881 14.6264 15.947 14.3306 15.947 14.0319C15.947 13.7333 15.8881 13.4375 15.7738 13.1616C15.6594 12.8857 15.4917 12.635 15.2804 12.424L10.7317 7.87526C9.84299 6.98655 8.4039 6.98655 7.51576 7.87526C6.62762 8.76396 6.62705 10.2031 7.51576 11.0912L12.0645 15.6399C12.5085 16.084 13.0902 16.3063 13.6724 16.3063C14.2547 16.3063 14.8363 16.084 15.2804 15.6399ZM13.6724 23.1294C13.6724 22.5262 13.4328 21.9477 13.0063 21.5212C12.5798 21.0946 12.0013 20.855 11.3981 20.855H4.57502C3.97182 20.855 3.39333 21.0946 2.9668 21.5212C2.54028 21.9477 2.30066 22.5262 2.30066 23.1294C2.30066 23.7326 2.54028 24.3111 2.9668 24.7376C3.39333 25.1641 3.97182 25.4037 4.57502 25.4037H11.3981C12.0013 25.4037 12.5798 25.1641 13.0063 24.7376C13.4328 24.3111 13.6724 23.7326 13.6724 23.1294ZM10.7317 38.3835L15.2804 33.8348C16.1691 32.9461 16.1691 31.507 15.2804 30.6188C14.3917 29.7307 12.9526 29.7301 12.0645 30.6188L7.51576 35.1675C7.30444 35.3786 7.13679 35.6293 7.02241 35.9052C6.90803 36.1811 6.84915 36.4768 6.84915 36.7755C6.84915 37.0742 6.90803 37.3699 7.02241 37.6458C7.13679 37.9218 7.30444 38.1724 7.51576 38.3835C7.95983 38.8276 8.54149 39.0499 9.12373 39.0499C9.70597 39.0499 10.2876 38.8276 10.7317 38.3835ZM33.4753 15.6399L38.024 11.0912C38.9127 10.2025 38.9127 8.76339 38.024 7.87526C37.1353 6.98712 35.6962 6.98655 34.808 7.87526L30.2593 12.424C30.048 12.635 29.8804 12.8857 29.766 13.1616C29.6516 13.4375 29.5927 13.7333 29.5927 14.0319C29.5927 14.3306 29.6516 14.6264 29.766 14.9023C29.8804 15.1782 30.048 15.4288 30.2593 15.6399C30.7034 16.084 31.2851 16.3063 31.8673 16.3063C32.4495 16.3063 33.0312 16.084 33.4753 15.6399ZM25.0442 11.7576V4.93451C25.0442 4.33132 24.8046 3.75282 24.3781 3.3263C23.9516 2.89978 23.3731 2.66016 22.7699 2.66016C22.1667 2.66016 21.5882 2.89978 21.1617 3.3263C20.7351 3.75282 20.4955 4.33132 20.4955 4.93451V11.7576C20.4955 12.3608 20.7351 12.9393 21.1617 13.3658C21.5882 13.7923 22.1667 14.0319 22.7699 14.0319C23.3731 14.0319 23.9516 13.7923 24.3781 13.3658C24.8046 12.9393 25.0442 12.3608 25.0442 11.7576Z"
                                    fill="#0F0F00" />
                            </svg>

                            <p>Click</p>
                        </div>
                    </div>
                    <div class="single--card">
                        <div class="intro">
                            <img src="{{ asset('frontend/images/card-intro3.png') }}" alt="" />
                        </div>

                        <!-- content holder  -->
                        <div class="content--wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                                fill="none">
                                <g clip-path="url(#clip0_4513_1342)">
                                    <path
                                        d="M73.1481 49.2945C73.1481 49.2931 73.1481 49.2931 73.1481 49.2945C72.4317 46.6222 70.4885 44.227 67.8161 42.7188C66.5814 42.0207 65.2354 41.5407 63.8374 41.3002C64.9277 40.3928 65.8538 39.3047 66.5752 38.0834C68.136 35.4423 68.6207 32.3946 67.9071 29.7223V29.7208C66.9562 26.1871 63.3087 24.0804 59.7734 25.0257C58.207 25.4465 56.8751 26.4088 55.9795 27.7521L53.2233 17.4677C53.1452 17.177 52.9551 16.9291 52.6945 16.7783C52.4331 16.6282 52.123 16.5873 51.8317 16.6646L42.5082 19.1636C41.9027 19.3256 41.5431 19.9496 41.7051 20.5552L45.5957 35.077H1.73329C1.10642 35.077 0.597534 35.5858 0.597534 36.2127V70.0395C0.597534 70.6678 1.10642 71.1753 1.73329 71.1753H47.0442C47.671 71.1753 48.1799 70.6664 48.1799 70.0395V44.7288L55.0399 70.3337C55.1048 70.5753 55.2475 70.7887 55.4458 70.9411C55.6442 71.0935 55.8872 71.1763 56.1373 71.1767C56.234 71.1767 56.3335 71.1639 56.4316 71.1383L65.755 68.6408C66.046 68.5627 66.2941 68.3722 66.4447 68.1113C66.5953 67.8503 66.6361 67.5402 66.5581 67.2492L63.8033 56.9676C64.7259 57.4239 65.7223 57.6556 66.7301 57.6556C67.3044 57.6556 67.8815 57.5803 68.4501 57.4268C70.1587 56.9705 71.5887 55.8703 72.4771 54.3308C73.367 52.7899 73.6044 51.0017 73.1481 49.2945ZM2.86905 37.3499H19.6595V68.9037H2.86905V37.3499ZM21.9324 68.9037V37.3499H26.8408V68.9037H21.9324ZM45.907 68.9037H29.1137V37.3499H45.9084V68.9037H45.907ZM49.3143 40.1758L56.4415 38.2653L57.6441 42.7515L57.6967 42.9448L57.7976 43.3187L58.9518 47.6257L51.826 49.5348L49.3143 40.1758ZM57.7123 29.2617C58.298 28.2468 59.239 27.5218 60.3605 27.2219C60.7281 27.123 61.1071 27.0729 61.4877 27.0726C63.4153 27.0726 65.1864 28.3619 65.7109 30.3108C66.7358 34.1473 64.4586 39.3044 59.583 41.2007L58.8552 38.4885L57.2717 32.5695C56.9703 31.4508 57.1267 30.2766 57.7123 29.2617ZM51.3214 19.155L55.8544 36.072L48.7258 37.9824L44.1927 21.0655L51.3214 19.155ZM56.9419 68.6493L52.4102 51.7338L59.5389 49.8233L64.0706 66.7388L56.9419 68.6493ZM70.5098 53.1936C69.9242 54.2071 68.9846 54.9307 67.8631 55.2306C66.7415 55.532 65.5659 55.3756 64.5524 54.7899C63.5389 54.2043 62.814 53.2647 62.5155 52.1417L61.4522 48.1772L61.4437 48.1374L60.2042 43.5162C65.3741 42.7188 69.9228 46.0479 70.9533 49.8816C71.2518 51.0031 71.0955 52.1801 70.5098 53.1936ZM14.9601 13.236L18.8222 16.0292L17.3382 20.5566C17.0568 21.4166 17.361 22.3519 18.0873 22.8764C18.4541 23.1465 18.8848 23.2816 19.3155 23.2816C19.7448 23.2816 20.1726 23.1479 20.538 22.8793L24.3873 20.0747L28.2338 22.8807C28.9673 23.4123 29.9467 23.4138 30.6759 22.8821C31.4108 22.3533 31.7136 21.4209 31.4321 20.5566L29.9524 16.0292L33.8046 13.2403C34.5423 12.7129 34.8493 11.7776 34.5665 10.9119C34.4311 10.4942 34.1668 10.1302 33.8115 9.87222C33.4562 9.61424 33.0283 9.47559 32.5892 9.47622L27.823 9.48759L26.3603 4.95451C26.086 4.09168 25.2914 3.51172 24.383 3.51172C23.4832 3.51172 22.6886 4.08884 22.4072 4.95167L20.9431 9.48759L16.1783 9.47622C15.2757 9.47622 14.4796 10.0533 14.1996 10.9119C13.9238 11.7719 14.2266 12.7058 14.9601 13.236ZM21.0866 11.7591C21.9893 11.7591 22.7853 11.182 23.0668 10.3192L24.3873 6.22815L25.7093 10.3234C25.8451 10.7417 26.1101 11.1062 26.4662 11.3644C26.8222 11.6226 27.251 11.7613 27.6908 11.7605L31.9936 11.7492L28.5153 14.268C27.7761 14.7954 27.4705 15.7335 27.7534 16.6006L29.0895 20.6888L25.614 18.1529C24.8791 17.6184 23.8941 17.6198 23.1691 18.1543L19.6908 20.6888L21.0298 16.6006C21.3112 15.7378 21.007 14.8025 20.2736 14.2723L16.7853 11.7492L21.0866 11.7591ZM37.4705 23.3398C38.0988 23.3398 38.6063 23.8487 38.6063 24.4756C38.6063 25.1025 38.0974 25.6114 37.4705 25.6114C34.0604 25.6114 31.2857 28.3861 31.2857 31.7962C31.2857 32.4245 30.7768 32.9319 30.15 32.9319C29.5231 32.9319 29.0142 32.4231 29.0142 31.7962C29.0128 27.1338 32.8067 23.3398 37.4705 23.3398ZM10.1712 24.477C10.1712 23.8487 10.68 23.3413 11.3069 23.3413C15.9708 23.3413 19.7647 27.1352 19.7647 31.799C19.7647 32.4273 19.2558 32.9348 18.6289 32.9348C18.002 32.9348 17.4932 32.4259 17.4932 31.799C17.4932 28.3889 14.7184 25.6142 11.3083 25.6142C10.68 25.6128 10.1712 25.1039 10.1712 24.477Z"
                                        fill="#0F0F00" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_4513_1342">
                                        <rect width="72.7794" height="72.7794" fill="white"
                                            transform="translate(0.597534 0.953125)" />
                                    </clipPath>
                                </defs>
                            </svg>

                            <p>CLAIM FREE GIFTS, PERKS AND UPDATES!</p>
                        </div>
                    </div>

                    <!-- paths -->
                    <div class="path path1" id="join--revival">
                        <svg xmlns="http://www.w3.org/2000/svg" width="421" height="173" viewBox="0 0 421 173"
                            fill="none">
                            <path
                                d="M0.908854 167C0.908854 169.946 3.29667 172.333 6.24219 172.333C9.18771 172.333 11.5755 169.946 11.5755 167C11.5755 164.054 9.18771 161.667 6.24219 161.667C3.29667 161.667 0.908854 164.054 0.908854 167ZM409.482 5.5C409.482 8.44552 411.87 10.8333 414.816 10.8333C417.761 10.8333 420.149 8.44552 420.149 5.5C420.149 2.55448 417.761 0.166667 414.816 0.166667C411.87 0.166667 409.482 2.55448 409.482 5.5ZM7.24219 167V129H5.24219V167H7.24219ZM17.2422 119H403.816V117H17.2422V119ZM415.816 107V5.5H413.816V107H415.816ZM403.816 119C410.443 119 415.816 113.627 415.816 107H413.816C413.816 112.523 409.339 117 403.816 117V119ZM7.24219 129C7.24219 123.477 11.7193 119 17.2422 119V117C10.6148 117 5.24219 122.373 5.24219 129H7.24219Z"
                                fill="white" />
                        </svg>
                    </div>
                    <div class="path path2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="153" viewBox="0 0 12 153"
                            fill="none">
                            <path
                                d="M5.90625 0.666667C2.96073 0.666666 0.572917 3.05448 0.572917 6C0.572916 8.94552 2.96073 11.3333 5.90625 11.3333C8.85177 11.3333 11.2396 8.94552 11.2396 6C11.2396 3.05448 8.85177 0.666667 5.90625 0.666667ZM5.90624 141.667C2.96073 141.667 0.57291 144.054 0.57291 147C0.57291 149.946 2.96072 152.333 5.90624 152.333C8.85176 152.333 11.2396 149.946 11.2396 147C11.2396 144.054 8.85176 141.667 5.90624 141.667ZM4.90625 6L4.90624 147L6.90624 147L6.90625 6L4.90625 6Z"
                                fill="white" />
                        </svg>
                    </div>
                    <div class="path path3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="420" height="173" viewBox="0 0 420 173"
                            fill="none">
                            <path
                                d="M419.911 167C419.911 169.946 417.524 172.333 414.578 172.333C411.633 172.333 409.245 169.946 409.245 167C409.245 164.054 411.633 161.667 414.578 161.667C417.524 161.667 419.911 164.054 419.911 167ZM11.3379 5.5C11.3379 8.44552 8.9501 10.8333 6.00458 10.8333C3.05908 10.8333 0.671265 8.44552 0.671265 5.5C0.671265 2.55448 3.05908 0.166667 6.00458 0.166667C8.9501 0.166667 11.3379 2.55448 11.3379 5.5ZM413.578 167V129H415.578V167H413.578ZM403.578 119H17.0046V117H403.578V119ZM5.00458 107V5.5H7.00458V107H5.00458ZM17.0046 119C10.3772 119 5.00458 113.627 5.00458 107H7.00458C7.00458 112.523 11.4818 117 17.0046 117V119ZM413.578 129C413.578 123.477 409.101 119 403.578 119V117C410.206 117 415.578 122.373 415.578 129H413.578Z"
                                fill="white" />
                        </svg>
                    </div>
                </div>

                <div class="input--area--wrapper" id="join-link">
                    <form action="{{ route('store.email') }}" method="POST">
                        @csrf
                        <div class="input--wrapper">
                            <input type="email" id="email" name="email" placeholder="ENTER YOUR EMAIL"
                                required />
                            <svg xmlns="http://www.w3.org/2000/svg" width="1078" height="66" viewBox="0 0 1078 66"
                                fill="none">
                                <path
                                    d="M17.2595 0.5C1.81919 0.5 -5.16242 19.8126 6.7087 29.6858L45.1841 61.6858C48.1476 64.1506 51.8804 65.5 55.7349 65.5H1022.27C1026.12 65.5 1029.85 64.1506 1032.82 61.6858L1071.29 29.6858C1083.16 19.8126 1076.18 0.5 1060.74 0.5H17.2595Z"
                                    stroke="url(#paint0_linear_4513_1353)" />
                                <defs>
                                    <linearGradient id="paint0_linear_4513_1353" x1="-448.489" y1="121"
                                        x2="829.495" y2="-751.726" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FDFE0D" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                </defs>
                            </svg>

                            <div class="mail--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M21.8906 3.5625H2.10938C0.943922 3.5625 0 4.51228 0 5.67188V18.3281C0 19.4946 0.950859 20.4375 2.10938 20.4375H21.8906C23.0463 20.4375 24 19.4986 24 18.3281V5.67188C24 4.51434 23.0598 3.5625 21.8906 3.5625ZM21.5952 4.96875L13.4916 13.0297C13.0931 13.4281 12.5634 13.6475 12 13.6475C11.4366 13.6475 10.9069 13.4281 10.5071 13.0284L2.40478 4.96875H21.5952ZM1.40625 18.0419V5.95898L7.48303 12.0037L1.40625 18.0419ZM2.40567 19.0312L8.48006 12.9955L9.51408 14.0241C10.1781 14.6881 11.061 15.0538 12 15.0538C12.939 15.0538 13.8219 14.6881 14.4846 14.0254L15.5199 12.9955L21.5943 19.0312H2.40567ZM22.5938 18.0419L16.517 12.0037L22.5938 5.95898V18.0419Z"
                                        fill="#FFFFEB" />
                                </svg>
                            </div>
                        </div>
                        <div class="submit--btn">
                            <button class="btn--primary" type="submit" for = "email">
                                <svg xmlns="http://www.w3.org/2000/svg" width="205" height="66"
                                    viewBox="0 0 205 66" fill="none">
                                    <path
                                        d="M17.1908 0.5C5.64128 0.5 -2.33462 12.0605 1.76563 22.8577L13.9176 54.8577C16.3505 61.2642 22.49 65.5 29.3428 65.5H175.657C182.51 65.5 188.65 61.2642 191.082 54.8577L203.234 22.8577C207.335 12.0605 199.359 0.5 187.809 0.5H17.1908Z"
                                        fill="#FDFE0D" stroke="url(#paint0_linear_4513_1361)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_4513_1361" x1="-86.7979" y1="121"
                                            x2="266.381" y2="74.7661" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDFE0D" />
                                            <stop offset="1" stop-color="white" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <p>SEND</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        {{-- join revival section area ends --}}



        <!-- discover more section area starts -->
        <section class="discover--more--section--area--wrapper section--gap">
            <div class="container">
                <h3 class="common--section--intro">DISCOVER MORE</h3>

                <div class="discover--more--slider--wrapper">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            
                            <div class="swiper-slide">
                                <a href="{{route('preoder.index')}}" class="arrow--btn">
                                <div class="img--holder">
                                    <img src="{{ asset('frontend/images/disover-slide1.png') }}" alt="" />
                                    <!-- description holder -->
                                    <div class="description--holder">
                                        <div class="text--area">
                                            <p>SUPPORT THE REVIVAL AND START EARNING NOW!</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            
                            <div class="swiper-slide">
                                <a href="{{route('shop.category')}}" class="arrow--btn">
                                <div class="img--holder">
                                    <img src="{{ asset('frontend/images/disover-slide2.png') }}" alt="" />
                                    <!-- description holder -->
                                    <div class="description--holder">
                                        <div class="text--area">
                                            <p>
                                                HURRY! DON’T MISS OUT ON EXCLUSIVE MERCH AND COMICS
                                                AVAILABLE FOR A LIMITED TIME ONLY
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            
                            <div class="swiper-slide">
                                <a href="{{route('affiliate')}}" class="arrow--btn">
                                <div class="img--holder">
                                    <img src="{{ asset('frontend/images/disover-slide3.png') }}" alt="" />
                                    <!-- description holder -->
                                    <div class="description--holder">
                                        <div class="text--area">
                                            <p>
                                                BUILD YOUR PLATFORM, SUPPORT THE REVIVAL AND START
                                                EARNING NOW.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            
                            <div class="swiper-slide">
                                <a href="{{route('continuity')}}" class="arrow--btn">
                                <div class="img--holder">
                                    <img src="{{ asset('frontend/images/disover-slide4.png') }}" alt="" />
                                    <!-- description holder -->
                                    <div class="description--holder">
                                        <div class="text--area">
                                            <p>
                                                1 ASSASSIN 5 HEROES, WHO CAN SURVIVE THE AGE OF WAR ?
                                                STEP INTO THE REVIVAL SAGA AND FIND OUT
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            
                            <div class="swiper-slide">
                                <a href="{{route('shop.category')}}" class="arrow--btn">
                                <div class="img--holder">
                                    <img src="{{ asset('frontend/images/disover-slide2.png') }}" alt="" />
                                    <!-- description holder -->
                                    <div class="description--holder">
                                        <div class="text--area">
                                            <p>
                                                HURRY! DON’T MISS OUT ON EXCLUSIVE MERCH AND COMICS
                                                AVAILABLE FOR A LIMITED TIME ONLY
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            
                            <div class="swiper-slide">
                                <a href="{{route('affiliate')}}" class="arrow--btn">
                                <div class="img--holder">
                                    <img src="{{ 'frontend/images/disover-slide3.png' }}" alt="" />
                                    <!-- description holder -->
                                    <div class="description--holder">
                                        <div class="text--area">
                                            <p>
                                                BUILD YOUR PLATFORM, SUPPORT THE REVIVAL AND START
                                                EARNING NOW.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            
                        </div>
                    </div>

                    <!-- slider controls -->
                    <button class="previous--slide--btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                            fill="none">
                            <g filter="url(#filter0_d_4513_1412)">
                                <g clip-path="url(#clip0_4513_1412)">
                                    <path
                                        d="M58 31C58 26.975 57.825 23.3 57.125 21.2C56.425 18.75 55.55 16.475 53.45 14.375C50.825 11.925 48.55 11.225 45.05 10.525C42.6 10.175 39.625 10 37.875 10H36.3C34.375 10 31.575 10.175 28.95 10.525C25.45 11.225 23 12.1 20.55 14.375C18.275 16.475 17.575 18.75 16.875 21.2C16.175 23.3 16 26.975 16 31C16 35.025 16.175 38.7 16.875 40.8C17.575 43.25 18.45 45.525 20.55 47.625C23.175 50.075 25.45 50.775 28.95 51.475C31.75 52 35.25 52 37 52C38.75 52 42.25 52 45.225 51.475C48.55 50.775 51 50.075 53.625 47.625C55.725 45.7 56.6 43.425 57.3 40.8C57.825 38.7 58 35.025 58 31Z"
                                        fill="#FDFE0D" />
                                    <path
                                        d="M42.2516 21.7242C41.5516 21.0242 40.5016 21.0242 39.8016 21.7242L31.7516 29.7742C31.0516 30.4742 31.0516 31.5242 31.7516 32.2242L39.8016 40.2742C40.5016 40.9742 41.5516 40.9742 42.2516 40.2742C42.9516 39.5742 42.9516 38.5242 42.2516 37.8242L35.4266 30.9992L42.2516 24.1742C42.9516 23.4742 42.9516 22.4242 42.2516 21.7242Z"
                                        fill="#141414" />
                                </g>
                            </g>
                            <defs>
                                <filter id="filter0_d_4513_1412" x="0" y="0" width="74" height="74"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                    <feOffset dy="6" />
                                    <feGaussianBlur stdDeviation="8" />
                                    <feComposite in2="hardAlpha" operator="out" />
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0" />
                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                        result="effect1_dropShadow_4513_1412" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4513_1412"
                                        result="shape" />
                                </filter>
                                <clipPath id="clip0_4513_1412">
                                    <rect x="16" y="10" width="42" height="42" rx="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <button class="next--slide--btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74"
                            fill="none">
                            <g filter="url(#filter0_d_4513_1416)">
                                <g clip-path="url(#clip0_4513_1416)">
                                    <path
                                        d="M16 31C16 26.975 16.175 23.3 16.875 21.2C17.575 18.75 18.45 16.475 20.55 14.375C23.175 11.925 25.45 11.225 28.95 10.525C31.4 10.175 34.375 10 36.125 10H37.7C39.625 10 42.425 10.175 45.05 10.525C48.55 11.225 51 12.1 53.45 14.375C55.725 16.475 56.425 18.75 57.125 21.2C57.825 23.3 58 26.975 58 31C58 35.025 57.825 38.7 57.125 40.8C56.425 43.25 55.55 45.525 53.45 47.625C50.825 50.075 48.55 50.775 45.05 51.475C42.25 52 38.75 52 37 52C35.25 52 31.75 52 28.775 51.475C25.45 50.775 23 50.075 20.375 47.625C18.275 45.7 17.4 43.425 16.7 40.8C16.175 38.7 16 35.025 16 31Z"
                                        fill="#FDFE0D" />
                                    <path
                                        d="M31.7484 21.7242C32.4484 21.0242 33.4984 21.0242 34.1984 21.7242L42.2484 29.7742C42.9484 30.4742 42.9484 31.5242 42.2484 32.2242L34.1984 40.2742C33.4984 40.9742 32.4484 40.9742 31.7484 40.2742C31.0484 39.5742 31.0484 38.5242 31.7484 37.8242L38.5734 30.9992L31.7484 24.1742C31.0484 23.4742 31.0484 22.4242 31.7484 21.7242Z"
                                        fill="#141414" />
                                </g>
                            </g>
                            <defs>
                                <filter id="filter0_d_4513_1416" x="0" y="0" width="74" height="74"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                    <feOffset dy="6" />
                                    <feGaussianBlur stdDeviation="8" />
                                    <feComposite in2="hardAlpha" operator="out" />
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0" />
                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                        result="effect1_dropShadow_4513_1416" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4513_1416"
                                        result="shape" />
                                </filter>
                                <clipPath id="clip0_4513_1416">
                                    <rect width="42" height="42" rx="16"
                                        transform="matrix(-1 0 0 1 58 10)" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        <!-- discover more section area ends -->
    </main>

    <div class="delay--popup--wrapper">
        <div class="delay--popup--content">
          <!-- book area -->
          <div class="top--part">
            <img src="{{asset('frontend/images/home-page-delay-popup.png')}}" alt="" />
          </div>
        <form action="{{ route('store.email') }}" method="POST">
            @csrf
          <div class="bottom--part">
            <div class="email--container">
              <div class="input--wrapper">
                <input type="email" name="email" placeholder="ENTER YOUR EMAIL" required />
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="570"
                  height="66"
                  viewBox="0 0 570 66"
                  fill="none"
                >
                  <path
                    d="M17.9609 0.5C4.98105 0.5 -2.91645 14.7949 3.99283 25.7831L24.1143 57.7831C27.1341 62.5856 32.4093 65.5 38.0824 65.5H531.918C537.591 65.5 542.866 62.5856 545.886 57.7831L566.007 25.7831C572.916 14.7949 565.019 0.5 552.039 0.5H17.9609Z"
                    stroke="url(#paint0_linear_4764_5518)"
                  />
                  <defs>
                    <linearGradient
                      id="paint0_linear_4764_5518"
                      x1="-231.426"
                      y1="121"
                      x2="637.742"
                      y2="-189.407"
                      gradientUnits="userSpaceOnUse"
                    >
                      <stop stop-color="#FDFE0D" />
                      <stop offset="1" stop-color="white" />
                    </linearGradient>
                  </defs>
                </svg>

                <div class="mail--icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                  >
                    <path
                      d="M21.8906 3.5625H2.10938C0.943922 3.5625 0 4.51228 0 5.67188V18.3281C0 19.4946 0.950859 20.4375 2.10938 20.4375H21.8906C23.0463 20.4375 24 19.4986 24 18.3281V5.67188C24 4.51434 23.0598 3.5625 21.8906 3.5625ZM21.5952 4.96875L13.4916 13.0297C13.0931 13.4281 12.5634 13.6475 12 13.6475C11.4366 13.6475 10.9069 13.4281 10.5071 13.0284L2.40478 4.96875H21.5952ZM1.40625 18.0419V5.95898L7.48303 12.0037L1.40625 18.0419ZM2.40567 19.0312L8.48006 12.9955L9.51408 14.0241C10.1781 14.6881 11.061 15.0538 12 15.0538C12.939 15.0538 13.8219 14.6881 14.4846 14.0254L15.5199 12.9955L21.5943 19.0312H2.40567ZM22.5938 18.0419L16.517 12.0037L22.5938 5.95898V18.0419Z"
                      fill="#FFFFEB"
                    />
                  </svg>
                </div>
              </div>
            </div>
            <div class="submit--btn">
                <button class="btn--primary" type="submit" for = "email" style="background-color: transparent;border: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="205" height="66"
                        viewBox="0 0 205 66" fill="none">
                        <path
                            d="M17.1908 0.5C5.64128 0.5 -2.33462 12.0605 1.76563 22.8577L13.9176 54.8577C16.3505 61.2642 22.49 65.5 29.3428 65.5H175.657C182.51 65.5 188.65 61.2642 191.082 54.8577L203.234 22.8577C207.335 12.0605 199.359 0.5 187.809 0.5H17.1908Z"
                            fill="#FDFE0D" stroke="url(#paint0_linear_4513_1361)" />
                        <defs>
                            <linearGradient id="paint0_linear_4513_1361" x1="-86.7979" y1="121"
                                x2="266.381" y2="74.7661" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FDFE0D" />
                                <stop offset="1" stop-color="white" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <p>SEND</p>
                </button>
            </div>
          </div>
        </form>

          <!-- close popup -->
          <div class="close">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="30"
              height="30"
              viewBox="0 0 30 30"
              fill="none"
            >
              <g clip-path="url(#clip0_4764_5528)">
                <path
                  d="M17.7484 15.0244L29.43 3.34258C30.1901 2.58272 30.1901 1.35409 29.43 0.594313C28.6701 -0.165552 27.4415 -0.165552 26.6817 0.594313L14.9999 12.276L3.31844 0.594313C2.55821 -0.165552 1.33004 -0.165552 0.570172 0.594313C-0.190057 1.35418 -0.190057 2.58272 0.570172 3.34258L12.2515 15.0244L0.570263 26.7061C-0.189966 27.4659 -0.189966 28.6946 0.570263 29.4543C0.750507 29.6351 0.964691 29.7784 1.20051 29.8762C1.43633 29.9739 1.68913 30.0241 1.9444 30.0238C2.44186 30.0238 2.93951 29.8334 3.31853 29.4543L14.9999 17.7726L26.6817 29.4543C26.862 29.6351 27.0762 29.7784 27.312 29.8761C27.5478 29.9738 27.8006 30.024 28.0559 30.0238C28.5533 30.0238 29.051 29.8334 29.43 29.4543C30.1901 28.6945 30.1901 27.4659 29.43 26.7061L17.7484 15.0244Z"
                  fill="#5A5C5F"
                />
              </g>
              <defs>
                <clipPath id="clip0_4764_5528">
                  <rect width="30" height="30" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </div>
        </div>
      </div>

@endsection
