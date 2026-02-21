<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Pet;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard — статистика и управление
     */
    public function dashboard(Request $request)
    {
        // Статистика
        $stats = [
            'total'     => Pet::count(),
            'active'    => Pet::where('status', 'available')->count(),
            'pending'   => Pet::where('status', 'pending')->count(),
            'closed'    => Pet::where('status', 'sold')->count(),
            'lost'      => Pet::where('type', 'lost')->count(),
            'found'     => Pet::where('type', 'found')->count(),
        ];

        // Объявления для управления с фильтрацией
        $query = Pet::with('user', 'category')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $pets = $query->paginate(15);

        // Последние действия
        $recentActions = ActivityLog::with('user', 'pet')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'pets', 'recentActions'));
    }

    /**
     * Модерация — одобрение/отклонение объявления
     */
    public function moderate(Request $request, Pet $pet)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reason' => 'nullable|string|max:500',
        ]);

        $status = $request->action === 'approve' ? 'available' : 'pending';
        $oldStatus = $pet->status;

        $pet->update(['status' => $status]);

        // Логируем модерацию
        ActivityLogService::logModerate($pet, $status, $request->reason, $request);

        $message = $request->action === 'approve'
            ? "E'lon ✅ tasdiqlandi!"
            : "E'lon ❌ rad etildi.";

        return redirect()->route('admin.dashboard')
            ->with('success', $message);
    }

    /**
     * Audit Log — просмотр всех действий
     */
    public function auditLog(Request $request)
    {
        $query = ActivityLog::with('user', 'pet')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $logs = $query->paginate(20);

        return view('admin.audit-log', compact('logs'));
    }

    /**
     * Удалить объявление (администратор)
     */
    public function deletePet(Pet $pet)
    {
        ActivityLogService::logDelete($pet);
        $pet->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', "E'lon o'chirildi.");
    }
}

