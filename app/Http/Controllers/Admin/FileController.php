<?php

namespace App\Http\Controllers\Admin;

use App\Tools\BaseManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    protected $manager;
    public function __construct(BaseManager $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        $data = $this->manager->folderInfo($request->get('folder'));
        return view('admin.file', compact('data'));
    }

    public function createFolder(Request $request)
    {
        $folder = $request->get('folder');
        $data = Storage::makeDirectory($folder);
        dd($data);
    }
}
