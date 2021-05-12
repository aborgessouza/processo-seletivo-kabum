<?php

namespace Library;

interface UrlInterface
{

    static public function baseUrl(string $url = '');
    static public function redirect(string $url , int $HTTP_CODE=301);

}