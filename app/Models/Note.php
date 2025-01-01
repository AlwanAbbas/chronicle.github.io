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
        'user_id'
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    public function user() {
        return $this->belongsTo(User::class); // Asumsi bahwa User adalah model yang mengelola data pengguna
    }


}
