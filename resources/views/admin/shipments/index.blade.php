@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Shipments</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Total Qty</th>
                                <th>Total Weight (gram)</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($shipments as $shipment)
                                    <tr>    
                                        <td>
                                            {{ $shipment->order->code }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{\General::datetimeFormat($shipment->order->order_date) }}</span>
                                        </td>
                                        <td>{{ $shipment->order->customer_full_name }}</td>
                                        <td>
                                            {{ $shipment->status }}
                                            <br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $shipment->shipped_at }}</span>
                                        </td>
                                        <td>{{ $shipment->total_qty }}</td>
                                        <td>{{ \General::priceFormat($shipment->total_weight) }}</td>
                                        <td>
                                            @can('edit_orders')
                                                <a href="{{ url('admin/orders/'. $shipment->order->id) }}" class="btn btn-info btn-sm">show</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $shipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection