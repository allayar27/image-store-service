<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'hash',
        'size',
        'mime_type',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
