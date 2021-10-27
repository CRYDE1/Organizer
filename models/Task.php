<?php

namespace app\models;

use Yii;

class Task extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'task';
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'date'], 'required'],
            [['user_id', 'income', 'expense', 'priority', 'group_id'], 'integer'],
            [['description'], 'string'],
            [['date', 'reminder'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupTask::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'income' => 'Income',
            'expense' => 'Expense',
            'reminder' => 'Reminder',
            'priority' => 'Priority',
            'group_id' => 'Group ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGroup()
    {
        return $this->hasOne(GroupTask::className(), ['id' => 'group_id']);
    }
}
