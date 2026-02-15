<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Members extends Model
{
    // Table name
    protected $table = 'members';

    // Mass assignable fields
    protected $fillable = [
        'member_id',
        'member_cover_img',
        'member_name',
        'member_nic_type',
        'member_nic_number',
        'member_dob',
        'member_added',
        'member_email',
        'member_tel',
        'member_address',
        'member_remarks',
    ];

    // auto generate member_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            $member->member_id = 'MEMBER-' . now()->format('YmdHis') . '-' . Str::random(4);
        });
    }

    public function borrowRecords()
    {
        return $this->hasMany(BooksBorrowReturn::class);
    }

}
