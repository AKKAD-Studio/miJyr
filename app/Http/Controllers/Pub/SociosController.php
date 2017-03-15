<?php

namespace App\Http\Controllers\Pub;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SociosController extends Controller {

 

    public function vkontakte() {

        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
 
        if (isset($code)) { 
            $result = false; 
            $params = array( 
                'client_id'     => VK_CLIENT_ID, 
                'client_secret' => VK_CLIENT_SECRET, 
                'code'          => $code, 
                'redirect_uri'  => VK_REDIRECT_URI 
            );  
      
            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

            if (isset($token['access_token'])) {
                $params = array(
                    'uids'         => $token['user_id'],
                    'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                    'access_token' => $token['access_token']
                );

                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
                if (isset($userInfo['response'][0]['uid'])) {
                    $userInfo = $userInfo['response'][0];
                    $result = true;
                }
            }

            if ($result) {
                echo "Социальный ID пользователя: " . $userInfo['uid'] . '<br />';
                echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
                echo "Ссылка на профиль пользователя: " . $userInfo['screen_name'] . '<br />';
                echo "Пол пользователя: " . $userInfo['sex'] . '<br />';
                echo "День Рождения: " . $userInfo['bdate'] . '<br />';
                echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
            }  
        }  
    }

    public function facebook() {

        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
 

        if (isset($code)) {
            $result = false;

            $params = array(
                'client_id'     => FB_CLIENT_ID,
                'redirect_uri'  => FB_REDIRECT_URI,
                'client_secret' => FB_CLIENT_SECRET,
                'code'          => $code
            ); 

            $url = 'https://graph.facebook.com/oauth/access_token';

            $tokenInfo = null;
            parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);

            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);

                $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);

                if (isset($userInfo['id'])) {
                    $userInfo = $userInfo;
                    $result = true;
                }
            }
        } 

        if ($result) {
            echo "Социальный ID пользователя: " . $userInfo['id'] . '<br />';
            echo "Имя пользователя: " . $userInfo['name'] . '<br />';
            //echo "Email: " . $userInfo['email'] . '<br />';
           // echo "Ссылка на профиль пользователя: " . $userInfo['link'] . '<br />';
            //echo "Пол пользователя: " . $userInfo['gender'] . '<br />';
           // echo "ДР: " . $userInfo['birthday'] . '<br />';
            echo '<img src="http://graph.facebook.com/' . $userInfo['id'] . '/picture?type=large" />'; echo "<br />";
        }
  
   }

 

}
