@extends('admin.layout')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Product Report</h2>
					</div>
					<div class="card-body">
						@include('admin.partials.flash')
						@include('admin.reports.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>Name</th>
								<th>SKU</th>
								<th>Items Sold</th>
								<th>Net Revenue</th>
								<th>Orders</th>
								<th>Stock</th>
							</thead>
							<tbody>
								@php
									$totalNetRevenue = 0;
								@endphp
								@forelse ($products as $product)
									<tr>    
										<td>{{ $product->name }}</td>
										<td>{{ $product->sku }}</td>
										<td>{{ $product->items_sold }}</td>
										<td>{{ \General::priceFormat($product->net_revenue) }}</td>
										<td>{{ $product->num_of_orders }}</td>
										<td>{{ $product->stock }}</td>
									</tr>
									
									@php
										$totalNetRevenue += $product->net_revenue;
									@endphp
								@empty
									<tr>
										<td colspan="6">No records found</td>
									</tr>
								@endforelse

								@if ($products)
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>{{ \General::priceFormat($totalNetRevenue) }}</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection