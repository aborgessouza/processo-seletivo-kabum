<?php
namespace Library;

Class Url implements UrlInterface
{
    static public function baseUrl(string $url = ''):string
    {

        if (($url !== '') && ($url !== '/')) {
            if (preg_match("/^(\/+)(.*)/i" , $url,$matches)) {
                $url = $matches[1];
            }
        }
        else {
            $url = '';
        }

        return
            ((!empty(DEFAULT_URL))) ? sprintf("%s/public_html/%s" , DEFAULT_URL , $url) :
            sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    static public function redirect(string $url = '', int $HTTP_CODE=301)
    {
        if (!headers_sent()) {
            header("Location:".self::baseUrl($url), TRUE, $HTTP_CODE);
            exit(0);
        }

        exit('<meta http-equiv="refresh" content="0; url='.$url.'"/>');
    }


}