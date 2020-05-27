<div class="col-md-6 col-xl-4">
	<div class="product-wrapper mb-30">
		<div class="product-img">
			<a href="{{ url('product/'. $product->slug) }}">
				@if ($product->productImages->first())
					<img src="{{ asset('storage/'.$product->productImages->first()->medium) }}" alt="{{ $product->name }}">
				@else
					<img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
				@endif
			</a>
			<span>hot</span>
			<div class="product-action">
				<a class="animate-left add-to-fav" title="Favorite"  product-slug="{{ $product->slug }}" href="">
					<i class="pe-7s-like"></i>
				</a>
				<a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $product->id }}" product-type="{{ $product->type }}" product-slug="{{ $product->slug }}">
					<i class="pe-7s-cart"></i>
				</a>
				<a class="animate-right quick-view" title="Quick View" product-slug="{{ $product->slug }}" href="">
					<i class="pe-7s-look"></i>
				</a>
			</div>
		</div>
		<div class="product-content">
			<h4><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></h4>
			<span>{{ number_format($product->priceLabel()) }}</span>
		</div>
	</div>
</div>