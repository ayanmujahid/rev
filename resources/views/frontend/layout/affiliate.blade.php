@extends('frontend.app')

@section('title')
    Affiliate
@endsection

@push('style')
    <style>
       

    </style>
@endpush

@push('script')
<script>
    // Get the modal
    var modal = document.getElementById("premiumModal");

    // Get the button that opens the modal
    var btn = document.getElementById("openModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script>
    // Copy the selected date to the hidden input when the form is submitted
    document.getElementById('booking-form').addEventListener('submit', function() {
        document.getElementById('hidden-meeting-date').value = document.getElementById('meeting-date').value;
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('meeting-date');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const bookingForm = document.getElementById('booking-form');

    dateInput.addEventListener('change', function () {
        const selectedDate = dateInput.value;

        // Fetch time slots for the selected date via AJAX
        fetch(`/get-time-slots?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                // Clear previous time slots
                timeSlotsContainer.innerHTML = '';

                // Append new time slots
                data.forEach(timeSlot => {
                    const timeSlotElement = document.createElement('div');
                    timeSlotElement.innerHTML = `
                        <p>${timeSlot.time_slots}</p>
                        ${Number(timeSlot.status) === 1 ?
    `<p class="bkd">Booked</p>` : 
    `<input class="chked" type="radio" name="schedule_id" value="${timeSlot.id}" required> Select`
}
                    `;
                    timeSlotsContainer.appendChild(timeSlotElement);
                });
            })
            .catch(error => {
                console.error('Error fetching time slots:', error);
                alert('An error occurred while fetching time slots.');
            });
    });

    // Form submission handling
    bookingForm.addEventListener('submit', function (event) {
        const selectedScheduleId = document.querySelector('input[name="schedule_id"]:checked');
        if (!selectedScheduleId) {
            alert('Please select a time slot.');
            event.preventDefault(); // Prevent default form submission
            return;
        }

        // Append the selected schedule ID to the form dynamically
        const scheduleIdInput = document.createElement('input');
        scheduleIdInput.type = 'hidden';
        scheduleIdInput.name = 'schedule_id';
        scheduleIdInput.value = selectedScheduleId.value;
        bookingForm.appendChild(scheduleIdInput);
    });
});

</script>
@endpush

@section('content')
    <main>
        {{-- landing banner area starts --}}
        <section class="affiliate--banner--area--wrapper">
            <div class="container">
                <div class="affiliate--banner--area--content">
                    <h3 class="hero--text">LET’S BUILD YOUR PLATFORM!</h3>
                </div>
            </div>
        </section>
        {{-- landing banner area ends --}}



        {{-- don't be him section area starts --}}
        <section class="about--continuity--area--wrapper trouble--area--wrapper section--gap">
            <div class="container">
                <div class="about--continuity--area--content">
                    <div class="left">
                        <!--<img src="{{ asset('frontend/images/trouble-area-banner.png') }}" alt="" />-->
                        <img src="{{ asset('frontend/images/dont-be-him.png') }}" alt="" />
                    </div>
                    <div class="right">
                        <div class="text--wrapper">
                            <p>Trouble reaching your future audience?</p>
                            <p>Trouble monitizing your platform?</p>
                            <p>All of your trouble is now gone!</p>
                        </div>

                        <h3 class="main--text">
                            The revival creators program makes becoming an online creator so
                            simple littertaly anyone can do it!
                        </h3>
                    </div>
                </div>
            </div>
        </section>
        {{-- don't be him section area ends --}}



        {{-- how is this possible area starts --}}
        <section class="how--is--this--possible--area--wrapper section--gap">
            <div class="container">
                <h3 class="affiliate--common-title">How is this possible?</h3>
                <div class="how--is--this--possible--area--content">
                    <div class="text--content">
                        <div class="steps--list--wrapper">
                            <ul>
                                <li class="active">
                                    <p class="title">You create a channel.</p>
                                    
                                </li>
                                <li>
                                    <p class="title">
                                        We jump start it for the algorithm and get it ready for
                                        monetization.
                                    </p>
                                    
                                </li>
                                <li>
                                    <p class="title">You swim in money.</p>
                                    
                                </li>
                            </ul>
                        </div>

                        <div class="subtext">
                            You can finally quit the grind and stop begging your neighbors who you don’t like to follow you, because that’s not even all! Once you are monetized, we will provide you with additional exclusive opportunities to maximize your platform's income and reach, and we will even reward you with free prizes!
                        </div>
                    </div>
                </div>
            </div>

            <div class="featrue--img--wrapper">
                <img src="{{ asset('frontend/images/how-is-this-possible-feature.png') }}" alt="" />
            </div>
        </section>
        {{-- how is this possible area ends --}}



        {{-- pricing for you area starts --}}
<section class="pricing--for--you--area--wrapper section--gap">
            <h3 class="affiliate--common-title">Pricing for you</h3>
            <div class="container">
                <div class="pricing--for--you--area--content">
                    <div class="pricing--card">
    <div class="top--part">
        <div class="left">
            <div class="pricing--tag">PREMIUM</div>
            {{-- <p class="price">$750</p> --}}
        </div>
        <div class="right">
            <p class="intro">What you get:</p>

            <ul>
                <li>Youtube monetization</li>
                <li>Social media boost</li>
                <li>Free comic book</li>
                <li>T-shirt, Cap, Mug, Poster, Stickers</li>
                <li>A chance to get your own show here on Revival</li>
                <li>Affiliate link</li>
                <li>Exclusive early access to news, products, and announcements</li>
            </ul>
        </div>
    </div>

    <a href="javascript:void(0)" class="join--now--btn" id="openModal">Schedule Free Consultation</a>
</div>

<!-- Modal Structure -->
<div id="premiumModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Schedule Free Consultation</h2>
        <p>Please fill out the form to schedule your free consultation.</p>
        
        <!-- Date Picker -->
        <input type="date" id="meeting-date" required>
        
        <!-- Time Slots Container -->
        <div id="time-slots-container">
            <!-- Time slots will be dynamically updated here -->
        </div>
        
        <!-- Form for booking -->
        <form id="booking-form" action="{{ route('update-time-booking') }}" method="POST">
            @csrf
             <input name="name" type="text" placeholder="Full Name">
            <input name="email" type="email" placeholder="Email">
            <input name="phone" type="text" placeholder="Phone">
            <div id="time-slots-form-container">
                <!-- Hidden input for selected schedule ID will be added here dynamically -->
            </div>
            <input type="hidden" name="status" value="1">
             <input type="hidden" name="meeting_date" id="hidden-meeting-date">
            <button type="submit">Book Now</button>
        </form>
    </div>
</div>



                    <div class="pricing--card">
                        <div class="top--part">
                            <div class="left">
                                <div class="pricing--tag">FREE</div>
                                {{-- <p class="price">$00</p> --}}
                            </div>
                            <div class="right">
                                <p class="intro">What you get:</p>

                                <ul>
                                    <li>Affiliate link</li>
                                    <li>Free comic book</li>
                                    <li>The first to get the latest updates and offers</li>
                                </ul>
                            </div>
                        </div>


                        @php
                            $subscribed = false;
                            $verificationPending = false;
                        @endphp

                        @foreach ($userPackages as $package)
                            @if ($package->verification_status == 1)
                                @php $subscribed = true; @endphp
                            @elseif ($package->verification_status == 0)
                                @php $verificationPending = true; @endphp
                            @endif
                        @endforeach
                        <a href="javascript:void(0)" class="join--now--btn" onclick="openModal()"> Join Now </a>
                        <!-- @if ($subscribed)
                            <div class="pricing--card">
                                <div class="top--part">
                                    <div class="right">
                                        <p class="intro">You are already subscribed to this package.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif ($verificationPending)
                            <a href="javascript:void(0)" class="join--now--btn" onclick="openModal()"> Join Now </a>
                        @else
                            <a href="javascript:void(0)" class="join--now--btn" onclick="openModal()"> Join Now </a>
                        @endif -->

                    </div>

                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h3 class="affiliate--common-title">Select An Option</h3>
                            <!--<button onclick="location.href='claim-code'">Redeem Code</button>-->
                            <button onclick="location.href='affiliate-code'">Generate Code</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- pricing for you area ends --}}



        {{-- faq area starts --}}
        <section class="faq--area--wrapper section--gap">
            <div class="container">
                <div class="faq--area--content">
                    <h3 class="affiliate--common-title">FAQ</h3>

                    <div class="faq--list--wrapper">
                        <div class="accordion" id="accordionExample">
                            @foreach ($faqs as $index => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                                            aria-controls="collapse{{ $index }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- faq area ends --}}
        
        
        
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







        {{-- happy users area starts --}}
        <section class="happy--users--area--wrapper section--gap">
            <div class="container">
                <div class="happy--users--area--content">
                    <h3 class="affiliate--common-title">
                        Join with our many happy users
                    </h3>

                    <div class="happy--users--sliders--wrapper">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($happyusers as $happyuser)
                                    @if ($happyuser->type == 1)
                                        <div class="swiper-slide">
                                            <div class="single--slide">
                                                <div class="left">
                                                    <img src="{{ asset($happyuser->image ?? 'frontend/images/reviewer1.png') }}"
                                                        alt="{{ $happyuser->short_title }}" />
                                                </div>
                                                <div class="right">
                                                    <div class="star--wrapper">
                                                        @for ($i = 0; $i < $happyuser->rating; $i++)
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
                                                            {{ $happyuser->short_title ?? 'Smooth App and Customer Support' }}
                                                        </p>

                                                        <p class="main--subtitle">
                                                            {!! $happyuser->description ??
                                                                'Popupular works very smoothly. And it is very simple
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        and easy to use. I love it!Marco and the customer
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
        
        
        
        
        
        
        
        
 
        

        
    </main>
@endsection
