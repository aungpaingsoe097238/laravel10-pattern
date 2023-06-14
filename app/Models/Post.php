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

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['search'])) {
            $query->where('title', 'LIKE', "%{$filter['search']}%");
        }

        if (isset($filter['category_id'])) {
            $query->where('category_id', $filter['category_id']);
        }

        if (isset($filter['from_date'])) {
            if (isset($filter['to_date'])) {
                $query->whereBetween('created_at', [$filter['from_date'], $filter['to_date']]);
            } else {
                $query->whereDate('created_at', $filter['from_date']);
            }
        }
        
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
