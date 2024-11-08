<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'file_path',
    ];

    public function tags()
    {
    return $this->belongsToMany(Tag::class);
    }

}
