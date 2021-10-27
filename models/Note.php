<?php

namespace app\models;

use Yii;

class Note extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'note';
    }

    public function rules()
    {
        return [
            [['text', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
