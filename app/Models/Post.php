<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'description', 'image_id'];

    /**
     * Get the category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the post's image.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Filter 
     */
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
}
