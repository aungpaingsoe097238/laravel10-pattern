<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

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
