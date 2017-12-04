<?php

namespace App\Http\Controllers\Admin;

use App\Tools\BaseManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class FileController extends Controller
{
    protected $manager;
    protected $config;
    public function __construct(BaseManager $manager, ConfigController $config)
    {
        $this->manager = $manager;
        $this->config = $config->getConfig();
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
     * 上传文件到管理文件
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
     * 上传文件
     *
     * @param ImageRequest $request
     * @return mixed
     */
    public function fileUpload(Request $request)
    {
        $strategy = $request->get('folder', 'images');

        if (!$request->hasFile('file')) {
            abort('422', '请上传图片');
        }

        $path = $strategy . '/' . date('Y') . '/' . date('m') . '/' . date('d');

        $result = $this->manager->store($request->file('file'), $path);
        // 添加水印
        if ($result['success'] == true && $this->config->water_status) {
            $this->water_text($result['relative_url'], $this->config->water_text);
        }
        return custom_json($result);
    }

    public function water_text($file, $text, $color = '#10D07A') {
        $image = Image::make($file);
        $image->text($text, $image->width()-20, $image->height()-30, function($font) use($color) {
            $font->file(public_path('fonts/msyh.ttf'));
            $font->size(12);
            $font->color($color);
            $font->align('right');
            $font->valign('bottom');
        });
        $image->save($file);
        return $image;
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
