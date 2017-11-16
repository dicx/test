<?php
/**
 * Created by PhpStorm.
 * User: Dsir
 * Date: 2017/11/12
 * Time: 21:26
 */

namespace frontend\models;
use yii\db\ActiveRecord;

class Log extends ActiveRecord
{
    public static function tableName(){
        return '{{%log}}';
    }

}