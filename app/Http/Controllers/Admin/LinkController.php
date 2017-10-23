<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LinkRequest;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    protected $link;
    public function __construct(LinkRepository $link)
    {
        $this->link = $link;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->link->page(10, 'desc', 'id');
        return view('admin.link')->with(compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $request)
    {
        $file = $request->file('image');
        if ($file && $file->isValid()) {
            $path = app('App\Tools\ImgUpload')->imgUpload($file);
            $data = array_merge($request->all(),[
                'image' => $path,
            ]);
        } else {
            $data = $request->all();
        }
        $data['status'] = isset($data['status']);
        $res = $this->link->store($data);
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
        $data = $this->link->getById($id);
        return custom_json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LinkRequest $request, $id)
    {
        $file = $request->file('image');
        if ($file && $file->isValid()) {
            $path = app('App\Tools\ImgUpload')->imgUpload($file);
            $data = array_merge($request->all(),[
                'image' => $path,
            ]);
        } else {
            $data = $request->all();
        }
        $data['status'] = isset($data['status']);
        $res = $this->link->update($id, $data);
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
        $res = $this->link->destroy($id);
        return custom_json($res);
    }
}
