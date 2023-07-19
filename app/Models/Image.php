<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['full_url', 'size', 'file_name', 'user_id', 'mime_type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
