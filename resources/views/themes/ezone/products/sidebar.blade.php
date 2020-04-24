<div class="shop-sidebar mr-50">
    <form method="GET" action="{{ url('products')}}">
		<div class="sidebar-widget mb-40">
			<h3 class="sidebar-title">Filter by Price</h3>
			<div class="price_filter">
				<div id="slider-range"></div>
				<div class="price_slider_amount">
					<div class="label-input">
						<label>price : </label>
						<input type="text" id="amount" name="price"  placeholder="Add Your Price" style="width:170px" />
						<input type="hidden" id="productMinPrice" value="{{ $minPrice }}"/>
						<input type="hidden" id="productMaxPrice" value="{{ $maxPrice }}"/>
					</div>
					<button type="submit">Filter</button> 
				</div>
			</div>
		</div>
    </form>

    @if ($categories)
		<div class="sidebar-widget mb-45">
			<h3 class="sidebar-title">Categories</h3>
			<div class="sidebar-categories">
				<ul>
					@foreach ($categories as $category)
							<li><a href="{{ url('products?category='. $category->slug) }}">{{ $category->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
    
    @if ($colors)
		<div class="sidebar-widget sidebar-overflow mb-45">
			<h3 class="sidebar-title">color</h3>
			<div class="sidebar-categories">
				<ul>
					@foreach ($colors as $color)
						<li><a href="{{ url('products?option='. $color->id) }}">{{ $color->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
    @endif

    @if ($sizes)
		<div class="sidebar-widget mb-40">
			<h3 class="sidebar-title">size</h3>
			<div class="product-size">
				<ul>
					@foreach ($sizes as $size)
						<li><a href="{{ url('products?option='. $size->id) }}">{{ $size->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
</div>