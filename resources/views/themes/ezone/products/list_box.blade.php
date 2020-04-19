<div class="col-lg-12">
    <div class="product-wrapper mb-30 single-product-list product-list-right-pr mb-60">
        <div class="product-img list-img-width">
            <a href="{{ url('product/'. $product->slug) }}">
                @if ($product->productImages->first())
					<img src="{{ asset('storage/'.$product->productImages->first()->path) }}" alt="{{ $product->name }}">
				@else
					<img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
				@endif
            </a>
            <span>hot</span>
            <div class="product-action-list-style">
                <a class="animate-right" title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                    <i class="pe-7s-look"></i>
                </a>
            </div>
        </div>
        <div class="product-content-list">
            <div class="product-list-info">
                <h4><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></h4>
                <span>{{ number_format($product->price_label()) }}</span>
                <p>{!! $product->short_description !!}</p>
            </div>
            <div class="product-list-cart-wishlist">
                <div class="product-list-cart">
                    <a class="btn-hover list-btn-style" href="#">add to cart</a>
                </div>
                <div class="product-list-wishlist">
                    <a class="btn-hover list-btn-wishlist" href="#">
                        <i class="pe-7s-like"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>