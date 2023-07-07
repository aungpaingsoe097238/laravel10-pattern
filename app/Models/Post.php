<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id'];

    public function scopeFilter($query)
    {
        $search = request()->input('search');
        $category_id = request()->input('category_id');
        $from_date = request()->input('from_date');
        $to_date = request()->input('to_date');
        $order_by = request()->input('order_by'); // 'asc' or 'desc'

        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($from_date) {
            if ($to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            } else {
                $query->whereDate('created_at', $from_date);
            }
        }

        if ($order_by) {
            $query->orderBy('id', $order_by);
        }

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
