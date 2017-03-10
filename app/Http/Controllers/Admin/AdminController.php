<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\UseradminServiceProvider;
use App\Providers\UsermailServiceProvider;
use Illuminate\Support\Facades\Input;
use DB;

class AdminController extends Controller {

    protected $request;

    public function __construct(\Illuminate\Http\Request $request) {
        $this->request = $request;
    }

    public function index() {
        $user = json_decode($this->request->user());
        if ($user->status < 50) {
            return redirect('/user');
        }


        return view('admin.index');
    }




    ////////////////////////////////////////////////////////////////////////////////////////////////




}
