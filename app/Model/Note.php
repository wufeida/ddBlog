<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $table = "notes";

    protected $primaryKey = "id";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'content', 'status'
    ];
}
