<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'in_progress', 'completed'];

    protected $fillable = ['title', 'description', 'status', 'due_date'];

    protected $attributes = ['status' => 'pending'];

    protected function casts(): array
    {
        return ['due_date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
