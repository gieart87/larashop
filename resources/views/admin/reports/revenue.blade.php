@extends('admin.layout')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Revenue Report</h2>
					</div>
					<div class="card-body">
						@include('admin.partials.flash')
						@include('admin.reports.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>Date</th>
								<th>Orders</th>
								<th>Gross Revenue</th>
								<th>Taxes</th>
								<th>Shipping</th>
								<th>Net Revenue</th>
							</thead>
							<tbody>
								@php
									$totalOrders = 0;
									$totalGrossRevenue = 0;
									$totalTaxesAmount = 0;
									$totalShippingAmount = 0;
									$totalNetRevenue = 0;
								@endphp
								@forelse ($revenues as $revenue)
									<tr>    
										<td>{{ \General::datetimeFormat($revenue->date, 'd M Y') }}</td>
										<td>
											<a href="{{ url('admin/orders?start='. $revenue->date .'&end='. $revenue->date . '&status=completed') }}">{{ $revenue->num_of_orders }}</a>
										</td>
										<td>{{ \General::priceFormat($revenue->gross_revenue) }}</td>
										<td>{{ \General::priceFormat($revenue->taxes_amount) }}</td>
										<td>{{ \General::priceFormat($revenue->shipping_amount) }}</td>
										<td>{{ \General::priceFormat($revenue->net_revenue) }}</td>
									</tr>

									@php
										$totalOrders += $revenue->num_of_orders;
										$totalGrossRevenue += $revenue->gross_revenue;
										$totalTaxesAmount += $revenue->taxes_amount;
										$totalShippingAmount += $revenue->shipping_amount;
										$totalNetRevenue += $revenue->net_revenue;
									@endphp
								@empty
									<tr>
										<td colspan="6">No records found</td>
									</tr>
								@endforelse
								
								@if ($revenues)
									<tr>
										<td>Total</td>
										<td><strong>{{ $totalOrders }}</strong></td>
										<td><strong>{{ \General::priceFormat($totalGrossRevenue) }}</strong></td>
										<td><strong>{{ \General::priceFormat($totalTaxesAmount) }}</strong></td>
										<td><strong>{{ \General::priceFormat($totalShippingAmount) }}</strong></td>
										<td><strong>{{ \General::priceFormat($totalNetRevenue) }}</strong></td>
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