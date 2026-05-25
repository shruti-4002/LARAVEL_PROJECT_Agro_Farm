@if(count($orders))
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Crop</th>
                    <th>{{ $mode === 'seller' ? 'Buyer' : 'Seller' }}</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order['crop_name'] }}</td>
                        <td>{{ $mode === 'seller' ? $order['buyer_name'] : $order['seller_name'] }}</td>
                        <td>{{ $order['quantity'] }} {{ $order['unit'] }}</td>
                        <td>Rs {{ number_format($order['unit_price'], 2) }}</td>
                        <td>Rs {{ number_format($order['total_amount'], 2) }}</td>
                        <td><span class="pill gold">{{ ucfirst($order['status']) }}</span></td>
                        <td>{{ $order['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty">No orders yet.</div>
@endif
