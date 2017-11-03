<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = "categories";
    protected $dates = ['deleted_at'];
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
