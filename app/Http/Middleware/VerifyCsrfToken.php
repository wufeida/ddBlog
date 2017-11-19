<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    //TODO:暂时关闭评论csrf
    protected $except = [
        '/dd/file/upload',
        '/home/comment'
    ];
}
