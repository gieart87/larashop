@extends('admin.layout')

@section('content')
<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>Order Shipment #{{ $shipment->order->code }}</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					{!! Form::model($shipment, ['url' => ['admin/shipments', $shipment->id], 'method' => 'PUT']) !!}
					{!! Form::hidden('id') !!}
					<div class="form-group row">
						<div class="col-md-6">
							{!! Form::label('first_name', 'First name') !!}
							{!! Form::text('first_name', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
						<div class="col-md-6">
							{!! Form::label('last_name', 'Last name') !!}
							{!! Form::text('last_name', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('company', 'Company') !!}
						{!! Form::text('company', null, ['class' => 'form-control', 'readonly' => true]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('address1', 'Home number and street name') !!}
						{!! Form::text('address1', null, ['class' => 'form-control', 'readonly' => true]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('address2', 'Apartment, suite, unit etc. (optional)') !!}
						{!! Form::text('address2', null, ['class' => 'form-control', 'readonly' => true]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('province_id', 'Province') !!}
						{!! Form::select('province_id', $provinces, $shipment->province_id, ['id' => 'province-id', 'class' => 'form-control', 'disabled' => true]) !!}
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							{!! Form::label('city_id', 'City') !!}
							{!! Form::select('city_id', $cities, $shipment->city_id, ['id' => 'city-id', 'class' => 'form-control', 'disabled' => true])!!}
						</div>
						<div class="col-md-6">
							{!! Form::label('postcode', 'Postcode / zip') !!}
							{!! Form::text('postcode', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							{!! Form::label('phone', 'Phone') !!}
							{!! Form::text('phone', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
						<div class="col-md-6">
							{!! Form::label('email', 'Email') !!}
							{!! Form::text('email', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							{!! Form::label('total_qty', 'Quantity') !!}
							{!! Form::text('total_qty', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
						<div class="col-md-6">
							{!! Form::label('total_weight', 'Total Weight (gram)') !!}
							{!! Form::text('total_weight', null, ['class' => 'form-control', 'readonly' => true]) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('track_number', 'Track Number') !!}
						{!! Form::text('track_number', null, ['class' => 'form-control']) !!}
					</div>
					<div class="form-footer pt-5 border-top">
						<button type="submit" class="btn btn-primary btn-default">Save</button>
						<a href="{{ url('admin/orders/'. $shipment->order->id) }}" class="btn btn-secondary btn-default">Back</a>
					</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>Detail Order</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-6 col-lg-6">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
							<address>
								{{ $shipment->order->customer_first_name }} {{ $shipment->order->customer_last_name }}
								<br> {{ $shipment->order->customer_address1 }}
								<br> {{ $shipment->order->customer_address2 }}
								<br> Email: {{ $shipment->order->customer_email }}
								<br> Phone: {{ $shipment->order->customer_phone }}
								<br> Postcode: {{ $shipment->order->customer_postcode }}
							</address>
						</div>
						<div class="col-xl-6 col-lg-6">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
							<address>
								ID: <span class="text-dark">#{{ $shipment->order->code }}</span>
								<br> {{ \General::datetimeFormat($shipment->order->order_date) }}
								<br> Status: {{ $shipment->order->status }}
								<br> Payment Status: {{ $shipment->order->payment_status }}
								<br> Shipped by: {{ $shipment->order->shipping_service_name }}
							</address>
						</div>
					</div>
					<table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Item</th>
								<th>Qty</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($shipment->order->orderItems as $item)
								<tr>
									<td>{{ $item->sku }}</td>
									<td>{{ $item->name }}</td>
									<td>{{ $item->qty }}</td>
									<td>{{ \General::priceFormat($item->sub_total) }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="6">Order item not found!</td>
								</tr>
							@endforelse
						</tbody>
					</table>
					<div class="row justify-content-end">
						<div class="col-lg-5 col-xl-6 col-xl-3 ml-sm-auto">
							<ul class="list-unstyled mt-4">
								<li class="mid pb-3 text-dark">Subtotal
									<span class="d-inline-block float-right text-default">{{ \General::priceFormat($shipment->order->base_total_price) }}</span>
								</li>
								<li class="mid pb-3 text-dark">Tax(10%)
									<span class="d-inline-block float-right text-default">{{ \General::priceFormat($shipment->order->tax_amount) }}</span>
								</li>
								<li class="mid pb-3 text-dark">Shipping Cost
									<span class="d-inline-block float-right text-default">{{ \General::priceFormat($shipment->order->shipping_cost) }}</span>
								</li>
								<li class="pb-3 text-dark">Total
									<span class="d-inline-block float-right">{{ \General::priceFormat($shipment->order->grand_total) }}</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection