<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OneTimePassword extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'code', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
