<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'name',
        'description',
        'phone',
        'telegram',
        'location',
        'incident_date',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        return Storage::disk('public')->url($this->image);
    }

    public function isLost(): bool
    {
        return $this->type === 'lost';
    }

    public function isFound(): bool
    {
        return $this->type === 'found';
    }

    public function typeLabel(): string
    {
        return $this->type === 'lost' ? 'Yo\'qolgan' : 'Topilgan';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'available' => 'Faol',
            'pending' => 'Jarayonda',
            'resolved' => 'Yopiq',
            default => ucfirst((string) $this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'available' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'resolved' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the category that owns the pet.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
