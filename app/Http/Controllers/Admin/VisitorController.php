<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\VisitorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    protected $visitor;

    public function __construct(VisitorRepository $visitor)
    {
        $this->visitor = $visitor;
    }

    public function index()
    {
        $data = $this->visitor->page('10', 'desc', 'id');
        return view('admin.visitor')->with(compact('data'));
    }
}
