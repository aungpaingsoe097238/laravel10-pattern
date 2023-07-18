<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['full_url', 'size', 'file_name', 'user_id', 'mime_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
