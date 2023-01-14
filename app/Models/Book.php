<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $with = ['categories'];   

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
