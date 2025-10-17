<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_url',
        'custom_code',
        'clicks'
    ];


    public function getCodeAttribute()
    {
        return $this->attributes['custom_code'];
    }
    protected $appends = ['code'];
    protected $hidden = ['custom_code'];
}
