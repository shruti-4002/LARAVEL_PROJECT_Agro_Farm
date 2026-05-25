<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MandiPriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class BuyerController extends Controller
{
    public function marketplace(MandiPriceService $mandi): View
    {
        return view('buyer.marketplace', [
            'products' => Product::active(),
            'orders' => Order::forBuyer(session('user._id')),
            'mandiRows' => $mandi->rows(session('user.region')),
        ]);
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

        return back()->with('status', 'Order placed. The farmer can now see it in incoming orders.');
    }
}
