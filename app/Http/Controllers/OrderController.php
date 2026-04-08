<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($pet, $validated) {
            $lockedPet = Pet::whereKey($pet->id)->lockForUpdate()->firstOrFail();

            if ($lockedPet->status !== 'available') {
                throw ValidationException::withMessages([
                    'pet' => 'Uzr, bu hayvon allaqachon band qilingan!',
                ]);
            }

            Order::create([
                'user_id' => auth()->id(),
                'pet_id' => $lockedPet->id,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'status' => 'new',
            ]);

            $lockedPet->update(['status' => 'pending']);
        });

        return redirect()->back()->with('success', '✅ Buyurtmangiz qabul qilindi! Tez orada aloqa qilamiz.');
    }
}
