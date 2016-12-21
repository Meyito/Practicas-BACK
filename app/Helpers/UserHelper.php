<?php

namespace App\Helpers;
use stdClass;

// use JWTAuth;

/**
 * Description of UserHelper
 */
class UserHelper
// extends Helper
{

    public static function getCurrentUser() {

      //FIXME: Change this when JWT has been implemented
      $user = new stdClass;
      $user->id = 1;
      return $user;
        // $payload = JWTAuth::getPayload(JWTAuth::getToken());
        // $userID = $payload->get('sub');
        // return $userID;
    }

}
