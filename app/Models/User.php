<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\FCM;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function fcm_token(): HasOne
    {
        return $this->hasOne(FCM::class);
    }

    public function scopeFilter($query)
    {
        $search = request()->input('search');
        $order_by = request()->input('order_by'); // 'asc' or 'desc'
        $reject = request()->input('reject'); // true or false

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        }

        if ($order_by) {
            $query->orderBy('id', $order_by);
        }

        if ($reject !== null) {
            $rejectValue = filter_var($reject, FILTER_VALIDATE_BOOLEAN);
            if ($rejectValue) {
                $query->onlyTrashed();
            } else {
                $query->withTrashed();
            }
        }
    }
}
