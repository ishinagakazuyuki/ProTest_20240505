<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shops_id',
        'fav_flg',
    ];

    public function scopeTextSearch($query, $text)
    {
        if (!empty($text)) {
            $query->where('name', '=',  $text );
        }
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function shop()
    {
        return $this->belongsTo(shop::class);
    }
}
