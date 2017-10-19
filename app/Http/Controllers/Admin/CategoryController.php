<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->category->page(10,'desc','id');
        return view('admin.category')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //
        $file = $request->file('image');
        if ($file && $file->isValid()) {
            $path = app('App\Tools\ImgUpload')->imgUpload($file);
            $data = array_merge($request->all(),[
                'image_url' => $path,
            ]);
        } else {
            $data = $request->all();
        }
        $res = $this->category->store($data);
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
        $data = $this->category->getById($id);
        return custom_json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //
        $file = $request->file('image');
        if ($file && $file->isValid()) {
            $path = app('App\Tools\ImgUpload')->imgUpload($file);
            $data = array_merge($request->all(),[
                'image_url' => $path,
            ]);
        } else {
            $data = $request->all();
        }
        $res = $this->category->update($id, $data);
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
        $res = $this->category->destroy($id);
        return custom_json($res);
    }
}