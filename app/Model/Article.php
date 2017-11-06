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
        'is_recommend',
        'sort',
        'flag',
    ];

    protected $casts = [
        'content'    =>    'array'
    ];

    /**
     * 不是草稿的文章
     * @param $query
     * @return mixed
     */
    public function scopeDraft($query)
    {
        return $query->where('is_draft', '0');
    }

    /**
     * 已经发布的文章
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<', Carbon::now());
    }

    /**
     * 是推荐的文章
     * @param $query
     * @return mixed
     */
    public function scopeRecommend($query)
    {
        return $query->where('is_recommend', '1');
    }
    /**
     * Get the user for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get the comments for the discussion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

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
        if (isset($this->attributes['id'])) {
            $info = $this->where('id', $this->attributes['id'])->first();
            if ($info->title == $value) {
                return;
            }
        }
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
//    public function setContentAttribute($value)
//    {
//        $data = [
//            'raw'  => $value,
//            'html' => (new Markdowner)->convertMarkdownToHtml($value)
//        ];
//        $this->attributes['content'] = json_encode($data);
//    }
}
