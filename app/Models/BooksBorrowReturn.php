<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BooksBorrowReturn extends Model
{
    protected $table = 'books_borrow_return';

    protected $fillable = [
        'transaction_id',
        'book_id',
        'member_id',
        'borrowed_date',
        'returned_date',
        'return_promised_date',
        'remarks',
    ];

    // auto generate transaction_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($BooksBorrowReturn) {
            $BooksBorrowReturn->transaction_id = 'TRANS-' . now()->format('YmdHis') . '-' . Str::random(4);
        });
    }

    // Relationships

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id');
    }

}
