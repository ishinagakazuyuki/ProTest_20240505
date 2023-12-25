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
        'genre',
        'overview',
    ];

    public function scopeTextSearch($query, $text)
    {
        if (!empty($text)) {
            $query->where('name', '=',  $text );
        }
    }

    public function favorites()
    {
        return $this->hasMany(Comment::class);
    }

    public function reservations()
    {
        return $this->hasMany(Comment::class);
    }

    public function owners()
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Comment::class);
    }
}
