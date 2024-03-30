<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class User extends BaseController
{
    use ApiResponseTrait;
    public function index()
    {
        try {
            $user = validateJWT(getJWTFromRequest(request()->getHeaderLine('Authorization')));
            unset($user['id'], $user['password'], $user['is_verified']);
            return $this->respondSuccess(["user" => $user]);
        } catch (Exception $ex) {
            return $this->respondSuccess(["token" => $ex->getMessage()]);
        }   
    }
}
