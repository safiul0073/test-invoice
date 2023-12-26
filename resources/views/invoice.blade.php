
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
	</head>
	<body>
		<header>
			<h1>Invoice</h1>
			<address contenteditable>
				<p>{{ $data['customer_name'] }}</p>
				<p>{{ $data['customer_email']  }}</p>
			</address>
			<span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span>
		</header>
		<article>
			<h1>Recipient</h1>
			<address contenteditable>
				<p>Some Company<br>c/o Some Guy</p>
			</address>
			<table class="meta">
				<tr>
					<th><span contenteditable>Invoice #</span></th>
					<td><span contenteditable>{{ $data['invoice_id'] }}</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Date</span></th>
					<td><span contenteditable>{{ $data['date'] }}</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span contenteditable>Item</span></th>
						<th><span contenteditable>Description</span></th>
						<th><span contenteditable>Rate</span></th>
						<th><span contenteditable>Quantity</span></th>
						<th><span contenteditable>Price</span></th>
					</tr>
				</thead>
                <tbody>
                    @foreach ($data['items'] as $item)
                    <tr>
						<td><a class="cut">-</a><span contenteditable>{{ $item['name'] }}</span></td>
						<td><span contenteditable>{{ $item['description'] }}</span></td>
						<td><span data-prefix>$</span><span contenteditable>{{ $item['price'] }}</span></td>
						<td><span contenteditable>{{ $item['quantity'] }}</span></td>
						<td><span data-prefix>$</span><span>{{ $item['price'] *  $item['quantity'] }}</span></td>
					</tr>
                    @endforeach
                </tbody>
 			</table>
			<table class="balance">
				<tr>
					<th><span contenteditable>Total</span></th>
					<td><span data-prefix>$</span><span>{{ $data['total_amount'] }}</span></td>
				</tr>
			</table>
		</article>
	</body>
</html>
