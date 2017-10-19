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

    protected $dates = ['delete_at'];

    protected $fillable = [
        'tag', 'title', 'subtitle', 'meta_description'
    ];

}
