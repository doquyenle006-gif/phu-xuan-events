<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'capacity',
        'status',
        'user_id',
        'category_id'
    ];

    // ✅ FIX 1: category relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ FIX 2: tags relationship
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}