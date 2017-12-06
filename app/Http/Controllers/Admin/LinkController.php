<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LinkRequest;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
        $data = $this->link->getAll();
        return view('admin.link')->with(compact('data'));
    }

    public function sort(Request $request)
    {
        $info = array_filter($request->get('data'));
        foreach ($info as $k=>$v) {
            $data['sort'] = $k;
            $res = $this->link->update($v, $data);
        }
        Cache::forget('home-link');
        if ($res) return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $request)
    {
        $data = $request->all();
        $data['status'] = isset($data['status']);
        $res = $this->link->store($data);
        if ($res) {
            Cache::forget('home-link');
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
        $data = $request->all();
        $data['status'] = isset($data['status']);
        $res = $this->link->update($id, $data);
        if ($res) {
            Cache::forget('home-link');
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
        $res = $this->link->destroy($id);
        if ($res) {
            Cache::forget('home-link');
        }
        return custom_json($res);
    }
}
