@push('script')
@endpush

<div class="cart--area--wrapper">
    <div class="cart--area--content">
        <div class="cart--intro--area">
            <div class="close--cart--btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path
                        d="M36.6676 18.3317H7.35761L16.1793 9.51001C16.3385 9.35627 16.4654 9.17236 16.5528 8.96902C16.6401 8.76568 16.6861 8.54698 16.688 8.32568C16.69 8.10438 16.6478 7.88492 16.564 7.68009C16.4802 7.47526 16.3564 7.28917 16.1999 7.13269C16.0435 6.9762 15.8574 6.85244 15.6525 6.76864C15.4477 6.68484 15.2282 6.64267 15.0069 6.64459C14.7856 6.64652 14.5669 6.69249 14.3636 6.77984C14.1603 6.86719 13.9764 6.99416 13.8226 7.15335L2.15595 18.82C1.84349 19.1326 1.66797 19.5564 1.66797 19.9983C1.66797 20.4403 1.84349 20.8641 2.15595 21.1767L13.8226 32.8433C14.137 33.1469 14.558 33.3149 14.9949 33.3111C15.4319 33.3073 15.85 33.1321 16.159 32.823C16.468 32.514 16.6433 32.096 16.6471 31.659C16.6509 31.222 16.4829 30.801 16.1793 30.4867L7.35761 21.665H36.6676C37.1096 21.665 37.5336 21.4894 37.8461 21.1769C38.1587 20.8643 38.3343 20.4404 38.3343 19.9983C38.3343 19.5563 38.1587 19.1324 37.8461 18.8198C37.5336 18.5073 37.1096 18.3317 36.6676 18.3317Z"
                        fill="black" />
                </svg>
            </div>

            <h3>YOUR CART</h3>
        </div>
        <form action="">
            <div id="cart-items-container" class="cart--items--list--wrapper">
                {{-- All Products Are here --}}
            </div>
            <div class="gifts" style="display:none;">
                     <h3>Free Gifts</h3>
                     <ul>
                       <li>dwdwd</li>
                       <li>dwdwd</li>
                     </ul>
                 </div>
            
            
            
            
<div class="gift-section" style="display: none;">
                    <h3>Free Gifts</h3>
                    <div class="gift-list"></div>
                </div>
            

            <a href="{{ route('checkout.index') }}" class="checkout--btn">CHECK-OUT</a>
        </form>
    </div>
</div>

