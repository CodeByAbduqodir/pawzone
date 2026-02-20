<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pet;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, Pet $pet)
    {
        if ($pet->status !== 'available') {
            return redirect()->back()->with('error', 'Uzr, bu hayvon allaqachon band qilingan!');
        }
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);
        Order::create([
            'user_id' => auth()->id(),
            'pet_id' => $pet->id,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'status' => 'new',
        ]);
        $pet->update(['status' => 'pending']);
        return redirect()->back()->with('success', '✅ Buyurtmangiz qabul qilindi! Tez orada aloqa qilamiz.');
    }
}
