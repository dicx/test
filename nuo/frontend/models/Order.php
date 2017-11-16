<?php
/**
 * Created by PhpStorm.
 * User: Dsir
 * Date: 2017/11/11
 * Time: 11:56
 */

namespace frontend\models;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName(){
        return '{{%order}}';
    }

}