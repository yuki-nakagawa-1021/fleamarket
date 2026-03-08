<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Comment;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'name',
        'brand_name',
        'description',
        'price',
        'condition',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item')->withTimestamps();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    public function getImageUrlAttribute()
    {
        $path = $this->image_path;

        if (!$path) return '';

        if (Str::startsWith($path, ['http://', 'https://']))
        {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
    public function is_liked_by_auth_user()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}