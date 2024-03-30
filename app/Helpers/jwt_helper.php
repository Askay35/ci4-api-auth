<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


// Генерация JWT.
// function generateJWT($data)
// {
//     $issuedAt = time();
//     $expirationTime = $issuedAt + Services::getTokenLiveTime();

//     $payload = array(
//         'iat' => $issuedAt,
//         'exp' => $expirationTime,
//         'data' => $data
//     );

//     return JWT::encode($payload, Services::getSecretKey(), 'HS256');
// }

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT is absent
        return false;
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

function validateJWT(string $encodedToken)
{
    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $userModel = new UserModel;
    $user = $userModel->find($decodedToken->data->id);
    return $user;
}

function getSignedJWTForUser(string $id)
{
    $issuedAtTime = time();
    $tokenTimeToLive = Services::getTokenLiveTime();
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;    // expire time in seconds
    $notBeforeClaim = $issuedAtTime + 1;                   // not before in seconds
    $payload = [
        "iss" => "Issuer of the JWT", // this can be the servername. Example: https://domain.com
        "aud" => "Audience that the JWT",
        "sub" => "Subject of the JWT",
        "nbf" => $notBeforeClaim,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
        "data" => array(
            'id' => $id
        )
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey(), 'HS256');
    return $jwt;
}
