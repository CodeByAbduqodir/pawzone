<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Admin: всё видит
            $pets   = Pet::with('category', 'user')->latest()->get();
            $orders = Order::with('pet', 'user')->latest()->get();

            $stats = [
                'total_pets'      => Pet::count(),
                'available'       => Pet::where('status', 'available')->count(),
                'pending'         => Pet::where('status', 'pending')->count(),
                'resolved'        => Pet::where('status', 'resolved')->count(),
                'total_orders'    => Order::count(),
            ];
        } else {
            // Обычный пользователь: только свои питомцы и заказы
            $pets   = $user->pets()->with('category')->latest()->get();
            $orders = $user->orders()->with('pet')->latest()->get();

            $stats = [
                'total_pets'   => $pets->count(),
                'available'    => $pets->where('status', 'available')->count(),
                'pending'      => $pets->where('status', 'pending')->count(),
                'resolved'     => $pets->where('status', 'resolved')->count(),
                'total_orders' => $orders->count(),
            ];
        }

        return view('dashboard', compact('pets', 'orders', 'stats'));
    }
}
