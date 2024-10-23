<?php

namespace App\Http\Controllers\Api\v1\Encrypt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncryptEncuestaInvController extends Controller
{
    private $key;

    public function __construct()
    {
        $this->key ="M1bc0d32024*";
    }
    //Encriptar
    public static function encryptar($string)

    {
        $objeto = new EncryptEncuestaInvController();
        $key= $objeto->key;
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    //Desencriptar
    public static function decrypt($string)
    {
        $objeto = new EncryptEncuestaInvController();
        $key= $objeto->key;

        $result = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }
}
