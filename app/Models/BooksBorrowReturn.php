<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksBorrowReturn extends Model
{
    protected $table = 'books_borrow_return';

    protected $fillable = [
        'book_id',
        'member_id',
        'borrowed_date',
        'returned_date',
        'return_promised_date',
        'remarks',
    ];

    // Relationships

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Members::class);
    }

}
