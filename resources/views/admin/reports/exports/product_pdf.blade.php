<!DOCTYPE html>
<html>
  	<head>
		<meta charset="utf-8">
		<title>Product Report</title>
		<style type="text/css">
			table {
				width: 100%;
			}

			table tr td,
			table tr th {
				font-size: 10pt;
				text-align: left;
			}

			table tr:nth-child(even) {
				background-color: #f2f2f2;
			}

			table th, td {
  				border-bottom: 1px solid #ddd;
			}

			table th {
				border-top: 1px solid #ddd;
				height: 40px;
			}

			table td {
				height: 25px;
			}
		</style>
	</head>
  	<body>
		<h2>Product Report</h2>
		<hr>
		<p>Period : {{ \General::datetimeFormat($startDate, 'd M Y') }} - {{ \General::datetimeFormat($endDate, 'd M Y') }}</p>
		<table>
			<thead>
				<tr>
				<th>Name</th>
				<th>SKU</th>
				<th>Items Sold</th>
				<th>Net Revenue</th>
				<th>Orders</th>
				<th>Stock</th>
				</tr>
			</thead>
			<tbody>
				@php
					$totalNetRevenue = 0;
				@endphp
				@foreach ($products as $product)
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
				@endforeach
				<tr>    
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>{{ \General::priceFormat($totalNetRevenue) }}</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>