<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Providers\BaseServiceProvider;
use Hash;
use DB;

class AjaxController extends Controller {

    protected $request;

    public function __construct(\Illuminate\Http\Request $request) {
        $this->request = $request;
    }

    //Формирование таблицы и статистики
    public function index() {        
            $_lan     = 'ru';
        if(filter_input(INPUT_COOKIE, 'lang', FILTER_SANITIZE_STRING)){
            $_lan     = filter_input(INPUT_COOKIE, 'lang', FILTER_SANITIZE_STRING); 
        } 
 
        $user    = json_decode($this->request->user());
        $_m      = Input::get('m');
        if(!isset($_m) || $_m == ''){
           $_m = '01'; 
        }
        $_y      = Input::get('y');
        $Base    = new BaseServiceProvider('');
        $res     = $Base->quer('t.pred_bets<4 AND t.pred_date <=  ' . strtotime($_y . '-' . $_m . '-31 23:59:59') . ' AND t.pred_date >= ' . strtotime($_y . '-' . $_m . '-01'), $_lan);
 
        if( count($res)>0){ $results = $res; }
        else              { $results = $Base->quer('t.pred_bets<4 AND t.pred_date <=  ' . strtotime($_y . '-01-31 23:59:59') . ' AND t.pred_date >= ' . strtotime($_y . '-01-01'), $_lan);  }
         
        $resTake             = $Base->quer_actual($user, $_lan); 
        $response            = array('win' => 0, 'lost' => 0, 'return' => 0, 'bank' => '1000', 'bet_amount' => '50', 'profit' => 0,);
        $response['tabbody'] = $results;

        foreach ($results AS $b) {
            if ($b->_bets !== 0) {
                if ($b->_bets === 2) {
                    $response['lost'] ++;
                    $response['profit'] -= 50;
                } else if ($b->_bets === 1) {
                    $response['profit'] += (50 * $b->_kef) - 50;
                    $response['win'] ++;
                } else if ($b->_bets === 3) {
                    $response['return'] ++;
                    $response['profit'] += 0;
                }
            }
        }
        $result = array('his' => $response, 'actual' => $resTake);
        print json_encode($result);
    }
    //формирование месяцев в фильтре
    public function ajaxFilter() {
        $_Y    = Input::get('y');
        $Base  = new BaseServiceProvider('');
        $statF = $Base->statFiltr($_Y); 
        print json_encode($statF);
    }
    //проверка пользователя на наличие в базе
    public function chUser() {

        $_email    = Input::get('email');
        $_password = Input::get('password');

        if (preg_match('#^[A-Z0-9+_.-]+@[A-Z0-9.-]+.[A-Z0-9.-]{2,4}$#i', $_email) && $_password) {

            $results = DB::select(' SELECT *  FROM users WHERE email = ? LIMIT 1', [strip_tags(trim($_email))]);
            if (isset($results[0]->id)) {

                $hashedPassword = $results[0]->password;

                if (Hash::check($_password, $hashedPassword)) {
                    $id = $results[0]->id;
                } else {
                    $id = 0;
                }
            } else {
                $id = 0;
            }
            $resp = array('status' => $id);
            print json_encode($resp);
        }
    }
    //проверка e-mail на уникальность в базе
    public function umail() {

        $_email = Input::get('email');

        if (preg_match('#^[A-Z0-9+_.-]+@[A-Z0-9.-]+.[A-Z0-9.-]{2,4}$#i', $_email)) {
            $results = DB::select(' SELECT id  FROM users WHERE email = ? LIMIT 1', [strip_tags(trim($_email))]);
            if (isset($results[0]->id)) {
                $id = $results[0]->id;
            } else {
                $id = 0;
            }
            $resp = array('status' => $id);
            print json_encode($resp);
        }
    }
    //Получение перевода слов на нужный язык
    public function lang() { 
        $c_l= 'ru';
        if(filter_input(INPUT_COOKIE, 'lang', FILTER_SANITIZE_STRING)){
            $c_l     = filter_input(INPUT_COOKIE, 'lang', FILTER_SANITIZE_STRING); 
        }             
        
        $json       = file_get_contents('resources/lang/'.$c_l.'/words.json'); 
        $words      = json_decode($json,TRUE); 
        unset($json);  return $words;
    }
    
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Интеркасса 
    //Покупка пакета НЕ залогиненым
    public function payment() {
 
        $_name  = Input::get('name');
        $_email = Input::get('email');
        $_price = Input::get('price');
        $_promo = Input::get('promo'); 
        $id_for = Input::get('id_for');  
        
        
        if($_name =='' || $_name == ' '){ $_name = $_email; }

        if (preg_match('#^[A-Z0-9+_.-]+@[A-Z0-9.-]+.[A-Z0-9.-]{2,4}$#i', $_email) && $_price > 0 ) { 
                
            $results = DB::select(' SELECT id  FROM users WHERE email = ? LIMIT 1', [strip_tags(trim($_email))]);
            if (!isset($results[0]->id)) {
                $_password = $this->generate_password(6);
                $id        = DB::table('users')->insertGetId(array(
                    'name'           => strip_tags(trim($_name)),
                    'email'          => strip_tags(trim($_email)),
                    'password'       => Hash::make($_password),
                    'status'         => 1,
                    'remember_token' => '',
                    'updated_at'     => date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) + 3 * 60 * 60)),
                    'created_at'     => date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) + 3 * 60 * 60))
                ));
                  
                if ((int) $id > 0) {                     
                    $_html = view('mail.bayBitRegister', ['words' => $this->lang(), 'password' => $_password, 'name' => $_name, 'mail' => $_email]);
                    $args  = array(
                        'key'     => MANDRILL_KEY,
                        'message' => array("html" => '' . $_html,
                            "text"         => null,
                            "from_email"   => "support@winbets.biz",
                            "from_name"    => "Сайт WinBets",
                            "subject"      => "Ваша регистрация на WinBets",
                            "to"           => array(array("email" => $_email)),
                            "track_opens"  => true,
                            "track_clicks" => true
                        )
                    );
                    $this->mandrill($args);
                    Auth::attempt(['email' => $_email, 'password' => $_password]); 
                    
                    
                    if($id_for>0){
                        $resp = $this->formingPayUnit($id, $id_for, $_price, $_promo);
                    }else{
                        $resp = $this->formingPay($id, $_price, $_promo);
                    }
                    
                    
                }
            }else if ($results[0]->id > 0 ){  
                if($id_for>0){
                    $resp = $this->formingPayUnit($results[0]->id, $id_for, $_price, $_promo);
                }else{
                    $resp = $this->formingPay($results[0]->id, $_price, $_promo);
                } 
            } 
            print json_encode($resp);     
        }
    }
    //
    //Покупка пакета залогиненым
    public function paymentU() { 
        
        $id     = Input::get('userId');  
        $_price = Input::get('price'); 
        $_promo = Input::get('promo', ''); 
        $id_for = Input::get('id_for'); 
          
        if ($_price > 0 && $id  > 0) { 
            
            if($id_for>0){
                $resp = $this->formingPayUnit($id, $id_for, $_price, $_promo);
            }else{
                $resp = $this->formingPay($id, $_price, $_promo);
            }      
            
            print json_encode($resp);     
        }
    }  
    //
    //Создание записи о покупке пакета
    public function formingPay($id, $_price, $_promo=''){   
        $_promoID  = DB::select(' SELECT * FROM promocodes     WHERE pr_code = ?  AND date_start < ? AND date_fin > ? LIMIT 1', [$_promo, (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60), (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60) ]);     
        $pac_forec = DB::select(' SELECT * FROM pack_forecasts WHERE id_user = ' . (int) $id . ' ORDER BY date_end DESC LIMIT 1');            
        $minGame   = DB::select(' SELECT pred_date AS _date, pred_time AS _time FROM predictions WHERE pred_date   = ' . (strtotime(gmdate('Y-m-d')) +3*60*60) . ' AND pred_time  <  CURTIME()-INTERVAL 2 HOUR    LIMIT 1');
        $_toom     = false;
        if( count($minGame)>0 )            {$_toom = true;} 
        if ((int) $_price === 1000)        {$_data_end_kef = 1;} 
        elseif((int) $_price === 4000)     {$_data_end_kef = 5;} 
        elseif((int) $_price === 10000)    {$_data_end_kef = 15;} 
        elseif((int) $_price === 17000)    {$_data_end_kef = 30;}  
        if (isset($pac_forec[0]->id))      {$_h = (strtotime(gmdate('Y-m-d')) + 3 * 60 * 60) - strtotime($pac_forec[0]->date_end);}
        else                               {$_h = 0;}  
        if ($_h >= 0 && $_toom == false)   {$dat_beg = date('Y-m-d H:i:s',    (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60));}   
        elseif($_h >= 0 && $_toom == true) {$dat_beg = date('Y-m-d 00:00:00', (strtotime(gmdate('Y-m-d 00:00:00')) + 24*60*60 ));}  
        else                               {$dat_beg = date('Y-m-d H:i:s',    (strtotime($pac_forec[0]->date_end)));}  
        if(count($_promoID)>0)             {$_sale = $this->activPromo($_promoID[0]->id, $_promoID[0]->perfect, $_promoID[0]->pr_status); }
        else                               {$_sale = 0;}
                 DB::insert('INSERT INTO    pack_forecasts SET   id_user = ' . (int) $id . ',    date_pay = ?,     date_start = ?,    date_end = DATE_ADD(?, INTERVAL ' . $_data_end_kef . ' DAY),    pack_price =  ' . (int) $_price .',    status = 0, pr_sale = '.(int)$_sale, [ date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60)), $dat_beg, $dat_beg, ] );
        $idPay = DB::select('SELECT *  FROM pack_forecasts WHERE id_user = ' . (int) $id . ' AND date_pay = ?  AND date_start = ? AND date_end = DATE_ADD(?, INTERVAL ' . $_data_end_kef . ' DAY) AND pack_price =  ' . (int) $_price .' AND status = 0 LIMIT 1',                 [ date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60)), $dat_beg, $dat_beg, ] );     
        $price = $idPay[0]->pack_price - $idPay[0]->pack_price*$idPay[0]->pr_sale/100;
        $resp  = array('ik_co_id' => INTERKAS_KEY, 'ik_pm_no' => 'ID_' . $idPay[0]->id, 'price' => $price.'.00'); return $resp; 
    } 
    //
    //Создание записи о покупке отдельного прогноза
    public function formingPayUnit($_id, $_id_for, $_price, $_promo=''){   
        $_promoID  = DB::select(' SELECT * FROM promocodes  WHERE pr_code = ?  AND date_start < ? AND date_fin > ? LIMIT 1', [$_promo, (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60), (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60) ]);     
        $minGame   = DB::select(' SELECT * FROM predictions WHERE id = '.(int) $_id_for);  
        $date_game = date('Y-m-d H:i:s', $minGame[0]-> pred_date + strtotime($minGame[0]-> pred_time)-strtotime(date('Y-m-d 00:00:00')));
        
        if(count($_promoID)>0){$_sale = $this->activPromo($_promoID[0]->id, $_promoID[0]->perfect, $_promoID[0]->pr_status); }
        else                  {$_sale = 0;} 
        
                 DB::insert('INSERT INTO    sep_forecast SET   id_forec = ' . (int) $_id_for . ',    id_user = ' . (int) $_id . ',    date_pay = ?,     date_game = ?,    pack_price = ' .$_price.',    pr_sale = '.(int)$_sale, [ date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60)), $date_game, ] );
        $idPay = DB::select('SELECT *  FROM sep_forecast WHERE id_forec = ' . (int) $_id_for . ' AND id_user = ' . (int) $_id . ' AND date_pay = ? AND  date_game = ? AND pack_price = ' .$_price.' AND pr_sale = '.(int)$_sale, [ date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) +3*60*60)), $date_game, ] );     
        $price = $idPay[0]->pack_price - $idPay[0]->pack_price*$idPay[0]->pr_sale/100;
        $resp  = array('ik_co_id' => INTERKAS_KEY, 'ik_pm_no' => 'ID_' . $idPay[0]->id, 'price' => $price); return $resp; 
    }
    //
    //Проверка промокода
    public function promoCheck() {  
        $_promo      = Input::get('promo', ''); 
        $_promoID    = DB::select(' SELECT id FROM promocodes  WHERE pr_code = ? LIMIT 1', [ strip_tags(trim($_promo)) ] );  
        if( count($_promoID)>0 ){
            $_status = $_promoID[0]->id;  
        }else{
            $_status = 0;
        } 
        print json_encode( array( 'status' => $_status ) );
    } 
    //
    //Активация промокода
    public function activPromo($id, $perfect, $pr_status){ 
        $_res   = 0;
        $_promo = 0;
        if ($perfect == 0) {
            $_res = DB::update('UPDATE promocodes SET pr_status = ' . ($pr_status + 1) . '  WHERE id = ' . (int) $id . ' AND pr_status = 0');
        } elseif ($perfect == 1) {
            $_res = DB::update('UPDATE promocodes SET pr_status = ' . ($pr_status + 1) . '  WHERE id = ' . (int) $id . '');
        }
        if($_res>0){ 
            $_promoID  = DB::select(' SELECT pr_sale FROM promocodes  WHERE id = ' . (int) $id . ' LIMIT 1');     
            $_promo    = $_promoID[0]->pr_sale;
        }
        return $_promo;
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Интеркасса    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Авторизация 
    //Авторизация
    public function register() {
        $_email    = Input::get('email'); $_name = Input::get('name');
        $_password = Input::get('password');
        $_token    = Input::get('_token');
        $_response = Input::get('response');
        $_secret   = '6LdxQhEUAAAAAIZhfWIWHT5juBeuoKGD9hyziCoO';
        $rsp       = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$_secret&response=$_response");
        $arr       = json_decode($rsp, TRUE);

        if ($arr['success'] == true) {
            $id = DB::table('users')->insertGetId(array(
                'name'           => strip_tags(trim($_name)),
                'email'          => strip_tags(trim($_email)),
                'password'       => Hash::make($_password),
                'remember_token' => $_token,
                'updated_at'     => date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) + 3 * 60 * 60)),
                'created_at'     => date('Y-m-d H:i:s', (strtotime(gmdate('Y-m-d H:i:s')) + 3 * 60 * 60))
            ));
            if ((int) $id > 0) {
                Auth::attempt(['email' => $_email, 'password' => $_password]);
                $resp = array('ok' => (int) $id, 'key' => INTERKAS_KEY);
                print json_encode($resp); 
    }}}
    //
    //Подтверждение авторизации
    public function registerEnd() {
        $token = Input::get('token');
        $_res  = DB::update('UPDATE users SET status = 1  WHERE remember_token = ?', [strip_tags(trim($token))]);
        $resp  = array('ok' => (int) $_res);
        print json_encode($resp);
    }
    //
    //Форма сброса пароля
    public function resetPass() {
        print view('auth.passwords.email');
    }
    //
    //Удаление неподтверждённых пользователей и неактивных покупок
    public function checkTimerUser() {
        DB::delete('DELETE FROM users  WHERE status = 0 AND created_at<DATE_ADD(CURDATE(), INTERVAL -2 DAY)');
        DB::delete('DELETE FROM pack_forecasts WHERE status = 0' );
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Авторизация 
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// MANDRILL   
    public function mandrillResetPass() {
        $_email = Input::get('email');
        if (preg_match('#^[A-Z0-9+_.-]+@[A-Z0-9.-]+.[A-Z0-9.-]{2,4}$#i', $_email)) { 
            $results = DB::select(' SELECT *  FROM password_resets WHERE email = ? LIMIT 1', [strip_tags(trim($_email))]);
            if (isset($results[0]->id)) {
                $id    = $results[0]->id;
                $words = $this->lang();
                $_html = view('mail.resetPass', ['words' => $words, 'results' => $results[0]]);
                $args  = array(
                    'key'     => MANDRILL_KEY,
                    'message' => array("html"         => '' . $_html,
                        "text"         => null,
                        "from_email"   => "help@winbets.biz",
                        "from_name"    => $words['mail'][0],
                        "subject"      => $words['mail'][1],
                        "to"           => array(array("email" => $_email)),
                        "track_opens"  => true,
                        "track_clicks" => true
                ) );  $this->mandrill($args);
            } else { $id = 0; }
            $resp = array('status' => $id); print json_encode($resp);
        }
    }
    //
    public function mandrillConfirmRegister() {
        $_email = Input::get('email');

        if (preg_match('#^[A-Z0-9+_.-]+@[A-Z0-9.-]+.[A-Z0-9.-]{2,4}$#i', $_email)) {

            $results = DB::select(' SELECT *  FROM users WHERE email = ? LIMIT 1', [strip_tags(trim($_email))]);
            if (isset($results[0]->id)) {
                $id    = $results[0]->id; 
                $words = $this->lang();
                $_html = view('mail.confirmRegister', ['words' => $words, 'results' => $results[0]]);
                $args = array(
                    'key'     => MANDRILL_KEY,
                    'message' => array("html"         => '' . $_html,
                        "text"         => null,
                        "from_email"   => "support@winbets.biz",
                        "from_name"    => $words['mail'][2],
                        "subject"      => $words['mail'][3],
                        "to"           => array(array("email" => $_email)),
                        "track_opens"  => true,
                        "track_clicks" => true
                ) ); $this->mandrill($args);
            } else { $id = 0; }
            $resp = array('status' => $id); print json_encode($resp);
        }
    }
    //
    public function mandrill($args) {
        $curl     = curl_init('https://mandrillapp.com/api/1.0/messages/send.json');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
        $response = curl_exec($curl);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// MANDRILL   
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
