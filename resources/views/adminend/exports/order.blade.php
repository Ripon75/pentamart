<table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Customer Name</th>
        <th>Delivery Gateway</th>
        <th>Payment Gateway</th>
        <th>Shipping Address</th>
        <th>Shipping Area</th>
        <th>Current Status</th>
        <th>Status Date</th>
        <th>Customer Phone</th>
        <th>Customer Email</th>
        <th>Billed Amount</th>
        <th>Delivery Charge</th>
        <th>Items Discount</th>
        <th>Special Discount</th>
        <th>Coupon Discount</th>
        <th>Coupon Code</th>
        <th>Offer Name</th>
        <th>Trade Price</th>
        <th>Prescription</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ date('d-m-Y', strtotime($order->ordered_at)) }}</td>
            <td>{{ $order->user->name ?? null }}</td>
            <td>{{ ($order->deliveryGateway->name) ?? null }}</td>
            <td>{{ ($order->paymentGateway->name) ?? null }}</td>
            <td>{{ ($order->shippingAddress->address) ?? null }}</td>
            <td>{{ ($order->shippingAddress->area->name) ?? null }}</td>
            <td>
                @php
                    $statusCount = count($order->status);
                @endphp
                @if ($statusCount > 0)
                    {{ $order->status[$statusCount-1]->name ?? null }}
                @else
                    {{ 'N/A' }}
                @endif
            </td>
            @if (count($order->status) > 0)
                <td>
                    {{ ($order->status[$statusCount-1]->pivot->created_at->format('Y-m-d')) ?? null }}
                </td>
            @else
                <td>N/A</td>
            @endif
            <td>
                @php
                    $phoneNumber = $order->user->phone_number ?? null;
                    if ($phoneNumber) {
                        $phoneNumber = substr($phoneNumber, 2);
                    }
                @endphp
                {{ $phoneNumber }}
            </td>
            <td>{{ $order->user->email ?? null }}</td>
            <td>{{ round($order->payable_order_value) }}</td>
            <td>{{ $order->delivery_charge }}</td>
            <td>{{ $order->total_items_discount }}</td>
            <td>{{ $order->total_special_discount }}</td>
            <td>{{ $order->coupon_value }}</td>
            <td>{{ $order->coupon->code ?? null }}</td>
            <td>{{ $order->coupon->name ?? null }}</td>
            <td>Trade price</td>
            <td>
                @if (count($order->prescriptions))
                    YES
                @else
                    NO
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
