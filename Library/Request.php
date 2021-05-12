<?php

namespace Library;

Class Request {

    static function json(array $data) {
        header("Content-Type: application/json");
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(["jsonError" => json_last_error_msg()]);
            if ($json === false) {
                $json = '{"jsonError":"desconhecido"}';
            }
            http_response_code(500);
        }
        echo $json;
    }
}