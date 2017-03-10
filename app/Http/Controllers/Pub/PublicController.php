<?php

namespace App\Http\Controllers\Pub;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PublicController extends Controller {

    protected $request;

    public function __construct(\Illuminate\Http\Request $request) {
        $this->request = $request;
    }

    public function index() {

      return view('pub.index');

   }

   public function home() {
      return redirect('/');
   }

}
