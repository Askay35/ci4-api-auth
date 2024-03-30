<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Firebase\JWT\ExpiredException;

class Token extends BaseController
{
    use ApiResponseTrait;

    public function __construct(){
        helper('jwt');
    }
    public function regenerateToken(){
        try {
            $token = getJWTFromRequest(request()->getHeaderLine('Authorization'));
            if(!$token){
                return $this->respondErrors(['token'=>"Токен не указан"]);
            }
            $user = validateJWT($token);
            $new_token = getSignedJWTForUser($user['id']);
            return $this->respondSuccess(['token'=>$new_token]);

        } catch (Exception $ex) {
            return $this->respondErrors(['token'=>$ex->getMessage()]);
        }
    }
}
