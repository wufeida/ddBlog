<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = [
        'parent_id', 'name', 'path', 'description', 'image_url'
    ];
}
