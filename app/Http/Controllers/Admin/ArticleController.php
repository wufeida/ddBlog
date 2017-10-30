<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{

    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->article->page('10', 'desc');
        if ($data) {
            foreach ($data as $v) {
                $v->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans();
            }
        }
        return view('admin.article')->with(compact('data'));
    }

    public function create()
    {
        $categories = app(CategoryController::class)->getList();
        $tags = app(TagController::class)->getList();
        return view('admin.article-form')->with(compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        if ($request->get('tag') == 'null') abort('422', '标签必填');
        $formData = $request->all();
        $file = $request->file('page_image');
        if ($file && $file->isValid()) {
            $path = app('App\Tools\ImgUpload')->imgUpload($file);
            $formData['page_image'] = $path;
        }
        //
        $data = array_merge($formData, [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);
        $data['is_draft']    = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);

        $res = $this->article->store($data);
        $tags = explode(',', $request->get('tag'));
        $this->article->syncTag($tags);
        return custom_json($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->article->getByIdWith($id);
        $categories = app(CategoryController::class)->getList();
        $tags = app(TagController::class)->getList();
        return view('admin.article-form')->with(compact('data', 'categories', 'tags', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        if ($request->get('tag') == 'null') abort('422', '标签必填');
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id()
        ]);
        $data['is_draft']    = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);
        $file = $request->file('page_image');
        if ($file && $file->isValid()) {
            $path = app('App\Tools\ImgUpload')->imgUpload($file);
            $data['page_image'] = $path;
        }
        $res = $this->article->update($id, $data);
        $tags = explode(',', $request->get('tag'));
        $this->article->syncTag($tags);
        return custom_json($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->article->destroy($id);
        return custom_json($res);
    }
}
