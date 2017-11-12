<?php

namespace App\Http\Controllers\Admin;

use App\Tools\BaseManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    protected $manager;
    public function __construct(BaseManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 首页显示文件夹及文件所有信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $this->manager->folderInfo($request->get('folder'));
        return view('admin.file', compact('data'));
    }

    /**
     * 上传文件
     *
     * @param Request $request
     * @return mixed
     *
     */
    public function uploadForManager(Request $request)
    {
        $files = $request->file('file');
        foreach ($files as $file) {
            $fileName = $request->get('name')
                ? $request->get('name').'.'.explode('/', $file->getClientMimeType())[1]
                : $file->getClientOriginalName();

            $path = str_finish($request->get('folder'), '/');

            if ($this->manager->checkFile($path.$fileName)) {
                $result[] = $fileName.'文件已存在';
                continue;
            }

            $result[] = $this->manager->store($file, $path, $fileName);
        }

        return custom_json($result);
    }
    /**
     * 创建文件夹
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFolder(Request $request)
    {
        $folder = $request->get('folder');
        if ($folder == false) abort('422', '文件夹名称必填');
        $data = $this->manager->createFolder($folder);
        return custom_json($data);
    }

    /**
     * 删除文件夹
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFolder(Request $request)
    {
        $folder = $request->get('folder');
        $info = $this->manager->checkFolder($folder);
        if (!$info) abort('422', '该文件夹不存在');
        $data = $this->manager->deleteFolder($folder);
        if (!$data) abort('422', '请清空该文件夹后重试');
        return custom_json($data);
    }

    /**
     * 删除文件
     *
     * @param Request $request
     * @return mixed
     */
    public function deleteFile(Request $request)
    {
        $path = $request->get('path');
        $info = $this->manager->checkFile($path);
        if (!$info) abort('422', '该文件不存在');
        $data = $this->manager->deleteFile($path);
        return custom_json($data);
    }
}
