<?php

namespace app\models;

use yii\db\ActiveRecord;

class Drivers extends ActiveRecord
{
    public $time;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{drivers}}';
    }
}