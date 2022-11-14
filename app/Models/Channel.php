<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];
    use HasFactory;

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
