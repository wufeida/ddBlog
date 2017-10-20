<?php

namespace App\Model;

use App\Tools\Markdowner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';

    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'last_user_id',
        'category_id',
        'title',
        'subtitle',
        'slug',
        'page_image',
        'content',
        'meta_description',
        'is_draft',
        'is_original',
        'published_at',
    ];

//    protected $casts = [
//        'content'    =>    'array'
//    ];

    /**
     * Get the created at attribute.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }
    /**
     * Set the title and the readable slug.
     *
     * @param string $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (!config('services.youdao.appKey') || !config('services.youdao.appSecret')) {
            $this->setUniqueSlug($value, str_random(5));
        } else {
            $this->setUniqueSlug(translug($value), '');
        }
    }

    /**
     * Set the unique slug.
     *
     * @param $value
     * @param $extra
     */
    public function setUniqueSlug($value, $extra) {
        $slug = str_slug($value.'-'.$extra);
        if (static::whereSlug($slug)->exists()) {
            $this->setUniqueSlug($slug, (int) $extra + 1);
            return;
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Set the content attribute.
     *
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $data = [
            'raw'  => $value,
            'html' => (new Markdowner)->convertMarkdownToHtml($value)
        ];
        $this->attributes['content'] = json_encode($data);
    }
}
