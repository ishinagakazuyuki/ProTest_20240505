<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'area',
        'genres_id',
        'overview',
        'image',
    ];

    public function scopeTextSearch($query, $text)
    {
        if (!empty($text)) {
            $query->where('name', '=',  $text );
        }
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
