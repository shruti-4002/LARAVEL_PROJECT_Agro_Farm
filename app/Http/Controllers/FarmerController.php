<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Order;
use App\Models\Product;
use App\Services\MandiPriceService;
use App\Services\OpenAiAdvisor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class FarmerController extends Controller
{
    public function marketplace(): View
    {
        $farmer = session('user');

        return view('farmer.marketplace', [
            'ownProducts' => Product::byFarmer($farmer['_id']),
            'otherProducts' => Product::othersForFarmer($farmer['_id']),
            'orders' => Order::forSeller($farmer['_id']),
        ]);
    }

    public function dashboard(Request $request, MandiPriceService $mandi): View
    {
        $farmer = session('user');
        $region = $request->query('region', $farmer['region'] ?? '');

        return view('farmer.dashboard', [
            'products' => Product::byFarmer($farmer['_id']),
            'orders' => Order::forSeller($farmer['_id']),
            'summary' => Order::salesSummary($farmer['_id']),
            'regions' => Crop::regions(),
            'selectedRegion' => $region,
            'mandiRows' => $mandi->rows($region),
            'crops' => Crop::all(),
        ]);
    }

    public function createProduct(): View
    {
        // 1. Fetch crops from DB; if collection is empty, use a reliable fallback array
        $crops = Crop::all();
        if (empty($crops)) {
            $crops = [
                ['name' => 'Wheat'],
                ['name' => 'Mustard'],
                ['name' => 'Onion'],
                ['name' => 'Soybean'],
                ['name' => 'Potato'],
                ['name' => 'Cotton']
            ];
        }

        // 2. Fetch regions from DB; if collection is empty, use a reliable fallback array
        $regions = Crop::regions();
        if (empty($regions)) {
            $regions = [
                'Punjab',
                'Haryana',
                'Uttar Pradesh',
                'Gujarat',
                'Madhya Pradesh',
                'Maharashtra',
                'Rajasthan'
            ];
        }

        return view('farmer.products.create', compact('crops', 'regions'));
    }
    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'crop_name' => ['required', 'string', 'max:80'],
            'region' => ['required', 'string', 'max:80'],
            'quantity' => ['required', 'numeric', 'min:0.1'],
            'unit' => ['required', 'string', 'max:30'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:240'],
        ]);

        try {
            Product::create($data, session('user'));
        } catch (RuntimeException $exception) {
            return back()->withErrors(['crop_name' => $exception->getMessage()])->withInput();
        }

        return redirect()->route('farmer.marketplace')->with('status', 'Product added to the marketplace.');
    }

    public function order(Request $request, string $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'numeric', 'min:0.1'],
        ]);

        try {
            Order::place($product, session('user'), (float) $data['quantity']);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['quantity' => $exception->getMessage()]);
        }

        return back()->with('status', 'Order placed. The selling farmer will see it in incoming orders.');
    }

    public function chat(): View
    {
        return view('farmer.chat', [
            'messages' => session('farmer_chat', []),
        ]);
    }

    public function askAdvisor(Request $request, OpenAiAdvisor $advisor, MandiPriceService $mandi): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:800'],
        ]);

        $farmer = session('user');
        $history = session('farmer_chat', []);
        $history[] = ['role' => 'farmer', 'text' => $data['message']];

        try {
            $reply = $advisor->ask(
                $data['message'],
                $farmer,
                $mandi->rows($farmer['region'] ?? null),
                Product::byFarmer($farmer['_id'])
            );
        } catch (RuntimeException $exception) {
            $reply = $exception->getMessage();
        }

        $history[] = ['role' => 'advisor', 'text' => $reply];
        session(['farmer_chat' => array_slice($history, -12)]);

        return back();
    }
}
