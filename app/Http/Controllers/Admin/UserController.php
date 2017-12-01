<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->user->page('10', 'desc');
        return view('admin.user', compact('data'));
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
    public function store(AddUserRequest $request)
    {
        $data = $request->all();
        $data['status']        = isset($data['status']);
        $data['is_admin']      = isset($data['is_admin']);
        $data['email_notify']  = isset($data['email_notify']);
        $data['password']      = password_hash($data['password'], PASSWORD_BCRYPT);
        $res = $this->user->store($data);
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
        $data = $this->user->getById($id);
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
        $data = $request->all();
        if ($id == 1 && Auth::user()->id !== 1) abort(422, '超级管理员信息不能修改');
        $da = DB::table('users')->where('id', '!=', $id)->where('name',$data['name'])->first();
        if ($da) return abort(422, '用户名已存在');
        $data['status']        = isset($data['status']);
        $data['is_admin']      = isset($data['is_admin']);
        $data['email_notify']  = isset($data['email_notify']);
        if ($data['password']) {
            $data['password']      = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $res = $this->user->update($id, $data);
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
        if ($id == 1) abort(422, '超级管理员不能删除');
        $res = $this->user->destroy($id);
        return custom_json($res);
    }
}
