<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    //
    protected $table = "tags";

    protected $primaryKey = "id";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tag', 'title', 'subtitle', 'meta_description'
    ];

    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }


    public function discussions()
    {
        return $this->morphedByMany(Discussion::class, 'taggable');
    }
}
