<?php

namespace App\Model;

use App\Tools\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type', 'content', 'pid'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'content'    =>    'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function commentable()
    {
        return $this->morphTo();
    }


    public function setContentAttribute($value)
    {
        $data = [
            'raw'  => $value,
            'html' => (new Markdowner)->convertMarkdownToHtml($value)
        ];

        $this->attributes['content'] = json_encode($data);
    }
}
