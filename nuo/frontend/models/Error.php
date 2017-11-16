<?php
/**
 * Created by PhpStorm.
 * User: Dsir
 * Date: 2017/11/13
 * Time: 11:36
 */

namespace frontend\models;


class Error
{
    static public function reponse( $error=0, $msg="" ){
        return json_encode(array(
            'error'=>$error,
            'msg'=>$msg
        ));
    }
}