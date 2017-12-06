<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    protected $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->tag->page(10, 'desc', 'id');
        return view('admin.tag')->with(compact('data'));
    }

    /**
     * 获取全部标签
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        return $this->tag->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $res = $this->tag->store($request->all());
        if ($res) {
            Cache::forget('home-tag');
        }
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
        //
        $data = $this->tag->getById($id);
        return custom_json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->get('title') == null) abort(422, '标题必填');
        $res = $this->tag->update($id, $request->except('tag'));
        if ($res) {
            Cache::forget('home-tag');
        }
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
        //
        $res = $this->tag->destroy($id);
        if ($res) {
            Cache::forget('home-tag');
        }
        return custom_json($res);
    }
}
