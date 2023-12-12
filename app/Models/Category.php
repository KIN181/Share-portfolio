<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    # To get the number of categories for each post
    # To get the posts under a category
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }
}
