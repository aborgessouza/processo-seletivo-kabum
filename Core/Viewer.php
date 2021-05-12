<?php
namespace Core;

class Viewer
{
    public function view (string $request = '' , array $data = [] ) {
        if ((is_string($request)) && (!empty($request))) {
            $arquivo = '../App/Views' . DIRECTORY_SEPARATOR . $request;
            if (is_file($arquivo)) {

                if ((is_array($data)) && (count($data)>0)) {
                    foreach ($data as $k=>$v) {
                        $$k = $v;
                    }
                }
                require_once $arquivo;
            }
        }
    }
}
?>