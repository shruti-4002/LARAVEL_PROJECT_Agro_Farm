@extends('layouts.app')

@section('title', 'Farmer Dashboard - AgriMandi')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap');

        .neon-mandi-fullscreen-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            background-color: #fafdfb; 
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            padding: 24px 32px; 
            box-sizing: border-box;

            background-image: 
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.05), transparent 500px),
                radial-gradient(circle at bottom left, rgba(0, 255, 135, 0.04), transparent 600px),
                linear-gradient(rgba(226, 232, 240, 0.3) 1px, transparent 1px),
                linear-gradient(90deg, rgba(226, 232, 240, 0.3) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 28px 28px, 28px 28px;
        }

       
        .tech-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(16, 185, 129, 0.12);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01), inset 0 1px 1px rgba(255, 255, 255, 0.9);
            padding: 20px 22px; /* Balanced spacing */
            position: relative;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .tech-card:hover {
            transform: translateY(-2px);
            border-color: #10b981;
            box-shadow: 0 12px 24px -10px rgba(16, 185, 129, 0.12);
        }

     
        .premium-dashboard-stat {
            background: #ffffff;
            border: 1px solid #f0fdf4;
            border-radius: 16px;
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px -5px rgba(16, 185, 129, 0.03);
            transition: all 0.3s ease;
        }

        .stat-highlight-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
        }

        .premium-dashboard-stat:hover {
            transform: translateY(-3px);
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 12px 20px -8px rgba(16, 185, 129, 0.1);
        }

        .neon-stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .stat-label-box {
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ecfdf5;
            color: #10b981;
            font-size: 0.95rem;
            margin-bottom: 12px;
        }

      
        .terminal-window-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(16, 185, 129, 0.15);
        }

        .terminal-dots { display: flex; gap: 5px; }
        .terminal-dot { width: 8px; height: 8px; border-radius: 50%; background-color: #e2e8f0; }
        .terminal-dot.red { background-color: #ef4444; }
        .terminal-dot.yellow { background-color: #f59e0b; }
        .terminal-dot.green { background-color: #10b981; }

        .terminal-sys-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            color: #10b981;
            font-weight: 600;
            background: #ecfdf5;
            padding: 1px 6px;
            border-radius: 4px;
        }

        .tech-headline-main { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }
        .tech-headline-sub { font-family: 'Inter', sans-serif; font-weight: 500; color: #64748b; font-size: 0.92rem; }
        
        .tech-eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: #10b981;
            background-color: #ecfdf5;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(16, 185, 129, 0.15);
            margin-bottom: 8px;
        }

        .side-by-side-charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 24px;
        }

        .dashboard-split-columns {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 24px;
            margin-top: 24px;
            align-items: start;
        }

       
        .tech-btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tech-btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }

        .tech-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
        }

        .tech-btn-secondary {
            background: #ffffff;
            color: #334155 !important;
            border: 1.5px solid #e2e8f0;
        }

        .custom-filter-select {
            padding: 9px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: #1e293b;
            outline: none;
            min-width: 200px;
        }
/
        .ledger-table-wrapper {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }

        .tech-ledger-row {
            border-bottom: 1px solid #f1f5f9;
            padding: 12px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }
        
        .tech-ledger-row:hover {
            background: rgba(240, 253, 244, 0.5);
            transform: translateX(2px);
        }

        .neon-badge {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.15);
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.68rem;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
        }

        .neon-pulse-dot {
            width: 6px;
            height: 6px;
            background-color: #00ff87;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 6px #00ff87;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>

    <div class="neon-mandi-fullscreen-wrapper">
        
        <div class="page-head" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="position: absolute; bottom: -1px; left: 0; width: 60px; height: 3px; background-color: #10b981; border-radius: 3px;"></div>
            <div>
                <span class="tech-eyebrow"><span class="neon-pulse-dot"></span> SECURE MANDI NODE</span>
                <h1 class="tech-headline-main" style="font-size: 2.1rem; margin: 2px 0 4px 0; line-height: 1.2;">Farmer Dashboard</h1>
                <p class="tech-headline-sub" style="margin: 0;">System throughput, active regional metrics, and catalog ledger trends.</p>
            </div>
            <div class="actions" style="display: flex; gap: 10px; align-items: center;">
                <a class="tech-btn tech-btn-primary" href="{{ route('farmer.products.create') }}">Add Product</a>
                <a class="tech-btn tech-btn-secondary" href="{{ route('farmer.advisor') }}">Ask Advisor</a>
            </div>
        </div>

        <section class="grid four" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
            <div class="premium-dashboard-stat">
                <span class="stat-highlight-line" style="background: linear-gradient(90deg, #10b981, #00ff87);"></span>
                <div class="stat-icon-wrap"><i class="fa-solid fa-wallet"></i></div>
                <div class="neon-stat-value">Rs {{ number_format($summary['total_sales'], 0) }}</div>
                <div class="stat-label-box">Total Sales Tally</div>
            </div>
            <div class="premium-dashboard-stat">
                <span class="stat-highlight-line" style="background: linear-gradient(90deg, #3b82f6, #60a5fa);"></span>
                <div class="stat-icon-wrap" style="background-color: #eff6ff; color: #3b82f6;"><i class="fa-solid fa-receipt"></i></div>
                <div class="neon-stat-value" style="color: #1e3a8a;">{{ $summary['order_count'] }}</div>
                <div class="stat-label-box">Orders Confirmed</div>
            </div>
            <div class="premium-dashboard-stat">
                <span class="stat-highlight-line" style="background: linear-gradient(90deg, #8b5cf6, #a78bfa);"></span>
                <div class="stat-icon-wrap" style="background-color: #f5f3ff; color: #8b5cf6;"><i class="fa-solid fa-cubes"></i></div>
                <div class="neon-stat-value" style="color: #4c1d95;">{{ number_format($summary['units_sold'], 1) }}</div>
                <div class="stat-label-box">Volume Dispatched</div>
            </div>
            <div class="premium-dashboard-stat">
                <span class="stat-highlight-line" style="background: linear-gradient(90deg, #059669, #00ff87);"></span>
                <div class="stat-icon-wrap" style="background-color: #ecfdf5; color: #059669;"><i class="fa-solid fa-box-open"></i></div>
                <div class="neon-stat-value" style="color: #064e3b;">{{ count($products) }}</div>
                <div class="stat-label-box">Active Listings</div>
            </div>
        </section>

        <section class="side-by-side-charts-grid">
            
            <div class="tech-card">
                <div class="terminal-window-header">
                    <div class="terminal-dots">
                        <span class="terminal-dot red"></span>
                        <span class="terminal-dot yellow"></span>
                        <span class="terminal-dot green"></span>
                    </div>
                    <span class="terminal-sys-label">VOLUME_DISTRIBUTION.LOG</span>
                </div>
                <div style="margin-bottom: 14px;">
                    <p class="tech-eyebrow" style="margin-bottom: 2px;">SYSTEM METRIC CORE</p>
                    <h2 class="tech-headline-main" style="font-size: 1.15rem; margin: 0;">Commodity Performance</h2>
                </div>
                
                @if(count($summary['by_crop']))
                    <div style="width: 100%; height: 260px; position: relative;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                @else
                    <div class="empty" style="text-align: center; padding: 50px 20px; color: #64748b; border: 1.5px dashed #cbd5e1; background-color: #ffffff; border-radius: 12px; font-size: 0.9rem; font-style: italic;">
                        No network actions cataloged on this terminal node yet.
                    </div>
                @endif
            </div>

            <div class="tech-card">
                <div class="terminal-window-header">
                    <div class="terminal-dots">
                        <span class="terminal-dot red"></span>
                        <span class="terminal-dot yellow"></span>
                        <span class="terminal-dot green"></span>
                    </div>
                    <span class="terminal-sys-label">MARKET_TIMELINE_INDEX.LOG</span>
                </div>
                <div style="margin-bottom: 14px;">
                    <p class="tech-eyebrow" style="color: #3b82f6; background-color: #eff6ff; border-color: rgba(59, 130, 246, 0.15); margin-bottom: 2px;">PRICE INDEX TELEMETRY</p>
                    <h2 class="tech-headline-main" style="font-size: 1.15rem; margin: 0;">Market Price Indices</h2>
                </div>
                
                @if(count($crops))
                    <div style="width: 100%; height: 260px; position: relative;">
                        <canvas id="seededCropsLineChart"></canvas>
                    </div>
                @else
                    <div class="empty" style="text-align: center; padding: 50px 20px; color: #64748b; border: 1.5px dashed #cbd5e1; background-color: #ffffff; border-radius: 12px; font-size: 0.9rem; font-style: italic;">
                        Insufficient price seed arrays to compile timeline model graphs.
                    </div>
                @endif
            </div>
        </section>

        <section class="dashboard-split-columns">
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <div class="tech-card" style="padding: 18px 0 0 0;">
                    <div style="padding: 0 20px 14px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                        <div>
                            <p class="tech-eyebrow" style="margin-bottom: 2px;">GEOGRAPHIC METRICS</p>
                            <h2 class="tech-headline-main" style="font-size: 1.15rem; margin: 0;">Local Prices</h2>
                        </div>
                        <form method="get" action="{{ route('farmer.dashboard') }}" style="display: flex; gap: 8px; align-items: center;">
                            <select class="custom-filter-select" name="region" style="padding: 6px 12px; font-size: 0.8rem; min-width: 160px;">
                                <option value="">All Regions</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region }}" @selected($selectedRegion === $region)>{{ $region }}</option>
                                @endforeach
                            </select>
                            <button class="tech-btn tech-btn-secondary" type="submit" style="padding: 7px 14px; font-size: 0.7rem;">Filter</button>
                        </form>
                    </div>
                    <div class="ledger-table-wrapper">
                        @include('partials.mandi-table', ['rows' => $mandiRows])
                    </div>
                </div>

                <div class="tech-card" style="padding: 18px 0 0 0;">
                    <div style="padding: 0 20px 14px 20px; border-bottom: 1px solid #f1f5f9;">
                        <p class="tech-eyebrow" style="color: #ef4444; background-color: #fef2f2; border-color: rgba(239, 68, 68, 0.15); margin-bottom: 2px;">DEMAND CONTRACT PORT</p>
                        <h2 class="tech-headline-main" style="font-size: 1.15rem; margin: 0;">Orders Received</h2>
                    </div>
                    <div class="ledger-table-wrapper">
                        @include('partials.orders-table', ['orders' => $orders, 'mode' => 'seller'])
                    </div>
                </div>
            </div>

            <aside class="tech-card" style="position: sticky; top: 20px;">
                <p class="tech-eyebrow" style="color: #8b5cf6; background-color: #f5f3ff; border-color: rgba(139, 92, 246, 0.15); margin-bottom: 4px;">NODE_INVENTORY.CFG</p>
                <h2 class="tech-headline-main" style="font-size: 1.15rem; margin: 0 0 12px 0;">Stock Summary</h2>
                
                <div class="custom-scrollbar" style="max-height: 480px; overflow-y: auto; padding-right: 4px;">
                    @forelse($products as $product)
                        <div class="tech-ledger-row">
                            <div>
                                <strong style="color: #0f172a; font-size: 0.88rem; display: block; margin-bottom: 1px;">{{ $product['crop_name'] }}</strong>
                                <span style="font-size: 0.78rem; color: #64748b; font-weight: 500;">{{ $product['quantity'] }} {{ $product['unit'] }} allocated</span>
                            </div>
                            <div style="font-weight: 700; color: #10b981; font-size: 0.88rem; background: #ecfdf5; padding: 4px 10px; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.15);">
                                ₹{{ number_format($product['price'], 2) }}
                            </div>
                        </div>
                    @empty
                        <div class="empty" style="text-align: center; padding: 40px 10px; color: #64748b; font-size: 0.85rem; font-style: italic; border: 1px dashed #e2e8f0; border-radius: 8px;">
                            No operational inventory in registry.
                        </div>
                    @endforelse
                </div>
            </aside>
        </section>

        <section style="margin-top: 36px; padding-bottom: 20px;">
            <div style="margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                <p class="tech-eyebrow" style="margin-bottom: 2px;">NODE COMPLIANCE VALUES</p>
                <h2 class="tech-headline-main" style="font-size: 1.25rem; margin: 0;">Seeded Crop Indices</h2>
            </div>
            
            <div class="grid three" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 18px;">
                @foreach($crops as $crop)
                    <article class="tech-card" style="padding: 16px 18px;">
                        <div style="display: flex; gap: 6px; margin-bottom: 10px;">
                            <span class="neon-badge">{{ $crop['category'] }}</span>
                            <span style="background: #eef7ff; color: #2b6cb0; border: 1px solid #bee3f8; padding: 2px 8px; border-radius: 4px; font-size: 0.68rem; font-weight: 700;">{{ $crop['season'] }}</span>
                        </div>
                        <h3 style="font-size: 1.1rem; stroke-width: 1px; font-weight: 800; color: #0f172a; margin: 0 0 10px 0; border-bottom: 1px dashed #e2e8f0; padding-bottom: 6px;">{{ $crop['name'] }}</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            @foreach(array_slice($crop['local_prices'] ?? [], 0, 3) as $price)
                                <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 500;">📍 {{ $price['region'] }}</span>
                                    <strong style="font-size: 0.88rem; color: #10b981; font-weight: 700;">Rs {{ number_format($price['price'], 0) }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // --- MODULE 1: BAR CHART ---
            @if(count($summary['by_crop']))
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const rawCropData = @json($summary['by_crop']);
                
                const barGradient = revenueCtx.createLinearGradient(0, 0, 0, 260);
                barGradient.addColorStop(0, '#00ff87');
                barGradient.addColorStop(1, '#10b981');

                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: rawCropData.map(item => item.crop),
                        datasets: [{
                            label: 'Yield (Rs)',
                            data: rawCropData.map(item => item.revenue),
                            backgroundColor: barGradient,
                            borderColor: '#10b981',
                            borderWidth: 1,
                            borderRadius: 4,
                            maxBarThickness: 24
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleColor: '#00ff87',
                                bodyColor: '#ffffff',
                                padding: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) { return ' Rs ' + context.parsed.y.toLocaleString(); }
                                }
                            }
                        },
                        scales: {
                            x: { ticks: { color: '#64748b', font: { family: 'Plus Jakarta Sans', weight: '600', size: 9 } }, grid: { display: false } },
                            y: { ticks: { color: '#64748b', font: { family: 'Inter', size: 10 } }, grid: { color: 'rgba(16, 185, 129, 0.05)' } }
                        }
                    }
                });
            @endif

          
            @if(count($crops))
                const lineChartCtx = document.getElementById('seededCropsLineChart').getContext('2d');
                const rawSeededCrops = @json($crops);

                const lineLabels = rawSeededCrops.map(item => item.name);
                const lineDataValues = rawSeededCrops.map(item => {
                    if (item.local_prices && item.local_prices.length > 0) {
                        const total = item.local_prices.reduce((sum, p) => sum + parseFloat(p.price), 0);
                        return Math.round(total / item.local_prices.length);
                    }
                    return 0;
                });

                const systemGradient = lineChartCtx.createLinearGradient(0, 0, 0, 260);
                systemGradient.addColorStop(0, 'rgba(0, 255, 135, 0.12)');
                systemGradient.addColorStop(1, 'rgba(16, 185, 129, 0.00)');

                new Chart(lineChartCtx, {
                    type: 'line',
                    data: {
                        labels: lineLabels,
                        datasets: [{
                            label: 'Avg Model Rate (Rs)',
                            data: lineDataValues,
                            borderColor: '#10b981', 
                            borderWidth: 2.5,
                            fill: true,
                            backgroundColor: systemGradient,
                            tension: 0.3,
                            pointBackgroundColor: '#00ff87',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleColor: '#00ff87',
                                bodyColor: '#ffffff',
                                padding: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) { return ' Rs ' + context.parsed.y.toLocaleString() + ' (Avg)'; }
                                }
                            }
                        },
                        scales: {
                            x: { ticks: { color: '#64748b', font: { family: 'Plus Jakarta Sans', weight: '600', size: 9 } }, grid: { display: false } },
                            y: { ticks: { color: '#64748b', font: { family: 'Inter', size: 10 } }, grid: { color: 'rgba(16, 185, 129, 0.05)' } }
                        }
                    }
                });
            @endif
        });
    </script>
@endsection