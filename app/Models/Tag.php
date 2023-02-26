<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    use HasFactory;

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lastUserUpdated()
    {
        return $this->belongsTo(User::class, 'last_user_updated_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
