<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts'; //name of table in database is "posts"
    protected $guarded = []; // needed for factory, allow everything to be massfilled/nothing is guarded

    protected $fillable = [];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->slug = Str::slug($post->name);
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
