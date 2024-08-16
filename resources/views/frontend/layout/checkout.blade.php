@extends('frontend.app')

@section('title')
    Checkout
@endsection
@push('style')

    <style>
        .extended--footer .extra--wrapper {
            display: none;
        }
        .latest--prouduct--area--wrapper {
    background-color: #ffffeb; 
}
    </style>
@endpush

@push('script')
<script>
    $(document).ready(function(){
        updateCartUI();
        setInterval(function(){
            var subtotal = 0;
            $('.item--price').each(function(){
                var amount = parseFloat($(this).html().replace('$',''))
                subtotal+=amount
            })
            $('#subtotal-amount').html(parseFloat(subtotal).toFixed(2))
            var shippingAmount = parseFloat($('#shipping-amount').html())
            $('#checkout-amount').html(parseFloat(parseFloat(shippingAmount)+parseFloat(subtotal)).toFixed(2))
        },500)
    })
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the <select> element
            const selectElement = document.querySelector('select[name="message"]');

            // Add an event listener for changes
            selectElement.addEventListener('change', function() {
                // Get the selected value
                const selectedValue = selectElement.value;
                console.log('Selected Value:', selectedValue);

                // Remove the .cover1 class from all image containers first
                document.querySelectorAll('.cart--item--img').forEach(imgContainer => {
                    imgContainer.classList.remove('cover1');
                });

                // Select the target element based on the selected value
                const targetElement = document.querySelector(`[data-value="${selectedValue}"]`);
                if (targetElement) {
                    const imgElement = targetElement.querySelector('.cart--item--img');
                    if (imgElement) {
                        imgElement.classList.add('cover1');
                        console.log('Class .cover1 added to image container');
                    } else {
                        console.log('Image container not found');
                    }
                } else {
                    console.log('Target element not found');
                }
            });
        });
    </script>
    
@endpush

@section('content')
    <main class="checkout--main--area--wrapper">
        <section class="checkout--info--area--wrapper">
            <div class="container">
                <h3 class="affiliate--common-title">Check Your INFO</h3>
                
              



                       


                <div class="checkout--info--area--content">
                    <div class="left">
                        <form action="#">
                            <!-- cart items -->
                            <div id="cart-items-container" class="cart--items--list--wrapper">
                                
                                {{-- All Products Are here --}}
                            </div>
                             <div class="gift-section" style="display: none;">
                    <h3>Free Gifts</h3>
                    <div class="gift-list"></div>
                </div>

                            @php $sub_total = 0; @endphp
                            @if (session('cart'))
                                @foreach (session('cart') as $sku_code => $value)
                                    @php $sub_total += ($value['price'] * $value['quantity']); @endphp
                                @endforeach
                            @endif

                            <!-- final pricing area -->
                            <div class="final--pricing--area">
                                <div class="price--list">
                                    <ul>
                                        <li>
                                            <p>Subtotal</p>
                                            <p>$<span id="subtotal-amount">{{ $sub_total }}</span></p>
                                        </li>
                                        <li>
                                            <p>Shipping</p>
                                            <p>$<span id="shipping-amount">0.00</span></p>
                                        </li>
                                    </ul>
                                </div>
                                @php $g_total = $sub_total + Helper::getSetting()->express_delivery ; @endphp
                                <div class="total--price">
                                    <p>Total</p>
                                    <p>$<span id="checkout-amount">{{ $g_total }}</span></p>
                                </div>
                            </div>
                        </form>
                    </div>



                    <div class="right">
                        <h3 class="hero--text">General Information</h3>
                        <!-- auth form -->
                        
                        <form id="checkout-form" action="{{ route('order.store') }}" method="POST"
                            class="auth--form--wrapper">
                            @csrf
                            <div class="input--wrapper">
                                <input type="hidden" name="affiliate_link" value="{{ URL::previous() }}">

                                <input type="text" name="address" placeholder="ADDRESS" required />
                                <input type="text" name="town_city" placeholder="TOWN/CITY" required />
                                <input type="number" name="phone" placeholder="PHONE" required />
                                <input type="text" name="state_code" placeholder="State Code" required />
                                <input type="text" name="country_code" placeholder="COuntry Code" required />
                                <input type="text" name="zip_code" placeholder="Zip Code" required />
                                
                                <input type="hidden" name="shipping_service" id="selected-shipping-service">
                                

                                @if($is_spark)
                                    <select name="message">
                                        <option value="" selected disabled>choose between 2 exclusive limited edition covers</option>
                                        <option class="cvr1" value="Rogue Assassin Haunted">Rogue Assassin Haunted</option>
                                        <option class="cvr2" value="A Revival Documentory">A Revival Documentory</option>
                                    </select>
                                @endif
                            </div>

                            <!-- shipping services wrapper -->
                            <div class="shipping--services--wrapper">
                                <h3 class="hero--text">Shipping Service</h3>
                                <div class="input--wrapper">
                                    <div class="single--service" data-type = "Express" data-amount = "{{ $g_total }}">
                                        <input type="radio" name="shipping-services" id="express" value="express_delivery"/>
                                        <label for="express">
                                            <p class="title">Express Delivery</p>
                                            <p class="description">We deliver in 1-2 days</p>

                                            <p class="price">$<span class="delivery">{{ Helper::getSetting()->express_delivery }}</span></p>
                                        </label>
                                    </div>
                                    <div class="single--service" data-type = "Standard" data-amount = "{{ $sub_total + Helper::getSetting()->standard_delivery }}">
                                        <input type="radio" name="shipping-services" id="standard" value="standard_delivery"/>
                                        <label for="standard">
                                            <p class="title">Standard Delivery</p>
                                            <p class="description">We deliver in 1-2 days</p>

                                            <p class="price">$<span class="delivery">{{ Helper::getSetting()->standard_delivery }}</span></p>
                                        </label>
                                    </div>
                                    <!--<div class="single--service">-->
                                    <!--    <input type="radio" name="shipping-services" id="store" />-->
                                    <!--    <label for="store">-->
                                    <!--        <p class="title">Pickup from store</p>-->
                                    <!--        <p class="description">Today</p>-->

                                    <!--        <p class="price">$<span>0.00</span></p>-->
                                    <!--    </label>-->
                                    <!--</div>-->
                                </div>
                            </div>

                            <!-- payment options wrapper -->
                            <div class="payment--options--wrapper">
                                <h3 class="hero--text">Payment options</h3>

                                <div class="select--wrapper">
                                    <select required name="payment-options" id="">
                                        <option value="stripe">Stripe</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="submit--btn">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
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


        <section class="latest--prouduct--area--wrapper section--gap">
            <div class="container">
                <h3 class="affiliate--common-title">RECOMMENDED PRODUCTS</h3>
                <div class="popular--product--content">
                    @foreach ($latest_product as $product)
                        <div class="single--pouplar--product">
                            <div class="img--wrapper"> 
                                <img src="{{ Helper::getImage($product->image) }}" alt="{{ $product->title }}" />
                            </div>

                            <div class="description--wrapper">
                                <p class="prod--title">{{ $product->title }}</p>

                                <div class="pricing">
                                    <p class="past">$ <span>{{ $product->original_price }}</span></p>
                                    <p class="current">$ <span>{{ $product->discount_price }}</span></p>
                                </div>
                            </div>

                            {{-- Add the hovering info and image sections here --}}
                            <div class="product--hover--info">
                                <div class="action--button--wrapper">
                                    <a data-id="{{ $product->id }}" data-type="Shop"
                                        href="javascript:void(0)" class="cart--btn add_cart">
                                        <img src="{{ asset('frontend/images/cart-icon.svg') }}" alt="" />
                                    </a>

                                    {{-- <a href="javascript:void(0)" class="share--btn">
                                        <img src="{{ asset('frontend/images/share-icon.svg') }}" alt="" />
                                    </a> --}}

                                </div>
                                <h3 class="prod--title">{{ $product->title }}</h3>

                                <div class="prod--pricing">
                                    <p class="past">$ <span>{{ $product->original_price }}</span></p>
                                    <p class="current">$ <span>{{ $product->discount_price }}</span></p>
                                </div>
                            </div>

                            {{-- hovering image --}}
                            <div class="hovering--image">
                                <img src="{{ Helper::getImage($product->image) }}" alt="{{ $product->title }}" />
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    </main>
@endsection
