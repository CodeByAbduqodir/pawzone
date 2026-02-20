<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('category')->latest()->get();
        $categories = Category::all();
        return view('pets.index', compact('pets', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,pending,sold',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/pets', 'public');
            $validated['image'] = $imagePath;
        }
        $validated['user_id'] = auth()->id();
        Pet::create($validated);
        return redirect()->route('dashboard')->with('success', 'Hayvon muvaffaqiyatli qo\'shildi!');
    }

    public function show(Pet $pet)
    {
        return view('pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        $categories = Category::all();
        return view('pets.edit', compact('pet', 'categories'));
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,sold',
        ]);
        if ($request->hasFile('image')) {
            if ($pet->image && Storage::disk('public')->exists($pet->image)) {
                Storage::disk('public')->delete($pet->image);
            }
            $imagePath = $request->file('image')->store('images/pets', 'public');
            $validated['image'] = $imagePath;
        }
        $pet->update($validated);
        return redirect()->route('dashboard')->with('success', 'Hayvon muvaffaqiyatli yangilandi!');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->image && Storage::disk('public')->exists($pet->image)) {
            Storage::disk('public')->delete($pet->image);
        }
        $pet->delete();
        return redirect()->route('dashboard')->with('success', 'Hayvon muvaffaqiyatli o\'chirildi!');
    }
}
