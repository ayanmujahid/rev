

function mainStreamSlider() { }
const mainstreamSwiper = new Swiper(".mainstream--slider--wrapper .swiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "2",
    autoplay: true,
    loop: true,
    coverflowEffect: {
        rotate: 15,
        stretch: 40,
        depth: 200,
        modifier: 3,
        slideShadows: false,
    },
    
    breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: false,
            },
            576: {
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: false,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
        }
    
});


mainStreamSlider();

function discoverSlider() {
    const discoverSwiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: ".discover--more--slider--wrapper .next--slide--btn",
            prevEl: ".discover--more--slider--wrapper .previous--slide--btn",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: false,
            },
            576: {
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: false,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 20,
            }
        }
    });
}

discoverSlider();



function mycovers() {
    const discoverSwiper = new Swiper(".mycover", {
        slidesPerView: 1,
        autoplay: true,
        spaceBetween: 0,
        loop: true,
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            576: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            1024: {
                slidesPerView: 1,
                spaceBetween: 0,
            }
        }
    });
}

mycovers();

function cartWrapper() {
    let wrapper = document.querySelector(".cart--area--wrapper");
    let openBtn = document.querySelector(".cart--icon");
    let closeBtn = document.querySelector(".close--cart--btn");
    let cartContent = document.querySelector(".cart--area--content");

    let amountWrappers = document.querySelectorAll(".item--amount");

    if (wrapper) {
        // opening wrapper
        openBtn.addEventListener("click", (event) => {
            event.preventDefault();
            wrapper.classList.add("active--wrapper");
        });

        // closing wrapper
        closeBtn.addEventListener("click", (event) => {
            event.preventDefault();
            wrapper.classList.remove("active--wrapper");
        });

        //  closing the wrapper on outside click
        // document.addEventListener("click", (event) => {
        //     if (
        //         !cartContent.contains(event.target) &&
        //         !openBtn.contains(event.target)
        //     ) {
        //         wrapper.classList.remove("active--wrapper");
        //     }
        // });
    }

    if (amountWrappers) {
        amountWrappers.forEach((amountWrapper) => {
            let plusBtn = amountWrapper.querySelector(".plus");
            let minusBtn = amountWrapper.querySelector(".minus");
            let amount = amountWrapper.querySelector(".amount");

            let amountNumber = parseInt(amount.value);

            plusBtn.addEventListener("click", () => {
                amountNumber++;
                amount.value = amountNumber;
            });
            minusBtn.addEventListener("click", () => {
                if (amountNumber >= 1) {
                    amountNumber--;
                    amount.value = amountNumber;
                }
            });
        });
    }
}

cartWrapper();

// copy marquee node
function marqueeSlider() {
    let slider = document.querySelector(
        ".upcoming--project--slider--wrapper .slider"
    );
    let wrapper = document.querySelector(".upcoming--project--slider--wrapper ");

    if (slider) {
        var copy = slider.cloneNode(true);
        wrapper.appendChild(copy);
    }
}
marqueeSlider();

function donationProgress() {
    let wrapper = document.querySelector(".campaign--progress--wrapper ");

    let bar = document.querySelector(
        ".campaign--progress--wrapper .progress--bar"
    );

    if (wrapper) {
        document.addEventListener("DOMContentLoaded", () => {
            bar.classList.add("grow");
        });
    }
}

donationProgress();

function happyUsersSlider() {
    let wrapper = document.querySelector(".happy--users--sliders--wrapper");

    if (wrapper) {
        var swiper = new Swiper(wrapper.querySelector(".swiper"), {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {

            }
        });
    }
}

happyUsersSlider();

function stepsIndicator() {
    let wrapper = document.querySelector(
        ".how--is--this--possible--area--content .steps--list--wrapper"
    );

    if (wrapper) {
        let section = document.querySelector(
            ".how--is--this--possible--area--wrapper"
        );

        let listIndex = 1;

        let lists = Array.from(wrapper.querySelectorAll("li"));

        function activeList() {
            lists.slice(0, listIndex).forEach((item) => {
                item.classList.add("active");
            });
        }

        // activeList();

        let wrapperPosition = wrapper.getBoundingClientRect().top;
        let incrasedBy = 200;
        let sectionTop = section.getBoundingClientRect().top - incrasedBy;
        let sectionHeight = section.clientHeight;

        let postionBottom = sectionTop + sectionHeight - incrasedBy;

        let positionMiddle = sectionTop + sectionHeight / 2 - incrasedBy;

        // console.log(wrapperPosition, "top");

        // console.log(positionMiddle, "middle");
        // console.log(postionBottom, "end");

        // indicator
        let indicatorTrack = document.querySelector(
            ".how--is--this--possible--area--content .steps--list--wrapper ul"
        );

        window.addEventListener("scroll", () => {
            let scrollPosition = window.scrollY;

            if (scrollPosition > sectionTop) {
                indicatorTrack.classList.add("start");
            } else {
                indicatorTrack.classList.remove("start");
            }
            if (scrollPosition > sectionTop && scrollPosition < positionMiddle) {
                indicatorTrack.classList.remove("start");
                indicatorTrack.classList.add("middle");
            } else {
                indicatorTrack.classList.remove("middle");
            }
            if (scrollPosition > positionMiddle) {
                indicatorTrack.classList.remove("middle");
                indicatorTrack.classList.add("end");
            } else {
                indicatorTrack.classList.remove("end");
            }
        });
    }
}

stepsIndicator();

function productCategorySlider() {
    let wrapper = document.querySelector(".product--categories--area--content");

    if (wrapper) {
        var swiper = new Swiper(".product--categories--area--content .swiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".product--categories--area--content .button-next",
                prevEl: ".product--categories--area--content .button-prev",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                }
            }
        });
    }
}

productCategorySlider();

// initializing select for whole website

$("select").niceSelect();

function hamburgerIcon() {
    let icon = document.querySelector(
        ".header--content--area--wrapper .hamburger--icon"
    );

    let wrapper = document.querySelector(
        ".header--content--area--wrapper .menu--links--wrapper"
    );

    if (icon) {
        icon.addEventListener("click", () => {
            icon.classList.toggle("active");
            wrapper.classList.toggle("active");

            // closing on outside click of document
            document.addEventListener("click", (event) => {
                if (!icon.contains(event.target) && !wrapper.contains(event.target)) {
                    icon.classList.remove("active");
                    wrapper.classList.remove("active");
                }
            });
        });
    }
}

hamburgerIcon();

// video player

function latestVideoPlayer() {
    let wrapper = document.querySelector(".latest--video--area--wrapper");

    if (wrapper) {
        let videos = wrapper.querySelectorAll(".single--video--wrapper");

        videos.forEach((item) => {
            let playBtn = item.querySelector(".play--btn");
            let imgSrc = playBtn.querySelector("img");
            let isPlaying = false;
            let playBtnSrc = "./assets/images/play-btn.png";
            let pauseBtnSrc = "./assets/images/pause-btn.png";

            let video = item.querySelector("video");

            playBtn.addEventListener("click", () => {
                if (!isPlaying) {
                    video.play();
                    playBtn.classList.add("hide");
                    imgSrc.setAttribute("src", pauseBtnSrc);
                } else {
                    video.pause();
                    imgSrc.setAttribute("src", playBtnSrc);
                }

                // changing the state
                isPlaying = !isPlaying;
            });
        });

        // video slider
        var swiper = new Swiper(wrapper.querySelector(".mySwiper"), {
            navigation: {
                nextEl: wrapper.querySelector(".button-next"),
                prevEl: wrapper.querySelector(".button-prev"),
            },

            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                576: {
                    slidesPerView: 1
                },
                1200: {
                    slidesPerView: 2
                }
            },

            spaceBetween: 20,
            loop: true,
        });
    }
}

latestVideoPlayer();

function merchandaiseSlider() {
    let wrapper = document.querySelector(".recommneded--merchandaise--wrapper");

    if (wrapper) {
        // video slider
        var swiper = new Swiper(wrapper.querySelector(".mySwiper"), {
            navigation: {
                nextEl: wrapper.querySelector(".button-next"),
                prevEl: wrapper.querySelector(".button-prev"),
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                }
            },

            slidesPerView: 4,
            spaceBetween: 20,
            loop: true,
        });
    }
}
merchandaiseSlider();

// function salesGoalProgressBar() {
//     let wrapper = document.querySelector(".sales--goal--progressbar--wrapper");

//     if (wrapper) {
//         let progressValue = document.querySelector(
//             ".sales--goal--area--content .top--part .value"
//         );

//         // calculating the widht percentage based on the goal
//         let progressValueNum = parseInt(progressValue.innerText);
//         let totalGoal = 200000;
//         let barWidth = (progressValueNum / totalGoal) * 100;

//         // progress bar
//         let progressBar = wrapper.querySelector(".progress--bar");

//         // setting the width based on the value percent
//         progressBar.style.width = `${barWidth}%`;

//         // crossing the star mark
//         let barPostion = progressBar.getBoundingClientRect().right;

//         let starWrappers = wrapper.querySelectorAll(".star--wrapper svg");

//         // for counting purpose
//         let starsLeft = 0;
//         let totalStars = 9;

//         console.log(barPostion);
//         starWrappers.forEach((item) => {
//             let starPosition = item.getBoundingClientRect().right;

//             // finding out how many stars are left
//             if (starPosition > barPostion) {
//                 starsLeft++;
//             }
//         });

//         let starsArray = Array.from(starWrappers);

//         let starsCrossed = totalStars - starsLeft;

//         //  making the stars active
//         starsArray.slice(0, starsCrossed).forEach((item) => {
//             let svgPath = item.querySelector("path");

//             svgPath.style.fill = "#fdfe0d";
//         });
//     }
// }

// salesGoalProgressBar();

// function homepageDelayPopUp() {
//     let wrapper = document.querySelector(".delay--popup--wrapper");
//     if (wrapper) {
//         let closeButton = wrapper.querySelector(".close");
//         document.addEventListener("DOMContentLoaded", () => {
//             setTimeout(() => {
//                 wrapper.classList.add("active");
//             }, 2000);
//         });
//         // close the pop up when clicking on it
//         closeButton.addEventListener("click", () => {
//             wrapper.classList.remove("active");
//         });
//     }
// }
// homepageDelayPopUp();
// pop up
// function homepageDelayPopUp() {
//     let wrapper = document.querySelector(".delay--popup--wrapper");

//     if (wrapper) {
//         let closeButton = wrapper.querySelector(".submit--btn");

//         document.addEventListener("DOMContentLoaded", () => {
//             if(!localStorage.getItem('homepopup')){
//                 setTimeout(() => {
//                     wrapper.classList.add("active");
//                 }, 2000);
//             }
//         });

//         // close the pop up when clicking on it
//         closeButton.addEventListener("click", () => {
//             localStorage.setItem('homepopup','closed')
//             wrapper.classList.remove("active");
//         });
//     }
// } 

// homepageDelayPopUp();



function upComingSlider() {
    let wrapper = document.querySelector(".upcoming--project--slider--wrapper");

    if (wrapper) {
        var swiper = new Swiper(wrapper.querySelector('.mySwiper'), {
            slidesPerView: 4,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            speed: 1000,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 0,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                }
            }
        });
    }
}

upComingSlider();









// $(document).ready(function() {
//   $('.action--btn').click(function() {
//     var action = $(this).data('action');
//     var input = $(this).siblings('.amount');
//     var currentValue = parseInt(input.val());

//     if (action === 'plus') {
//       input.val(currentValue + 1);
//     } else if (action === 'minus' && currentValue > 1) {
//       input.val(currentValue - 1);
//     }
//   });
// });
// // Assuming you have jQuery included
// function updateQuantity(productId, action, event) {
//   // Find the corresponding amount input
//   var input = $(event.target).closest('.item--amount').find('.amount');
//   var currentValue = parseInt(input.val());

//   // Update the value based on the action
//   if (action === 'plus') {
//     input.val(currentValue + 1);
//   } else if (action === 'minus' && currentValue > 1) {
//     input.val(currentValue - 1);
//   }
// }





document.addEventListener('DOMContentLoaded', () => {
    // Function to add the .gift class to .cart--items--list--wrapper
    function addGiftClassIfNeeded() {
        const container = document.getElementById('cart-items-container');
        if (container) {
            // Example condition: check if gift-section is present
            const giftSection = container.querySelector('.gift-section');
            if (giftSection) {
                container.classList.add('gift');
            }
        }
    }

    addGiftClassIfNeeded();
});

