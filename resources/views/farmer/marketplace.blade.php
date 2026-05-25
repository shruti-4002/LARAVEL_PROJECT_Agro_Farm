
@extends('layouts.app')

@section('title', 'Farmer Market - AgriMandi')

@section('content')
    <style>
        .premium-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            padding: 24px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .premium-card:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.06), 0 10px 10px -5px rgba(0, 0, 0, 0.03) !important;
            border-color: #cbd5e1 !important;
        }
        .action-btn {
            background: #1e293b !important;
            color: #ffffff !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            border: none !important;
            cursor: pointer !important;
            transition: background 0.2s ease !important;
        }
        .action-btn:hover {
            background: #0f172a !important;
        }
    </style>

    <div class="page-head" style="margin-bottom: 40px; padding-bottom: 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <p class="eyebrow" style="text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: #10b981; margin-bottom: 6px; font-size: 0.75rem;">AgriMandi Hub</p>
            <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -0.75px; color: #0f172a; margin: 0 0 6px 0;">Products around you</h1>
            <p class="muted" style="font-size: 1.05rem; color: #64748b; margin: 0;">Monitor local alternative listings and check your active inventory in real-time.</p>
        </div>
        <div class="actions" style="display: flex; gap: 12px; align-items: center;">
            <a class="button" href="{{ route('farmer.products.create') }}" style="background-color: #10b981; color: white; padding: 12px 24px; border-radius: 10px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25); display: inline-block;">Add New Product</a>
            <a class="button secondary" href="{{ route('farmer.dashboard') }}" style="padding: 12px 24px; border-radius: 10px; font-weight: 600; text-decoration: none; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; display: inline-block;">Dashboard</a>
        </div>
    </div>

    <section style="margin-bottom: 56px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <div style="width: 4px; height: 24px; background: #10b981; border-radius: 4px;"></div>
            <h2 style="font-size: 1.6rem; font-weight: 700; color: #1e293b; margin: 0;">Marketplace Listings</h2>
        </div>
        
        <div class="grid three" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
            @forelse($otherProducts as $product)
                @php
                    $cropName = strtolower($product['crop_name']);
                    
                    if (str_contains($cropName, 'sunflower')) {
                        $imgUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcrOz0HcCTH_MvyvGvu0U2ndLMlVyJd-qTqQ&s';
                    } elseif (str_contains($cropName, 'wheat')) {
                        $imgUrl = 'https://plus.unsplash.com/premium_photo-1661963447711-27f892ffe292?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8d2hlYXR8ZW58MHx8MHx8fDA%3D';
                    } elseif (str_contains($cropName, 'mustard')) {
                        $imgUrl = 'https://samsgardenstore.com/cdn/shop/files/output-onlinepngtools-3.png?v=1725270090';
                    } elseif (str_contains($cropName, 'onion')) {
                        $imgUrl = 'https://plantix.net/en/library/assets/custom/crop-images/onion.jpeg';
                    } elseif (str_contains($cropName, 'soybean') || str_contains($cropName, 'soya')) {
                        $imgUrl = 'https://i.ytimg.com/vi/1M3SEXBvAFY/sddefault.jpg';
                    } elseif (str_contains($cropName, 'rice') || str_contains($cropName, 'paddy')) {
                        $imgUrl = 'https://img.jagranjosh.com/images/2025/09/12/article/image/scientific-name-of-rice-1757656335124.jpg';
                    } elseif (str_contains($cropName, 'potato')) {
                        $imgUrl = 'https://www.simplotfood.com/_next/image?url=https%3A%2F%2Fimages.ctfassets.net%2F0dkgxhks0leg%2FRKiZ605RAV8kjDQnxFCWP%2Fb03b8729817c90b29b88d536bfd37ac5%2F9-Unusual-Uses-For-Potatoes.jpg%3Ffm%3Dwebp&w=1920&q=75';
                    } else {
                        $imgUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQPGKN_bB6lSckokG1pLxLktnGpIIvGsoaL6A&s';
                    }
                @endphp

                <article class="premium-card">
                    <div>
                        <div style="width: 100%; height: 180px; overflow: hidden; border-radius: 12px; margin-bottom: 18px; position: relative; background: #f1f5f9;">
                            <img src="{{ $imgUrl }}" alt="{{ $product['crop_name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0) 60%, rgba(0,0,0,0.2) 100%);"></div>
                        </div>

                        <div class="product-meta" style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                            <span class="pill" style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.3px;">📍 {{ $product['region'] }}</span>
                            <span class="pill blue" style="background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.3px;">📦 {{ $product['quantity'] }} {{ $product['unit'] }} left</span>
                        </div>

                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.4px;">{{ $product['crop_name'] }}</h2>
                        <p class="muted" style="font-size: 0.9rem; color: #64748b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 4px;">
                            <span>by</span> <span style="font-weight: 600; color: #334155;">{{ $product['farmer_name'] }}</span>
                        </p>

                        @if(!empty($product['description']))
                            <p style="font-size: 0.9rem; color: #475569; background: #f8fafc; padding: 12px 14px; border-radius: 10px; margin: 0 0 20px 0; border: 1px dashed #e2e8f0; line-height: 1.5; font-style: italic;">
                                "{{ $product['description'] }}"
                            </p>
                        @endif
                    </div>

                    <div>
                        <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 20px; background: #f0fdf4; padding: 12px 16px; border-radius: 12px; border: 1px solid #dcfce7;">
                            <span class="price" style="font-size: 1.6rem; font-weight: 800; color: #166534;">Rs {{ number_format($product['price'], 2) }}</span>
                            <span class="muted" style="font-size: 0.85rem; color: #15803d; font-weight: 600; text-transform: uppercase;">/ {{ $product['unit'] }}</span>
                        </div>

                        <form method="post" action="{{ route('farmer.orders.store', $product['_id']) }}" style="margin: 0; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                            @csrf
                            <div style="display: flex; gap: 10px; align-items: flex-end;">
                                <div class="field" style="flex: 1; margin: 0;">
                                    <label for="farmer-quantity-{{ $product['_id'] }}" style="display: block; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 6px; letter-spacing: 0.5px;">Quantity</label>
                                    <input class="input" id="farmer-quantity-{{ $product['_id'] }}" name="quantity" type="number" min="0.1" step="0.1" max="{{ $product['quantity'] }}" value="1" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; color: #1e293b; background: #ffffff; box-sizing: border-box; height: 42px;">
                                </div>
                                <button class="action-btn" type="submit" style="height: 42px; white-space: nowrap;">Order Crop</button>
                            </div>
                        </form>
                    </div>
                </article>
            @empty
                <div class="empty" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 16px; color: #64748b; font-size: 1.1rem; font-weight: 500;">
                     No alternative farmer listings active in your area right now.
                </div>
            @endforelse
        </div>
    </section>

    <section style="margin-top: 64px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <div style="width: 4px; height: 24px; background: #3b82f6; border-radius: 4px;"></div>
            <h2 style="font-size: 1.6rem; font-weight: 700; color: #1e293b; margin: 0;">Your active stock</h2>
        </div>

        <div class="grid three" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
            @forelse($ownProducts as $product)
                @php
                    $cropName = strtolower($product['crop_name']);
                     if (str_contains($cropName, 'sunflower')) {
                        $imgUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcrOz0HcCTH_MvyvGvu0U2ndLMlVyJd-qTqQ&s';
                    } elseif (str_contains($cropName, 'wheat')) {
                        $imgUrl = 'https://plus.unsplash.com/premium_photo-1661963447711-27f892ffe292?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8d2hlYXR8ZW58MHx8MHx8fDA%3D';
                    } elseif (str_contains($cropName, 'mustard')) {
                        $imgUrl = 'https://samsgardenstore.com/cdn/shop/files/output-onlinepngtools-3.png?v=1725270090';
                    } elseif (str_contains($cropName, 'onion')) {
                        $imgUrl = 'https://plantix.net/en/library/assets/custom/crop-images/onion.jpeg';
                    } elseif (str_contains($cropName, 'soybean') || str_contains($cropName, 'soya')) {
                        $imgUrl = 'https://i.ytimg.com/vi/1M3SEXBvAFY/sddefault.jpg';
                    } elseif (str_contains($cropName, 'rice') || str_contains($cropName, 'paddy')) {
                        $imgUrl = 'https://img.jagranjosh.com/images/2025/09/12/article/image/scientific-name-of-rice-1757656335124.jpg';
                    } elseif (str_contains($cropName, 'potato')) {
                        $imgUrl = 'https://www.simplotfood.com/_next/image?url=https%3A%2F%2Fimages.ctfassets.net%2F0dkgxhks0leg%2FRKiZ605RAV8kjDQnxFCWP%2Fb03b8729817c90b29b88d536bfd37ac5%2F9-Unusual-Uses-For-Potatoes.jpg%3Ffm%3Dwebp&w=1920&q=75';
                    } else {
                        $imgUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQPGKN_bB6lSckokG1pLxLktnGpIIvGsoaL6A&s';
                    }
                   
                @endphp

                <article class="premium-card" style="opacity: {{ $product['status'] === 'active' ? '1' : '0.8' }};">
                    <div>
                        <div style="width: 100%; height: 180px; overflow: hidden; border-radius: 12px; margin-bottom: 18px; position: relative; background: #f1f5f9;">
                            <img src="{{ $imgUrl }}" alt="{{ $product['crop_name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0) 60%, rgba(0,0,0,0.1) 100%);"></div>
                        </div>

                        <div class="product-meta" style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                            <span class="pill" style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">📍 {{ $product['region'] }}</span>
                            @if($product['status'] === 'active')
                                <span class="pill blue" style="background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">🟢 Live Market</span>
                            @else
                                <span class="pill gold" style="background: #fef3c7; color: #b45309; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">⚠️ {{ ucfirst(str_replace('_', ' ', $product['status'])) }}</span>
                            @endif
                        </div>

                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.4px;">{{ $product['crop_name'] }}</h2>
                        <p class="muted" style="font-size: 0.95rem; color: #3b82f6; font-weight: 600; margin: 0 0 16px 0;">{{ $product['quantity'] }} {{ $product['unit'] }} registered</p>

                        @if(!empty($product['description']))
                            <p style="font-size: 0.9rem; color: #64748b; font-style: italic; margin-bottom: 20px; line-height: 1.5;">
                                "{{ $product['description'] }}"
                            </p>
                        @endif
                    </div>

                    <div>
                        <div style="display: flex; align-items: baseline; gap: 6px; background: #f8fafc; padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <span class="price" style="font-size: 1.5rem; font-weight: 800; color: #334155;">Rs {{ number_format($product['price'], 2) }}</span>
                            <span class="muted" style="font-size: 0.85rem; color: #64748b; font-weight: 600;">/ {{ $product['unit'] }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 16px; color: #64748b; font-size: 1.1rem; font-weight: 500;">
                     You haven't initialized any marketplace listings yet.
                </div>
            @endforelse
        </div>
    </section>

    <section style="margin-top: 72px; padding-top: 32px; border-top: 1px solid #e2e8f0;">
        <div class="page-head" style="margin-bottom: 24px;">
            <div>
                <p class="eyebrow" style="text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: #ef4444; margin-bottom: 6px; font-size: 0.75rem;">Fulfillment pipeline</p>
                <h2 style="font-size: 1.6rem; font-weight: 700; color: #1e293b; margin: 0;">Orders received</h2>
            </div>
        </div>
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);">
            @include('partials.orders-table', ['orders' => $orders, 'mode' => 'seller'])
        </div>
    </section>
@endsection

