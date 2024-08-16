@if ($latest_product->isEmpty())
    <h3 class="affiliate--common-title">NO PRODUCT FOUND</h3>
@else
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

            <div class="product--hover--info">
                <div class="action--button--wrapper">
                    <a data-id="{{ $product->id }}" data-type="Shop" href="javascript:void(0)" class="cart--btn add_cart">
                        <img src="{{ asset('frontend/images/cart-icon.svg') }}" alt="" />
                    </a>
                </div>
                <h3 class="prod--title">{{ $product->title }}</h3>

                <div class="prod--pricing">
                    <p class="past">$ <span>{{ $product->original_price }}</span></p>
                    <p class="current">$ <span>{{ $product->discount_price }}</span></p>
                </div>
            </div>

            <div class="hovering--image">
                <img src="{{ asset($product->image) }}" />
            </div>
        </div>
    @endforeach
@endif