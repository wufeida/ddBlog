<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'default_icon',
        'water_status',
        'water_text',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'article_title',
        'article_description',
        'article_number',
        'article_sort',
        'article_sortColumn',
        'footer_github_status',
        'footer_github_url',
        'footer_qq_status',
        'footer_qq_url',
        'license',
        'icp'
    ];

    protected $casts = [
        'water_status' => 'boolean',
        'footer_github_status' => 'boolean',
        'footer_qq_status' => 'boolean',
    ];
}
