<script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>

<script src="{{ asset('frontend/js/plugins.js') }}"></script>

<script src="{{ asset('frontend/js/main.js') }}"></script>

<script src="{{ asset('frontend/js/tagify.js') }}"></script>

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>
    var input = document.querySelector('input[name=tag]');

    new Tagify(input)
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('frontend/js/jquery.toast.js') }}"></script>


<script>
    
</script>

<script type="text/javascript">

    $(document).on("click" , ".close-modal", function(){
        $(".printfy-modal").modal("hide")
        $(".printfy-modal").css("display" , "none")
    })

    $(document).ready(function() {

        if($(".checkout--main--area--wrapper").length > 0){
            var styles = {
                'pointer-events': 'none',
                'cursor': 'default'
            };
            $( ".cart--icon" ).css( styles );
        }

        

        $(".product-preview").click(function(){

            let id = $(this).attr("data-id");
            let type = $(this).attr("data-type");
            
            if(type == "Printify"){
                quantity = $(this).attr("data-quantity_limit");
                price = $(this).attr("data-price");
                image = $(this).attr("data-image");
                title = $(this).attr("data-title");
                desc = $(this).attr("data-desc");
            }else{
                var quantity = $('#quantity').val();
                price = $(this).attr("data-price");
                image = $(this).attr("data-image");
                title = $(this).attr("data-title");
                desc = $(this).attr("data-desc");
            }
            
            
            if ((quantity === undefined) || (quantity === null)) {
                quantity = 1;
            }

            console.log(type)
            $(".modal-title").text(type)
            $(".modal-body .other-images h3").text(title)
            $(".modal-body .other-images p").html(desc)
            $(".modal-body .modal-image img").prop('src' , image)

            $(".modal_cart").attr("data-quantity_limit" , quantity)
            $(".modal_cart").attr("data-price" , price)
            $(".modal_cart").attr("data-image" , image)
            $(".modal_cart").attr("data-desc" , desc)
            $(".modal_cart").attr("data-title" , title)
            $(".modal_cart").attr("data-type" , type)
            $(".modal_cart").attr("data-id" , id)


            $(".printfy-modal").modal("show")
        })
        
        
        $(document).ready(function() {
        function fetchGifts() {
            $.ajax({
                url: '{{ route('get-gifts') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Response:', response);
                    if (response.gifts.length > 0) {
                        let giftList = '';
                        $.each(response.gifts, function(index, gift) {
                            giftList += `
                                <div class="single--cart--item">
                                    <div class="cart--item--img">
                                       <img src="${gift.img_path}" alt="${gift.title}">
                                    </div>
                                    <div class="cart--item--details">
                                        <p class="item--title">${gift.title}</p>
                                    </div>
                                </div>`;
                        });

                        $('.gift-list').html(giftList);
                        $('.gift-section').show(); // Show the section if gifts are available
                    } else {
                        $('.gift-section').hide(); // Hide the section if no gifts
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText); // Log any errors
                }
            });
        }

        // Existing add to cart function
        $('.add_cart').on('click', function() {
            let id = $(this).attr("data-id");
            let type = $(this).attr("data-type");
            let quantity, price, image, title, print_provider_id, blueprint_id;

            if(type == "Printify"){
                quantity = $(this).attr("data-quantity_limit");
                price = $(this).attr("data-price");
                image = $(this).attr("data-image");
                title = $(this).attr("data-title");
                print_provider_id = $(this).attr("data-print_provider_id");
                blueprint_id = $(this).attr("data-blueprint_id");
            } else {
                quantity = $('#quantity').val();
                price = '';
                image = '';
                title = '';
                print_provider_id = '';
                blueprint_id = '';
            }

            if ((quantity === undefined) || (quantity === null)) {
                quantity = 1;
            }

            $.ajax({
                url: "{{ route('save_cart') }}",
                method: "GET",
                dataType: "JSON",
                data: {
                    product_id: id,
                    quantity: quantity,
                    type: type,
                    price: price,
                    image: image,
                    title: title,
                    print_provider_id: print_provider_id,
                    blueprint_id: blueprint_id
                },
                success: function(data) {
                    if (data.status == 1) {
                        toastr.success(data.message);
                        $('.cart_items_number').html(data.cart_items_count);
                        // Trigger fetchGifts after successfully adding product to cart
                        fetchGifts();
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Existing remove from cart function
        $(document).on('click', ".remove_cart", function() {
            let id = $(this).attr("data-id");
            let like = $(this);
            $.ajax({
                url: "{{ route('remove_cart') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 1) {
                        toastr.success(data.message);
                        var grand_total = data.cart_total_amount;
                        $('.cart_items_number').html(data.cart_items_count);
                        $("#subtotal-amount").text(grand_total.toFixed(2))

                        var  express = +grand_total  + +"{{ Helper::getSetting()->express_delivery }}"
                        var  standard = +grand_total  + +"{{ Helper::getSetting()->standard_delivery }}"
                
                        $(".single--service[data-type='Express']").attr("data-amount", express.toFixed(2)).data("amount", express);
                        $(".single--service[data-type='Standard']").attr("data-amount", standard.toFixed(2)).data("amount", standard);

                        if($("#shipping-amount").text() != "" && $("#shipping-amount").text() != 0){
                            
                            var amount = $(".single--service.active").data("amount");
                            $("#checkout-amount").text(amount.toFixed(2))
                            
                        }else{
                            console.log("no val")
                            $("#checkout-amount").html(grand_total.toFixed(2))
                        }
                        
                        $(like).closest(".single--cart--item").remove()
                        // Trigger fetchGifts after successfully removing product from cart
                        fetchGifts();
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Initial call to check the cart on page load
        fetchGifts();
    });


        $(".single--service").click(function(){
            $(".single--service").removeClass("active")
            $(this).addClass("active")
            $("#selected-shipping-service").val($(this).find("input").val())
            var shipping_rate = $(this).find(".delivery").text()
            $("#shipping-amount").text(shipping_rate)
            $("#checkout-amount").text($(this).data("amount"))
        })

    });
</script>

<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        toastr.options.positionClass = 'toast-top-right';

        @if (Session::has('t-success'))
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': true,
                'progressBar': true,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            };
            toastr.success("{{ session('t-success') }}");
        @endif

        @if (Session::has('t-error'))
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': true,
                'progressBar': true,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            };
            toastr.error("{{ session('t-error') }}");
        @endif

        @if (Session::has('t-info'))
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': true,
                'progressBar': true,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            };
            toastr.info("{{ session('t-info') }}");
        @endif

        @if (Session::has('t-warning'))
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': true,
                'progressBar': true,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            };
            toastr.warning("{{ session('t-warning') }}");
        @endif
    });
</script>

<script>
    function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let totalItems = 0;

    if (cart) {
        Object.keys(cart).forEach(key => {
            totalItems += cart[key].quantity;
        });
  
    }

    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}
</script>

<script>
    function addToCart(productId, productTitle, productPrice, productImage) {
        let cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {};
        toastr.success("Product added to cart successfully");
        if (cart[productId]) {
            cart[productId].quantity += 1;
        } else {
            cart[productId] = {
                id: productId,
                title: productTitle,
                price: parseFloat(productPrice),
                quantity: 1,
                image: productImage
            };
        }
        cart[productId].totalPrice = cart[productId].quantity * cart[productId].price;
        localStorage.setItem('cart', JSON.stringify(cart));
        //updateCartUI();
        updateCartCount();
    }
</script>

<script>
    $(document).ready(function() {
        $(document).on("click",".cart--icon",function() {
            console.clear()
            updateCartUI()
        })  
    })
        
    function testAjax(handleData) {  
        $.ajax({
            url: "{{ route('get_cart') }}",
            method: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.status == 1) {
                    handleData(data.body);
                } else {
                    toastr.error(data.message); // Show toastr error if status is not 1
                    handleData(data.body);
                }
            }
        });
    }
    
    async function updateQuantity(product_id, type, event, obj){
        if(type=='minus'){
            obj = $(obj).next();
        }else{
            obj = $(obj).prev();
        }
        var qty = parseInt(obj.val())
        console.log(qty)
        if(type=='minus'){
            qty = (qty>1?(qty-1):1);
        }else{
            qty++
        }
        await fetch('/update-cart?product_id='+product_id+'&quantity='+qty)
        updateCartUI()
        // obj.val(qty)
    }

    function updateCartUI() {
        const cartItemsContainer = document.getElementById('cart-items-container');
        if($("#checkout-form").length > 0){
            var trig = $(".single--service")[0];
            $("#selected-shipping-service").val('express_delivery')
            $(trig).trigger("click")
        }

        testAjax(function( cart ){

             //let cart = JSON.parse(localStorage.getItem('cart'));
            let html = '';
            let totalItems = 0;
            let subtotal = 0;
            
            if (cart && cart != "") {
                Object.keys(cart).forEach(key => {
                    let item = cart[key];

                    totalItems += item.quantity;
                    let totalPrice = item.quantity * item.price;
                    subtotal += totalPrice;
                    html += `
                    <div class="single--cart--item">
                        <div class="cart--item--img">
                            <img src="${item.image}" alt="${item.name}"/>
                        </div>
                        <div class="cart--item--details">
                            <p class="item--title">${item.name}</p>
                        </div>
                        <div class="item--amount">
                            <div class="minus action--btn" onclick="updateQuantity('${item.product_id}', 'minus', event, this)">
                                <!-- Minus SVG here -->
                                <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="4"
                            viewBox="0 0 24 4"
                            fill="none"
                            >
                            <path
                                d="M1.41958 3.43907H22.5395C22.7286 3.43907 22.9159 3.40181 23.0907 3.32942C23.2654 3.25704 23.4242 3.15094 23.5579 3.01719C23.6916 2.88344 23.7977 2.72466 23.8701 2.54991C23.9424 2.37516 23.9797 2.18787 23.9796 1.99873C23.9797 1.8096 23.9424 1.62232 23.8701 1.44758C23.7977 1.27285 23.6916 1.11408 23.5579 0.980343C23.4242 0.846609 23.2654 0.74053 23.0907 0.668165C22.9159 0.595801 22.7286 0.558568 22.5395 0.558594H1.41958C1.04053 0.563027 0.678499 0.716719 0.412019 0.986333C0.14554 1.25595 -0.00390625 1.61975 -0.00390625 1.99883C-0.00390625 2.37791 0.14554 2.74171 0.412019 3.01133C0.678499 3.28094 1.04053 3.43463 1.41958 3.43907Z"
                                fill="black"
                            />
                            </svg>
                            </div>
                            <input type="text" class="amount" value="${item.quantity}" readonly />
                            <div class="plus action--btn" onclick="updateQuantity('${item.product_id}', 'plus', event, this)">
                                <!-- Plus SVG here -->
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 18 18"
                            fill="none"
                            >
                            <path
                                d="M8.98828 17.6231C8.34094 17.6231 7.81641 17.0986 7.81641 16.4513V1.54688C7.81641 0.899531 8.34094 0.375 8.98828 0.375C9.63563 0.375 10.1602 0.899531 10.1602 1.54688V16.4513C10.1602 17.0986 9.63563 17.6231 8.98828 17.6231Z"
                                fill="black"
                            />
                            <path
                                d="M16.4395 10.1719H1.53516C0.887812 10.1719 0.363281 9.64734 0.363281 9C0.363281 8.35266 0.887812 7.82812 1.53516 7.82812H16.4395C17.0869 7.82812 17.6114 8.35266 17.6114 9C17.6114 9.64734 17.0869 10.1719 16.4395 10.1719Z"
                                fill="black"
                            />
                            </svg>
                            </div>
                        </div>
                        <div class="cart--item--price">
                            <p class="item--price">$${totalPrice.toFixed(2)}</p>
                            <div class="item--close--btn remove_cart" data-id='${item.product_id}'">
                                <!-- Close SVG here -->

                                <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="15"
                            height="14"
                            viewBox="0 0 15 14"
                            fill="none"
                            >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M1.28107 0.305288C1.4686 0.117817 1.7229 0.0125018 1.98807 0.0125018C2.25323 0.0125018 2.50754 0.117817 2.69507 0.305288L7.98807 5.59829L13.2811 0.305288C13.3733 0.209778 13.4837 0.133596 13.6057 0.0811869C13.7277 0.0287779 13.8589 0.00119157 13.9917 3.77571e-05C14.1244 -0.00111606 14.2561 0.0241854 14.379 0.0744663C14.5019 0.124747 14.6136 0.199 14.7075 0.292893C14.8014 0.386786 14.8756 0.498438 14.9259 0.621334C14.9762 0.744231 15.0015 0.87591 15.0003 1.00869C14.9992 1.14147 14.9716 1.27269 14.9192 1.39469C14.8668 1.5167 14.7906 1.62704 14.6951 1.71929L9.40207 7.01229L14.6951 12.3053C14.8772 12.4939 14.978 12.7465 14.9757 13.0087C14.9735 13.2709 14.8683 13.5217 14.6829 13.7071C14.4975 13.8925 14.2467 13.9977 13.9845 14C13.7223 14.0022 13.4697 13.9014 13.2811 13.7193L7.98807 8.42629L2.69507 13.7193C2.50647 13.9014 2.25386 14.0022 1.99167 14C1.72947 13.9977 1.47866 13.8925 1.29325 13.7071C1.10784 13.5217 1.00267 13.2709 1.00039 13.0087C0.998115 12.7465 1.09891 12.4939 1.28107 12.3053L6.57407 7.01229L1.28107 1.71929C1.0936 1.53176 0.988281 1.27745 0.988281 1.01229C0.988281 0.747124 1.0936 0.492816 1.28107 0.305288Z"
                                fill="#5A5C5F"
                            />
                            </svg>
                            </div>
                        </div>
                        
                    </div>
                `;
                });
            } else {
                html = '<p>Your cart is empty.</p>';
            }
            cartItemsContainer.innerHTML = html;

        })

    }
</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
       // updateCartUI();

       
        attachShippingOptionListeners();
        var checkoutButton = document.querySelector('.checkout--btn');
        checkoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            let cart = JSON.parse(localStorage.getItem('cart'));
            $.ajax({
                url: "{{ route('cart.store') }}",
                type: "POST",
                data: {
                    cart: cart,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = "{{ route('checkout.index') }}";
                }
            });
        });
    });
    function attachShippingOptionListeners() {
        const shippingOptions = document.querySelectorAll('input[name="shipping-services"]');
        shippingOptions.forEach(option => {
            option.addEventListener('change', function() {
                //updateCartUI();
            });
        });
    }
</script>


<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     const form = document.getElementById('checkout-form');
    //     form.addEventListener('submit', function(event) {
    //         event.preventDefault();
    //         document.getElementById('cart-data').value = localStorage.getItem('cart');
    //         document.getElementById('selected-shipping-service').value = document.querySelector(
    //             'input[name="shipping-services"]:checked').id;
    //         document.getElementById('selected-payment-option').value = document.querySelector(
    //             'select[name="payment-options"]').value;
    //         form.submit();
    //         localStorage.clear();
    //     });
    //     //updateCartUI();
    //     attachEventListeners();
    // });
</script>

<script>
    function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
</script>




@stack('script')

