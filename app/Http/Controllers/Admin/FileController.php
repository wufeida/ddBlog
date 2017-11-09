<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $url = Storage::disk('public')->url('1.jpg');
        $files = Storage::files('/');
        $folders = Storage::directories('/');
        dd($url,$files,$folders);
        return view('admin.file');
    }

    public function createFolder(Request $request)
    {
        $folder = $request->get('folder');
        $data = Storage::makeDirectory($folder);
        dd($data);
    }
}
