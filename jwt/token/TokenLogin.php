<?php

require_once('vendor/autoload.php');
use \Firebase\JWT\JWT;

class TokenLogin {
   private $secret;

   function __construct($secret) {
      $this->secret = $secret;
   }

   function create_token($uid, $utype, $day) {
      $uid = intval($uid);
      if (!($uid > 0)) return;

      $now = time();

      $data = array();
      $data['uid'] = $uid;
      $data['utype'] = $utype;
      $data['iat'] = $now;
      $data['exp'] = $now + 24 * (60 * 60 * $day);

      return JWT::encode($data, $this->secret);
   }

  function validate_token($token) {
      try {
         $payload = JWT::decode($token, $this->secret, array('HS256'));
         if (!$payload) {header('HTTP/1.1 401 Unauthorized');}
         return json_decode(json_encode($payload));
      } catch (Exception $e) {
         //die(var_dump($e));
         
         header('HTTP/1.1 401 Unauthorized');
      }
   }
}

?>
