<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = [
        'parent_id', 'name', 'path', 'description', 'image_url'
    ];

    /**
     * 每个分类多个文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::Class);
    }
}
