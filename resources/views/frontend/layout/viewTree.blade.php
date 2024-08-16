@extends('frontend.app')

@section('title')
Dashboard
@endsection

@push('style')
<style>
    .extended--footer .extra--wrapper {
        display: none;
    }

    .btn-primary {
        background: #0f0f00 !important;
        border: 1px solid !important;
        color: white !important;
        border-color: yellow !important;
    }

    .btn-primary:hover {
        background: rgb(253 254 13) !important;
        border: 1px solid !important;
        color: black !important;
    }
</style>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .form-control {
        color: black !important;
    }
</style>
@endpush

@push('script')
<script>
    function copyToClipboard() {
        var copyText = document.querySelector('input[name="affiliate_link"]');
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
    }
</script>
<script>
    function openClaimModal() {
        document.getElementById('claimModal').style.display = "block";
    }

    function closeClaimModal() {
        document.getElementById('claimModal').style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById('claimModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">

<style>
    .auth--form--wrapper .input--wrapper input {
        padding: 16px 32px;
        background-color: transparent;
        border-radius: 12px;
        border: 1px solid #0F0F00;
        color: #000;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 26.24px;
    }


    .form-control {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--bs-body-color);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        color: white;
        background-color: transparent;
        background-clip: padding-box;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: 8px;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .form-control:focus {
        color: white;
        background-color: transparent;
        border-color: rgb(102, 102, 102);
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(79, 79, 79, 0.25);
    }

    .btn-primary {
        background: transparent;
        border: 1px solid;
    }

    .btn-primary:hover {
        background: rgb(102, 102, 102);
        border: 1px solid;
    }

    .modal-title {
        color: #fff;
        font-family: var(--font-oswald);
        font-size: 26px;
        font-weight: 700;
        text-align: center;
    }

    .active>.page-link,
    .page-link.active {
        z-index: 3;
        color: black;
        background-color: #FDFE0D;
        border-color: #FDFE0D;
    }

    .dropify-wrapper {
        background-color: #0F0F00 !important;
        color: #fff !important;
        border-color: #DEE2E6;
    }

    .dropify-wrapper .dropify-message p {
        font-size: initial;
    }
    ul {
        padding: revert-layer;
    }
    ul, #myUL {
        list-style-type: none;
    }

    #myUL {
        margin: 0;
        padding: 0;
    }

    .caret {
        cursor: pointer;
        -webkit-user-select: none;
        /* Safari 3.1+ */
        -moz-user-select: none;
        /* Firefox 2+ */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
    }

    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .caret-down::before {
        -ms-transform: rotate(90deg); /* IE 9 */
        -webkit-transform: rotate(90deg); /* Safari */
        transform: rotate(90deg);  
    }

    .treenested {
        display: none;
    }

    .treeactive {
        display: block;
    }
</style>
@endpush

@section('content')
<main>
    <section class="product--categories--area--wrappper section--gap">
        <div class="container">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4" style="border-radius: 20px;">
                            <div class="card-body text-center">
                                <div>
                                    <img src="{{ asset(Auth::user()->image ?? 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                </div>
                                <h5 class="my-3">{{ Auth::user()->name }}</h5>
                                <div class="d-flex justify-content-center mb-2" style="cursor: pointer;">
                                    <a class="btn--secondary" href="{{route('userprofile')}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="140" height="48" viewBox="0 0 140 48" fill="none">
                                            <path d="M17.4295 0.5C5.95433 0.5 -2.01675 11.9233 1.943 22.6936L7.09013 36.6937C9.47696 43.1857 15.6597 47.5 22.5766 47.5H117.423C124.34 47.5 130.523 43.1857 132.91 36.6937L138.057 22.6937C142.017 11.9233 134.046 0.5 122.57 0.5H17.4295Z" fill="#050505" stroke="url(#paint0_linear_4513_2315)" />
                                            <defs>
                                                <linearGradient id="paint0_linear_4513_2315" x1="-61.7234" y1="87.25" x2="184.297" y2="56.07" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#FDFE0D" />
                                                    <stop offset="1" stop-color="white" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <p>Edit Profile</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4 mb-md-20" style="border-radius: 20px;">
                                    <div class="card-body">
                                        <p class="mb-4" style="font-size: 18px;">Affiliation Tree <strong class="text-info">{{$affiliateLink->user_code}}</strong></p>
                                        @if(count($user->children)>0)
                                        <ul id="myUL">
                                            @include('frontend.layout.extends.treerow', [
                                                'user' => $user
                                            ])
                                        </ul>
                                        @else
                                        <h4 class="text-danger">No Users Registered Yet!!</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('script')
<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".treenested").classList.toggle("treeactive");
    this.classList.toggle("caret-down");
  });
}
</script>
@endpush