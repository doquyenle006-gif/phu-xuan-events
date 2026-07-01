<?php

namespace App\Models;
<<<<<<< HEAD
use App\Models\User;
use App\Models\Category;
use App\Models\Registration;
use App\Models\Tag;
=======

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'capacity',
        'status',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'string',
    ];

    /* ======================
        RELATIONSHIPS
    ====================== */

<<<<<<< HEAD
    public function user(): BelongsTo
=======
    public function user()
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
=======
    public function category()
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4
    {
        return $this->belongsTo(Category::class);
    }

<<<<<<< HEAD
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function tags(): BelongsToMany
    {
=======
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function tags()
    {
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4
        return $this->belongsToMany(Tag::class, 'event_tag');
    }

    /* ======================
        SCOPES
    ====================== */

<<<<<<< HEAD
    public function scopePublished(Builder $query): Builder
=======
    public function scopePublished($query)
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4
    {
        return $query->where('status', 'published');
    }

<<<<<<< HEAD
    public function scopeUpcoming(Builder $query): Builder
=======
    public function scopeUpcoming($query)
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4
    {
        return $query->where('start_time', '>=', now());
    }

<<<<<<< HEAD
    public function scopeByCategory(Builder $query, int $categoryId): Builder
=======
    public function scopeByCategory($query, $categoryId)
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4
    {
        return $query->where('category_id', $categoryId);
    }

    /* ======================
        ACCESSOR
    ====================== */

    public function getIsFullAttribute(): bool
    {
        return $this->registrations()->count() >= $this->capacity;
    }
}