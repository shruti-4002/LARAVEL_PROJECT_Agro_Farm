@extends('layouts.app')

@section('title', 'Buyer Crops - AgriMandi')

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Buyer market</p>
            <h1>Available crops</h1>
            <p class="muted">Browse active farmer listings and place crop orders.</p>
        </div>
    </div>

    <section class="grid three">
        @forelse($products as $product)
            <article class="product-card">
                <div>
                    <div class="product-meta">
                        <span class="pill">{{ $product['region'] }}</span>
                        <span class="pill blue">{{ $product['quantity'] }} {{ $product['unit'] }} left</span>
                    </div>
                    <h2 style="margin: 12px 0 4px;">{{ $product['crop_name'] }}</h2>
                    <p class="muted" style="margin-bottom: 0;">By {{ $product['farmer_name'] }}</p>
                </div>
                <div>
                    <div class="price">Rs {{ number_format($product['price'], 2) }}</div>
                    <p class="muted" style="margin-bottom: 0;">per {{ $product['unit'] }}</p>
                </div>
                @if(!empty($product['description']))
                    <p>{{ $product['description'] }}</p>
                @endif
                <form method="post" action="{{ route('buyer.orders.store', $product['_id']) }}">
                    @csrf
                    <div class="field">
                        <label for="quantity-{{ $product['_id'] }}">Quantity</label>
                        <input class="input" id="quantity-{{ $product['_id'] }}" name="quantity" type="number" min="0.1" step="0.1" max="{{ $product['quantity'] }}" value="1" required>
                    </div>
                    <button class="button" type="submit">Buy Crop</button>
                </form>
            </article>
        @empty
            <div class="empty">No active crops listed yet.</div>
        @endforelse
    </section>

    <section style="margin-top: 28px;">
        <div class="page-head">
            <div>
                <p class="eyebrow">Your buying history</p>
                <h2>Orders placed</h2>
            </div>
        </div>

        @if(count($orders))
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Crop</th>
                            <th>Seller</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order['crop_name'] }}</td>
                                <td>{{ $order['seller_name'] }}</td>
                                <td>{{ $order['quantity'] }} {{ $order['unit'] }}</td>
                                <td>Rs {{ number_format($order['total_amount'], 2) }}</td>
                                <td><span class="pill gold">{{ ucfirst($order['status']) }}</span></td>
                                <td>{{ $order['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty">No orders placed yet.</div>
        @endif
    </section>

    <section style="margin-top: 28px;">
        <div class="page-head">
            <div>
                <p class="eyebrow">Local mandi</p>
                <h2>{{ session('user.region') }} prices</h2>
            </div>
        </div>
        @include('partials.mandi-table', ['rows' => $mandiRows])
    </section>
@endsection
