<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Pet;
use Illuminate\Http\Request;

class ActivityLogService
{
    public static function log(
        ?int $userId,
        string $action,
        ?Pet $pet = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $status = null,
        ?Request $request = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id'    => $userId,
            'pet_id'     => $pet?->id,
            'action'     => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'status'     => $status,
            'ip_address' => $request?->ip() ?? request()?->ip(),
        ]);
    }

    /**
     * Запись логирования при создании объявления
     */
    public static function logCreate(Pet $pet, Request $request = null): ActivityLog
    {
        return self::log(
            auth()->id(),
            'created',
            $pet,
            null,
            $pet->only(['name', 'type', 'category_id', 'phone', 'location']),
            null,
            $request
        );
    }

    /**
     * Запись логирования при изменении объявления
     */
    public static function logUpdate(Pet $pet, array $oldData, Request $request = null): ActivityLog
    {
        return self::log(
            auth()->id(),
            'updated',
            $pet,
            $oldData,
            $pet->only(['name', 'type', 'category_id', 'phone', 'location', 'status']),
            null,
            $request
        );
    }

    /**
     * Запись логирования при удалении объявления
     */
    public static function logDelete(Pet $pet, Request $request = null): ActivityLog
    {
        return self::log(
            auth()->id(),
            'deleted',
            $pet,
            $pet->only(['name', 'type', 'category_id', 'phone', 'location']),
            null,
            null,
            $request
        );
    }

    /**
     * Запись логирования при модерации объявления
     */
    public static function logModerate(Pet $pet, string $status, ?string $reason = null, Request $request = null): ActivityLog
    {
        return self::log(
            auth()->id(),
            'moderated',
            $pet,
            ['previous_status' => $pet->status],
            ['status' => $status, 'reason' => $reason],
            $status,
            $request
        );
    }
}
