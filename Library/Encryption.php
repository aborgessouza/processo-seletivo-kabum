<?php
namespace Library;
/**
 *
 * https://www.the-art-of-web.com/php/two-way-encryption/
 *
 */

class Encryption
{

    static protected $method = 'aes-128-ctr'; // default cipher method if none supplied
    static private $key;

    public function __construct($key = FALSE, $method = FALSE)
    {
        if(!$key) {
            $key = HEX_KEY; // default encryption key if none supplied
        }
        if(ctype_print($key)) {
            // convert ASCII keys to binary format
            self::$key = openssl_digest($key, 'SHA256', TRUE);
        } else {
            self::$key = $key;
        }
        if($method) {
            if(in_array(strtolower($method), openssl_get_cipher_methods())) {
                self::$method = $method;
            } else {
                die(__METHOD__ . ": unrecognised cipher method: {$method}");
            }
        }
    }

    static protected function iv_bytes()
    {
        return openssl_cipher_iv_length(self::$method);
    }

    static public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes(self::iv_bytes());
        return bin2hex($iv) . openssl_encrypt($data, self::$method,self::$key , 0, $iv);
    }

    // decrypt encrypted string
    static public function decrypt($data)
    {
        $iv_strlen = 2  * self::iv_bytes();
        if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
            list(,$iv, $crypted_string) = $regs;
            if(ctype_xdigit($iv) && strlen($iv) % 2 === 0) {
                return openssl_decrypt($crypted_string, self::$method, self::$key , 0, hex2bin($iv));
            }
        }
        return FALSE; // failed to decrypt
    }

}
