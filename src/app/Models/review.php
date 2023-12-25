<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shops_id',
        'review',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function shop()
    {
        return $this->belongsTo(shop::class);
    }
}
