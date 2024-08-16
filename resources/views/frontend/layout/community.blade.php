@extends('frontend.app')

@section('title')
Community
@endsection

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">

<style>
    .single--post:nth-child(1) {
        display: none;
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

    button {
        margin: 10px;
        padding: 10px 20px;
        border: none;
        background-color: #fdfe0d;
        color: black;
        cursor: pointer;
        border-radius: 5px;
        border: 2px solid #fdfe0d;
        transition: 0.3s ease-in-out;
    }

    button:hover {
        background-color: #000000;
        color: #efefef;
    }
</style>
@endpush
@section('content')
<main>
    <!-- banner area starts -->
    <section class="shop--banner--area--wrapper community--banner">
        <div class="container">
            <div class="shop--banner--area--content">
                <h3 class="common--banner--title">Revival Community</h3>
            </div>
        </div>
    </section>
    <!-- banner area ends -->

    <!-- community total content area starts -->
    <section class="community--total--content--area--wrapper">
        <div class="container">
            <!-- search area -->
            <div class="community--search--area--wrapper" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <form action="#">
                    <!-- profile area -->
                    <div class="profile--wrapper">
                        <img src="{{ asset(Auth::user()->image ?? 'frontend/images/profile-avatar.png') }}" alt=""
                            style="border-radius: 50%;" />
                    </div>

                    <!-- input wrapper -->
                    <div class="input--wrapper">
                        <input type="text" placeholder="Let’s share what going on your mind..." readonly />
                    </div>
                </form>
            </div>


            {{-- Modal for Post --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background: var(--bg--deep); color: white;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Let’s share what going on your mind...
                            </h5>
                        </div>
                        <form action="{{ route('post.store') }}" method="POST" id="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                            <div class="modal-body">
                                <div class="mb-4">
                                    <label for="title" class="col-form-label">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
                                <div class="mb-4">
                                    <label for="tag" class="col-form-label">Meta Tags:</label>
                                    <div class="tags-input-wrapper">
                                        <input type="text" class="form-control" name='tag' value='' autofocus>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="message-text" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="message-text" name="message"
                                        style="height: 130px"></textarea>
                                </div>
                                <div class="mb-4">
                                    <input type="file" required
                                        class="dropify form-control form-control-md border-left-0 @error('image') is-invalid @enderror"
                                        name="image" id="image" value="{{ old('image', '') }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="upload--btn">
                                    <button type="button" class="btn--secondary"
                                        style="background: var(--bg--deep); border:none;" data-bs-dismiss="modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="140" height="48"
                                            viewBox="0 0 140 48" fill="none">
                                            <path
                                                d="M17.4295 0.5C5.95433 0.5 -2.01675 11.9233 1.943 22.6936L7.09013 36.6937C9.47696 43.1857 15.6597 47.5 22.5766 47.5H117.423C124.34 47.5 130.523 43.1857 132.91 36.6937L138.057 22.6937C142.017 11.9233 134.046 0.5 122.57 0.5H17.4295Z"
                                                fill="#050505" stroke="url(#paint0_linear_4513_2315)" />
                                            <defs>
                                                <linearGradient id="paint0_linear_4513_2315" x1="-61.7234" y1="87.25"
                                                    x2="184.297" y2="56.07" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#FDFE0D" />
                                                    <stop offset="1" stop-color="white" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <p>Close</p>
                                    </button>
                                </div>

                                <button type="submit" class="btn--primary"
                                    style="background: var(--bg--deep); border:none;" form="post">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="140" height="49" viewBox="0 0 140 49"
                                        fill="none">
                                        <path
                                            d="M17.4295 1C5.95433 1 -2.01675 12.4233 1.943 23.1936L7.09013 37.1937C9.47696 43.6857 15.6597 48 22.5766 48H117.423C124.34 48 130.523 43.6857 132.91 37.1937L138.057 23.1937C142.017 12.4233 134.046 1 122.57 1H17.4295Z"
                                            fill="#FDFE0D" stroke="url(#paint0_linear_4513_1248)"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_4513_1248" x1="-61.7234" y1="87.75"
                                                x2="184.297" y2="56.57" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FDFE0D"></stop>
                                                <stop offset="1" stop-color="white"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <p>Upload</p>
                                </button>
                            </div>
                            </from>
                    </div>
                </div>
            </div>
            {{-- Modal for Post end here --}}


            <h3 class="post--heading">My Latest Post</h3>

            <!-- main content -->
            <div class="community--main--content--wrapper">
                <div class="recent--post--area--wrapper">
                    <div class="recent--post--area--list">
                        @foreach ($posts as $post)
                        <div class="single--post">
                            <div class="single--post-flx">
                                <!-- img area -->
                                <a href="{{ route('post.singlepost', ['slug' => $post->slug]) }}">
                                    <div class="img--wrapper">
                                        <img src="{{ asset($post->image ?? 'frontend/images/post--image.png') }}"
                                            alt="Post Image" />
                                    </div>

                                    <!-- content area -->
                                    <div class="content--area">
                                        <div class="top--part">
                                            <p class="post--title">{{ $post->title ?? '' }}</p>
                                            <div class="tag--wrapper">
                                                @if (is_array($post->tag))
                                                @foreach ($post->tag as $tag)
                                                <p class="tags">#{{ $tag ?? '' }}</p>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                </a>

                                <div class="bottom--part">
                                    <div class="author--profile">
                                        <div class="author--img">
                                            <img src="{{ asset(Auth::user()->image ?? 'frontend/images/profile-avatar.png') }}"
                                                alt="Author Image" style="border-radius: 50%;" />
                                        </div>
                                        <div class="author--info">
                                            <h4>{{ $post->user->name ?? '' }}</h4>
                                            <p>{{ $post->created_at->diffForHumans() ?? '' }}</p>
                                        </div>
                                    </div>
                                    <ul>

                                        <li>
                                            <form id="like-form-{{ $post->id }}" action="{{ route('post.like') }}" method="POST" style="display: inline;">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="hidden" name="like_post" value="1">
    <button type="submit" style="">
        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
    </button>
    <span class="like-count">{{ $post->like_post }}</span>
</form>

<form id="dislike-form-{{ $post->id }}" action="{{ route('post.dislike') }}" method="POST" style="display: inline;">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="hidden" name="dislike" value="1">
    <button type="submit" style="">
        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
    </button>
    <span class="dislike-count">{{ $post->dislike }}</span>
</form>

                                        </li>
                                         <li><a href="javascript:void(0)" onclick="openModal('{{ route('post.singlepost', ['slug' => $post->slug]) }}')"><i class="fa fa-share-alt" aria-hidden="true"></i></a></li>
                                        <li><a href="javascript:void(0)" class="open-box"><i
                                                    class="fa fa-commenting" aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        
                        


                       <div class="coment-box">
                           
                           <!-- Add Comment Form -->
    <div class="msg-form">
    <h3>Add Comment</h3>
    <form action="{{ route('add-comment') }}" method="post">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="text" name="name" placeholder="Name">
        <textarea placeholder="Comment" name="comment"></textarea>
        <button type="submit">Post</button>
    </form>
    </div>
    
    <div class="main-cmnt">
        <!--<span><img src="{{ asset(Auth::user()->image ?? 'frontend/images/profile-avatar.png') }}" alt="Author Image" /></span>-->
        <div class="main-cmnt-box">
            @foreach ($post->comments as $comment)
                <div class="comment">
                    <h5>{{ $comment->name }}</h5>
                    <p>{{ $comment->comment }}</p>
                    <a href="javascript:void(0)" onclick="openReplyForm('{{ $comment->id }}', '{{ $comment->name }}')">
                        <i class="fa fa-reply-all" aria-hidden="true"></i>Reply
                    </a>

                    <!-- Display replies for the current comment -->
                    @if($comment->replies->count() > 0)
                        <div class="rply-cmnt">
                            @foreach($comment->replies as $reply)
                                <div class="reply">
                                    <h5>{{ $reply->name }}</h5>
                                    <p>{{ $reply->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Reply form for the current comment -->
                    <div id="reply-form-{{ $comment->id }}" class="reply-form" style="display: none;">
                        <h3>Reply to {{ $comment->name }}</h3>
                        <form action="{{ route('add-reply') }}" method="post">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <input type="text" name="name" placeholder="Your name" required>
                            <textarea name="comment" placeholder="Your reply" required></textarea>
                            <button type="submit">Reply</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    
</div>





                    </div>
                    @endforeach

                </div>



                <!-- pagination area -->
                <div class="pagination--wrapper">
                    {{ $posts->links() ?? '' }}
                </div>
            </div>

            <div class="popular--tags--wrapper">
                <h3 class="heading">Recent Tags</h3>
                <ul class="tags--list">
                    @foreach ($recentTags as $tag)
                    <li>
                        <p class="tag">#{{ $tag ?? '' }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        </div>
    </section>
    <!-- community total content area ends -->

                       <div id="myModal" class="modal add-cmnt">
       <div class="modal-content">
           <span class="close" onclick="closeModal()">&times;</span>
           <h3>share</h3>
            <ul>
            <li><a href="#" id="shareWhatsApp">Share to WhatsApp</a></li>
            <li><a href="#" id="shareFacebook">Share to Facebook</a></li>
            <li><a href="#" id="shareTelegram">Share to Telegram</a></li>
            <li><a href="#" id="copyLink">Copy Link</a></li>
        </ul>
       </div>
    </div>


</main>
@endsection


@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Use the post URL instead of the current page URL
            const pageUrl = postUrl;

            // Handle the copy link button
            document.getElementById('copyLink').addEventListener('click', function(event) {
                event.preventDefault();
                navigator.clipboard.writeText(pageUrl).then(function() {
                    toastr.success('Link copied to clipboard!');
                }, function(err) {
                    console.error('Could not copy link: ', err);
                });
            });

            // Handle the share to WhatsApp button
            document.getElementById('shareWhatsApp').addEventListener('click', function(event) {
                event.preventDefault();
                const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(pageUrl)}`;
                window.open(whatsappUrl, '_blank');
            });

            // Handle the share to Telegram button
            document.getElementById('shareTelegram').addEventListener('click', function(event) {
                event.preventDefault();
                const telegramUrl = `https://t.me/share/url?url=${encodeURIComponent(pageUrl)}`;
                window.open(telegramUrl, '_blank');
            });

            // Handle the share to Facebook button
            document.getElementById('shareFacebook').addEventListener('click', function(event) {
                event.preventDefault();
                const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`;
                window.open(facebookUrl, '_blank');
            });
        });
    </script>


</script>
<script>
function openReplyForm(commentId, commenterName) {
    // Hide any previously opened reply forms
    document.querySelectorAll('.reply-form').forEach(form => form.style.display = 'none');
    
    // Show the current reply form
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    if (replyForm) {
        replyForm.style.display = 'block';

        // Pre-fill the textarea with `@(name)`
        const commentField = replyForm.querySelector('textarea[name="comment"]');
        if (commentField) {
            commentField.value = `@${commenterName} `;
        }
    }
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('myModal');
        let currentUrl = '';

        // Function to open the modal and set the URL
        window.openModal = function(url) {
            currentUrl = url;
            modal.style.display = 'block';
        };

        document.querySelector('.close').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        document.getElementById('copyLink').addEventListener('click', function(event) {
            event.preventDefault();
            navigator.clipboard.writeText(currentUrl).then(function() {
                toastr.success('Link copied to clipboard!');
            }, function(err) {
                console.error('Could not copy link: ', err);
            });
        });

        document.getElementById('shareWhatsApp').addEventListener('click', function(event) {
            event.preventDefault();
            const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(currentUrl)}`;
            window.open(whatsappUrl, '_blank');
        });

        document.getElementById('shareTelegram').addEventListener('click', function(event) {
            event.preventDefault();
            const telegramUrl = `https://t.me/share/url?url=${encodeURIComponent(currentUrl)}`;
            window.open(telegramUrl, '_blank');
        });

        document.getElementById('shareFacebook').addEventListener('click', function(event) {
            event.preventDefault();
            const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
            window.open(facebookUrl, '_blank');
        });

        // Function to close the modal
        window.closeModal = function() {
            modal.style.display = 'none';
        };
    });
</script>



<script>
$(document).ready(function(){
    $('.open-box').click(function(){
        $(this).parent().parent().parent().parent().parent().next().toggleClass('coment-boxs')
    })
})
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[id^="like-form-"], form[id^="dislike-form-"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const postId = form.querySelector('input[name="post_id"]').value;
            const isLikeForm = form.id === `like-form-${postId}`;
            const otherFormId = isLikeForm ? `dislike-form-${postId}` : `like-form-${postId}`;
            const otherForm = document.getElementById(otherFormId);
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    toastr.success(data.message);
                }
                // Update like/dislike counts
                if (data.like_post !== undefined) {
                    document.querySelector(`#like-form-${postId} .like-count`).textContent = data.like_post;
                }
                if (data.dislike !== undefined) {
                    document.querySelector(`#dislike-form-${postId} .dislike-count`).textContent = data.dislike;
                }
                // Enable or disable buttons based on the reaction
                form.querySelector('button').disabled = false;
                otherForm.querySelector('button').disabled = false;
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
    </script>

<script type="text/javascript" src="{{ asset('frontend/js/dropify.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.dropify').dropify();
    });
</script>
@endpush