<?php

namespace yokysantiago\ms\firebase\jwt;

use \Yii;
use Firebase\JWT\JWT;
/**
 * This is just an example.
 */
class AuthJwt 
{
    private $secret_key;
    private $encrypt;
    private $aud = null;

    public function __construct() 
    {
        // JWT-secretKey must be defined in Yii params.php file
        $this->secret_key = Yii::$app->params['JWT-secretKey'];
        // JWT-v must be defined in Yii params.php file
        $this->encrypt = Yii::$app->params['JWT-encrypt'];
    }

    /**
     * This method generates a token JWT with data encrypt
     */
    public function generateToken($data)
    {
        $time = time();

        $token = array(
            'exp' => $time + (60*60),
            'aud' => $this->aud(),
            'data' => $data
        );

        return JWT::encode($token, $this->secret_key);
    }

    /**
     * this method check the token
     */
    public function checkToken($token)
    {
        if(empty($token)) {
            throw new Exception("Invalid token.");
        }

        $decode = JWT::decode( $token, $this->secret_key, $this->encrypt );

        if($decode->aud !== $this->aud()) {
            throw new Exception("Invalid user logged in.");
        }
    }

    /**
     * this method gets token data
     */
    public function getData($token) 
    {
        return JWT::decode(
            $token,
            $this->secret_key,
            $this->encrypt
        )->data;
    }

    /**
     * This method generate information about the client to validat if the request is the same
     */
    private function aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}
