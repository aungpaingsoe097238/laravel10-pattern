<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['full_url', 'size', 'file_name', 'user_id', 'mime_type', 'disk_type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query)
    {
        $search = request()->input('search');
        $order_by = request()->input('order_by'); // 'asc' or 'desc'

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($order_by) {
            $query->orderBy('id', $order_by);
        }
    }
}
