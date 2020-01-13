<?php

namespace app\models;

use yii\db\ActiveRecord;

class Buses extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{buses}}';
    }
}