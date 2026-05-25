@extends('layouts.app')

@section('title', 'Add Product - AgriMandi')

@section('content')
    <style>
       
        .market-header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .header-profile-block {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .farmer-profile-container {
            position: relative;
            display: inline-block;
        }

        .farmer-profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #10b981;
            padding: 3px;
            background: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
            object-fit: cover;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        }

        .farmer-profile-avatar:hover {
            transform: scale(1.1) rotate(2deg);
            box-shadow: 0 12px 20px -3px rgba(16, 185, 129, 0.35);
        }

        .online-indicator {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 14px;
            height: 14px;
            background-color: #10b981;
            border: 2.5px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

    
        .form-split-wrapper {
            display: flex;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.04);
            max-width: 1050px;
            margin-top: 24px;
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .form-image-sidebar {
            flex: 1.1;
            background: linear-gradient(to bottom, rgba(6, 95, 70, 0.2) 20%, rgba(6, 95, 70, 0.9) 100%), 
                        url('https://www.shutterstock.com/shutterstock/videos/1105891919/thumb/1.jpg') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: #ffffff;
            position: relative;
        }

        .form-body-content {
            flex: 1.3;
            padding: 44px;
            background: #ffffff;
        }

        /* Premium Form Fields */
        .premium-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 22px;
        }

        .premium-field label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.75px;
        }

        .premium-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #0f172a;
            background: #f8fafc;
            box-sizing: border-box;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
            background: #ffffff;
            transform: translateY(-1px);
        }

       
        .publish-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 13px 32px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
            transition: all 0.25s ease;
        }

        .publish-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            filter: brightness(1.05);
        }

        .cancel-btn {
            padding: 13px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            background: #ffffff;
            color: #64748b;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            text-align: center;
            transition: all 0.25s ease;
        }

        .cancel-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #334155;
            transform: translateY(-1px);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 850px) {
            .market-header-flex {
                flex-direction: column-reverse;
                align-items: flex-start;
                gap: 16px;
            }
            .form-split-wrapper {
                flex-direction: column;
            }
            .form-image-sidebar {
                min-height: 220px;
                padding: 30px;
            }
            .form-body-content {
                padding: 32px 24px;
            }
        }
    </style>

 
    <div class="market-header-flex">
        <div>
            <p class="eyebrow" style="text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: #10b981; margin-bottom: 6px; font-size: 0.75rem;">HEY USER</p>
            <h1 style="font-size: 2.3rem; font-weight: 800; letter-spacing: -0.75px; color: #0f172a; margin: 0;">Sell Crops at Best Price</h1>
        </div>
        <div class="header-profile-block">
            <div class="farmer-profile-container">
                <img class="farmer-profile-avatar" src="https://t3.ftcdn.net/jpg/19/39/14/92/360_F_1939149216_67SwYQVGfMWDx0tfpFAsn2B7KK8VZXsd.jpg" alt="Farmer Profile">
                <span class="online-indicator"></span>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="form-split-wrapper">
        
        <div class="form-image-sidebar">
            <div style="position: absolute; top: 30px; left: 30px; background: rgba(255,255,255,0.18); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px; border: 1px solid rgba(255,255,255,0.25);">
                🌱 Live Mandi Engine
            </div>
            <div>
                <h3 style="font-size: 1.8rem; font-weight: 700; margin: 0 0 8px 0; line-height: 1.2; letter-spacing: -0.5px;">Turn harvest into active revenue</h3>
                <p style="font-size: 0.95rem; color: #cbd5e1; margin: 0; line-height: 1.4; font-weight: 400;">Your stock details will update instantly on the decentralized market array for verified agro-buyers.</p>
            </div>
        </div>

        <div class="form-body-content">
            <form method="post" action="{{ route('farmer.products.store') }}" style="margin: 0;">
                @csrf
                
                <div class="grid two" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div class="premium-field">
                        <label for="crop_name">Select Crop</label>
                        <select class="premium-input select" id="crop_name" name="crop_name" required style="appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23475569%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center; background-size: 16px; padding-right: 40px;">
                            @foreach($crops as $crop)
                                <option value="{{ $crop['name'] }}" @selected(old('crop_name') === $crop['name'])>{{ $crop['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="premium-field">
                        <label for="region">Target Region</label>
                        <select class="premium-input select" id="region" name="region" required style="appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23475569%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center; background-size: 16px; padding-right: 40px;">
                            @foreach($regions as $region)
                                <option value="{{ $region }}" @selected(old('region', session('user.region')) === $region)>{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid three" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 16px; margin-top: 4px;">
                    <div class="premium-field">
                        <label for="quantity">Quantity</label>
                        <input class="premium-input input" id="quantity" name="quantity" type="number" min="0.1" step="0.1" value="{{ old('quantity') }}" required placeholder="0.0">
                    </div>
                    <div class="premium-field">
                        <label for="unit">Unit Metric</label>
                        <select class="premium-input select" id="unit" name="unit" required style="appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23475569%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center; background-size: 16px; padding-right: 40px;">
                            <option value="quintal" @selected(old('unit') === 'quintal')>quintal</option>
                            <option value="tonne" @selected(old('unit') === 'tonne')>tonne</option>
                            <option value="kg" @selected(old('unit') === 'kg')>kg</option>
                        </select>
                    </div>
                    <div class="premium-field">
                        <label for="price">Price (per unit)</label>
                        <div style="position: relative; width: 100%;">
                            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 0.95rem; font-weight: 600; color: #64748b;">₹</span>
                            <input class="premium-input input" id="price" name="price" type="number" min="1" step="0.01" value="{{ old('price') }}" required placeholder="0.00" style="padding-left: 28px;">
                        </div>
                    </div>
                </div>

                <div class="premium-field" style="margin-top: 4px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline;">
                        <label for="description">Additional Notes</label>
                        <span style="font-size: 0.68rem; color: #94a3b8; font-weight: 600; letter-spacing: 0.25px;">Max 240 chars</span>
                    </div>
                    <textarea class="premium-input textarea" id="description" name="description" maxlength="240" rows="3" placeholder="Describe quality parameter specifics, grain dampness level or direct harvest batch metrics..." style="resize: none; font-family: inherit; line-height: 1.5;"></textarea>
                </div>

                <div class="actions" style="display: flex; gap: 14px; align-items: center; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                    <button class="publish-btn" type="submit">Publish Listing</button>
                    <a class="cancel-btn" href="{{ route('farmer.marketplace') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>
@endsection