<?php

namespace App\Tools;

use Carbon\Carbon;
use App\Exceptions\UploadException;
use Illuminate\Support\Facades\Storage;
use Dflydev\ApacheMimeTypes\PhpRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseManager
{
    /**
     * @var $disk
     */
    protected $disk;

    /**
     * @var PhpRepository $mimeDetect
     */
    protected $mimeDetect;

    /**
     * UploadManager constructor.
     * @param PhpRepository $mimeDetect
     */
    public function __construct()
    {
        $this->disk = Storage::disk(config('filesystems.default', 'public'));
    }

    /**
     * 获取文件夹信息
     *
     * @param $folder
     * @return array
     */
    public function folderInfo($folder)
    {
        $folder = $this->cleanFolder($folder);

        $breadcrumbs = $this->breadcrumbs($folder);
        $slice = array_slice($breadcrumbs, -1);
        $folderName = current($slice);
        $breadcrumbs = array_slice($breadcrumbs, 0, -1);

        $subfolders = $this->getSubfolderList($folder);

        $files = $this->getFileList($folder);

        return compact([
            'folder',
            'folderName',
            'breadcrumbs',
            'subfolders',
            'files'
        ]);
    }

    /**
     * 通过文件夹获取子文件夹
     * 
     * @param  string $folder
     * @return array
     */
    public function getSubfolderList($folder)
    {
        $subfolders = [];
        foreach (array_unique($this->disk->directories($folder)) as $subfolder) {
            $subfolders["/$subfolder"] = basename($subfolder);
        }

        return $subfolders;
    }

    /**
     * 通过文件夹获取全部的文件
     * 
     * @param  string $folder
     * @return array
     */
    public function getFileList($folder)
    {
        $files = [];

        $filesContent = $this->disk->files($folder);

        foreach ($filesContent as $file) {
            $files[] = $this->fileDetail($file);
        }

        return $files;
    }

    /**
     * Clean the folder.
     *
     * @param $folder
     * @return string
     */
    public function cleanFolder($folder)
    {
        return '/' . trim(str_replace('..', '', $folder), '/'); //eq: ../../uploads
    }

    /**
     * 返回当前目录路径.
     *
     * @param $folder
     * @return array
     */
    public function breadcrumbs($folder)
    {
        $folder = trim($folder, '/'); //eq: /post_img/2016/10/01/

        $crumbs = ['/' => 'root'];

        if (empty($folder)) return $crumbs;

        $folders = explode('/', $folder); // eq: ['post_img', '2016', '10', '01']
        $build = '';
        foreach ($folders as $folder)
        {
            $build .= '/' . $folder;
            $crumbs[$build] = $folder;
        }

        return $crumbs;
    }

    /**
     * 返回文件详细信息数组
     *
     * @param $path
     * @return array
     */
    public function fileDetail($path)
    {
        $path = '/' . trim($path, '/');

        return [
            'name' => basename($path),
            'fullPath' => $path,
            'webPath'  => $this->fileWebPath($path),
            'mimeType' => $this->fileMimeType($path),
            'size'     => $this->fileSize($path),
            'modified' => $this->fileModified($path)
        ];
    }

    /**
     * 返回文件完整的web路径
     *
     * @param $path
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function fileWebPath($path)
    {
        return asset("storage/" . ltrim($path, '/'));
    }

    /**
     * 返回文件MIME类型
     *
     * @param $path
     * @return mixed|null|string
     */
    public function fileMimeType($path)
    {
        return (new PhpRepository())->findType(
            pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    /**
     * 返回文件大小
     *
     * @param $path
     * @return mixed
     */
    public function fileSize($path)
    {
        return human_filesize($this->disk->size($path));
    }

    /**
     * 返回最后修改时间.
     *
     * @param $path
     * @return string
     */
    public function fileModified($path)
    {
        return Carbon::createFromTimestamp(
            substr($this->disk->lastModified($path), 0, 10)
        )->toDateTimeString();
    }

    /**
     * 创建文件夹
     *
     * @param $folder
     * @return string
     */
    public function createFolder($folder)
    {
        $this->cleanFolder($folder);

        if ($this->checkFolder($folder)) {
            throw new UploadException("文件夹已存在");
        }

        return $this->disk->makeDirectory($folder);
    }

    /**
     * 检测文件夹是否存在
     *
     * @param $folder
     * @return mixed
     */
    public function checkFolder($folder)
    {
        return $this->disk->exists($folder);
    }

    /**
     * 文件上传
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param string                                              $dir
     * @param string                                              $name
     *
     * @return array|bool
     */
    public function store(UploadedFile $file, $dir = '', $name = '')
    {
        $hashName = empty($name)
                    ? str_ireplace('.jpeg', '.jpg', $file->hashName())
                    : $name;

        $mime = $file->getMimeType();

        $realPath = $this->disk->putFileAs($dir, $file, $hashName);

        return [
                'success' => true,
                'filename' => $hashName,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $mime,
                'size' => human_filesize($file->getClientSize()),
                'real_path' => $realPath,
                'relative_url' => "storage/$realPath",
                'url' => asset("storage/$realPath"),
        ];
    }

    /**
     * 检测文件是否存在
     * 
     * @param  string $path
     * @return boolean
     */
    public function checkFile($path)
    {
        return $this->disk->exists($path);
    }

    /**
     * 删除文件夹
     *
     * @param $folder
     * @return string
     */
    public function deleteFolder($folder)
    {
        $this->cleanFolder($folder);

        $filesFolders = array_merge(
            $this->disk->directories($folder),
            $this->disk->files($folder)
        );

        if (!empty($filesFolders)) {
            return false;
        }

        return $this->disk->deleteDirectory($folder);
    }

    /**
     * 删除文件
     *
     * @param $path
     * @return mixed
     */
    public function deleteFile($path)
    {
        $this->cleanFolder($path);

        return $this->disk->delete($path);
    }
}