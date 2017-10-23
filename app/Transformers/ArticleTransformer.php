<?php

namespace App\Transformers;

use App\Model\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'tags',
        'category'
    ];

    public function transform(Article $article) {
        return [
            'id'                => $article->id,
            'title'             => $article->title,
            'subtitle'          => $article->subtitle,
            'user'              => $article->user,
            'slug'              => $article->slug,
            'content'           => $article->content['raw'],
            'page_image'        => $article->page_image,
            'meta_description'  => $article->meta_description,
            'is_original'       => $article->is_original,
            'is_draft'          => $article->is_draft,
            'visitors'          => $article->view_count,
            'published_at'      => $article->published_at->diffForHumans(),
            'published_time'    => $article->published_at->toDateTimeString(),
        ];
    }

    public function includeCategory(Article $article)
    {
        $category = $article->category;
        return $this->item($category, new CategoryTransformer);
    }


    public function includeTags(Article $article)
    {
        $tags = $article->tags;

        return $this->collection($tags, new TagTransformer);
    }
}