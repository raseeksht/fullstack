<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // polymophic many to many relationship between Blog and (future upcomming model may be article,videos etc) and Tag
    public function posts()
    {
        return $this->morphedByMany(Blog::class, 'taggable');
    }
}
