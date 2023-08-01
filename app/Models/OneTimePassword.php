<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OneTimePassword extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'code', 'status', 'user_id', 'expiration_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
