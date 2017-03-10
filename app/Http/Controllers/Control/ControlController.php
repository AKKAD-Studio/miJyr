<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Providers\UseradminServiceProvider;
use App\Providers\UsermailServiceProvider;
use Illuminate\Support\Facades\Input;
use DB;

class ControlController extends Controller {

    protected $request;

    public function __construct(\Illuminate\Http\Request $request) {
        $this->request = $request;
    }

    public function index() {
        $user = json_decode($this->request->user());
        if ($user->status < 5) {
            return redirect('/');
        }else if ($user->status < 50) {
            return redirect('/user');
        }else if ($user->status >= 50) {
            return redirect('/admin_panel');
        }
    }




    ////////////////////////////////////////////////////////////////////////////////////////////////

    public function mandrill($args) {
        $curl     = curl_init('https://mandrillapp.com/api/1.0/messages/send.json');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
        $response = curl_exec($curl);
        return $response;
    }


    //Генератор случайных комбинаций знаков
    function generate_password($number) {
        $arr  = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $pass  .= $arr[$index];
        }
        return $pass;
    }


}
