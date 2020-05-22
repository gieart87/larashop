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
				<a class="animate-left" title="Wishlist" href="#">
					<i class="pe-7s-like"></i>
				</a>
				<a class="animate-top" title="Add To Cart" href="#">
					<i class="pe-7s-cart"></i>
				</a>
				<a class="animate-right" title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
					<i class="pe-7s-look"></i>
				</a>
			</div>
		</div>
		<div class="product-content">
			<h4><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></h4>
			<span>{{ number_format($product->price_label()) }}</span>
		</div>
	</div>
</div>