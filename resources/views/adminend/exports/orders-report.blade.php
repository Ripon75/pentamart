<table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Customer Name</th>
        <th>Customer Contact</th>
        <th>Items Amount</th>
        <th>Delivery Amount</th>
        <th>Special Discount</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
        @php
            $itemTotalAmount = 0;
            $totalDeliveryAmount = 0;
            $totalSpecialDiscout = 0;
            $totalAmount = 0;
        @endphp
        @foreach ($result as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ date('d-m-Y', strtotime($data->ordered_at)) ?? null }}</td>
                <td>{{ $data->user->name ?? null }}</td>
                @php
                    $phoneNumber = $data->user->phone_number ?? null;
                    if ($phoneNumber) {
                        $phoneNumber = substr($phoneNumber, 2);
                    }
                @endphp
                <td>{{ $phoneNumber }}</td>
                @php
                    $itemPrice = $data->order_items_value;
                    $itemTotalAmount += $itemPrice;
                @endphp
                <td>{{ $itemPrice }}</td>
                @php
                    $deliveryCharge = $data->delivery_charge;
                    $deliveryGatewayCharge = $data->deliveryGateway->price ?? 0;
                    $deliveryCharge = $deliveryCharge ? $deliveryCharge : $deliveryGatewayCharge;
                    $totalDeliveryAmount += $deliveryCharge;
                @endphp
                <td>{{ $deliveryCharge }}</td>
                @php
                    $specialDiscout = $data->total_special_discount ?? 0;
                    $totalSpecialDiscout += $specialDiscout;
                @endphp
                <td>{{ $specialDiscout }}</td>
                @php
                    $totalWithDeliveryCharge = round($data->payable_order_value);
                    $totalAmount += $totalWithDeliveryCharge;
                @endphp
                <td>{{ $totalWithDeliveryCharge }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="text-sm border border-black">
            <td class="text-center"colspan="1">#</td>
            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-2" colspan="3">Ground Total : </td>
            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ $itemTotalAmount }} </td>
            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ $totalDeliveryAmount }}</td>
            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ $totalSpecialDiscout }}</td>
            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ $totalAmount }}</td>
        </tr>
    </tfoot>
</table>
