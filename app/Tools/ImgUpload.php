<?php

namespace App\Tools;

class ImgUpload
{
    protected $size = 1048576;
    protected $filetype = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
    protected $path;

    public function __construct()
    {
        $this->path = '/upload/'.date('Ymd')."/";
    }

    public function imgUpload($file)
    {
        $clientName = $file->getClientOriginalName();
        $entension = $file->getClientOriginalExtension();
        $mimeTye = $file->getMimeType();
        $filesize = $file->getSize();
        $newName = md5($clientName) . rand(1, 999) . "." . $entension;
        if (!in_array($mimeTye, $this->filetype)) {
            abort('422', '图片类型不符');
        }
        if ($filesize > $this->size) {
            abort('422', '图片不能超过1M');
        }
        $info = $file->move(public_path() . $this->path, $newName);
        $path = $this->path . $newName;
        return $path;
    }
}