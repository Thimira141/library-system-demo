<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    // Table name (optional if it matches plural of model name)
    protected $table = 'books';

    // Mass assignable fields
    protected $fillable = [
        'book_id',
        'book_cover_img',
        'book_title',
        'book_author',
        'book_added',
        'book_remarks',
    ];

    // Auto-generate book_id before insert
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            $book->book_id = 'BOOK-' . now()->format('YmdHis') . '-' . Str::random(4);
        });
    }

    // Relationship: many-to-many with categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }
}
