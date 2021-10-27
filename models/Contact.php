<?php

namespace app\models;

use Yii;

class Contact extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'contact';
    }

    public function rules()
    {
        return [
            [['fio', 'user_id'], 'required'],
            [['phone', 'user_id'], 'integer'],
            [['fio', 'address', 'email'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 150],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'address' => 'Address',
            'email' => 'Email',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
