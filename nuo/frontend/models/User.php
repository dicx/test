<?php
/**
 * Created by PhpStorm.
 * User: Dsir
 * Date: 2017/11/9
 * Time: 20:23
 */

namespace frontend\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user}}';
    }

}