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
    ];

    public function scopeTextSearch($query, $text)
    {
        if (!empty($text)) {
            $query->where('name', '=',  $text );
        }
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function shops()
    {
        return $this->belongsTo(Shop::class);
    }
}
