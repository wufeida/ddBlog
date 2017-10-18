<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriesRequest;
use App\Http\Controllers\Controller;
use App\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{
    protected $categories;
    public function __construct(CategoriesRepository $categories)
    {
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->categories->page(10,'desc','id');
        return view('admin.categories')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
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
        $res = $this->categories->store($data);
        return custom_json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data = $this->categories->getById($id);
        return custom_json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, $id)
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
        $res = $this->categories->update($id, $data);
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
        $res = $this->categories->destroy($id);
        return custom_json($res);
    }
}
