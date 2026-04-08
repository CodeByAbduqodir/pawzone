<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pet;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Pet::with('category')->latest();

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Фильтр по локации
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        match ($request->get('sort')) {
            'oldest'        => $query->reorder('created_at', 'asc'),
            'incident_desc' => $query->reorder('incident_date', 'desc'),
            'location_asc'  => $query->reorder('location', 'asc'),
            'location_desc' => $query->reorder('location', 'desc'),
            default         => null,
        };

        $pets = $query->get();

        // Список уникальных локаций для фильтра
        $locations = Pet::whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->sort()
            ->values();

        return view('pets.index', compact('pets', 'categories', 'locations'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'          => 'required|in:lost,found',
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'phone'         => 'required|string|max:20',
            'telegram'      => 'nullable|string|max:100',
            'location'      => 'nullable|string|max:255',
            'incident_date' => 'nullable|date',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Проверка лимитов — только активные объявления (available + pending)
        $userListingsCount = Pet::where('user_id', auth()->id())
            ->whereIn('status', ['available', 'pending'])
            ->count();
        $maxListings = config('pets.max_listings_per_user', 5);

        if ($userListingsCount >= $maxListings) {
            return redirect()->back()
                ->withErrors(['listings' => "Siz maksimal {$maxListings} ta aktiv e'lon joylashtirasiz."])
                ->withInput();
        }

        // Проверка дневного лимита
        $dailyListings = Pet::where('user_id', auth()->id())
            ->whereDate('created_at', now()->toDateString())
            ->count();
        $maxPerDay = config('pets.max_listings_per_day', 3);

        if ($dailyListings >= $maxPerDay) {
            return redirect()->back()
                ->withErrors(['daily_limit' => "Bugun siz {$maxPerDay} ta e'lon joylashtirgansiz. Ertaga qaytib urinib ko'ring."])
                ->withInput();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/pets', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status']  = 'available';

        $pet = Pet::create($validated);

        // Логируем создание
        ActivityLogService::logCreate($pet, $request);

        return redirect()->route('dashboard')->with('success', 'E\'lon muvaffaqiyatli joylashtirildi! 🎉');
    }

    public function show(Pet $pet)
    {
        return view('pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        // Только владелец или admin может редактировать
        if (!auth()->user()->isAdmin() && $pet->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('pets.edit', compact('pet', 'categories'));
    }

    public function update(Request $request, Pet $pet)
    {
        if (!auth()->user()->isAdmin() && $pet->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type'          => 'required|in:lost,found',
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'phone'         => 'required|string|max:20',
            'telegram'      => 'nullable|string|max:100',
            'location'      => 'nullable|string|max:255',
            'incident_date' => 'nullable|date',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'        => 'required|in:available,pending,resolved',
        ]);

        if ($request->hasFile('image')) {
            if ($pet->image && Storage::disk('public')->exists($pet->image)) {
                Storage::disk('public')->delete($pet->image);
            }
            $validated['image'] = $request->file('image')->store('images/pets', 'public');
        }

        // Сохраняем старые значения перед обновлением
        $oldData = $pet->only(['name', 'type', 'category_id', 'phone', 'location', 'status']);

        $pet->update($validated);

        // Логируем обновление
        ActivityLogService::logUpdate($pet, $oldData, $request);

        return redirect()->route('dashboard')->with('success', 'E\'lon muvaffaqiyatli yangilandi!');
    }

    public function destroy(Pet $pet)
    {
        if (!auth()->user()->isAdmin() && $pet->user_id !== auth()->id()) {
            abort(403);
        }

        if ($pet->image && Storage::disk('public')->exists($pet->image)) {
            Storage::disk('public')->delete($pet->image);
        }

        // Логируем удаление перед удалением
        ActivityLogService::logDelete($pet);

        $pet->delete();

        return redirect()->route('dashboard')->with('success', 'E\'lon o\'chirildi.');
    }
}
