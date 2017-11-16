<?php
/**
 * Created by PhpStorm.
 * User: Dsir
 * Date: 2017/11/3
 * Time: 11:58
 */
namespace frontend\models;

use \yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product}}';
    }

}