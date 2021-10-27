<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['password', 'authKey'], 'string', 'max' => 150],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function validatePassword($password)
    {
        return $password == $this->password;
    }

//    public function rules()
//    {
//        return [
//            [['username', 'password'], 'required'],
//            [['username', 'accessToken'], 'string', 'max' => 150],
//            [['password'], 'string', 'max' => 50],
//        ];
//    }
//
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'username' => 'Username',
//            'password' => 'Password',
//            'accessToken' => 'Access Token',
//        ];
//    }

//    public function getGroupTasks()
//    {
//        return $this->hasMany(GroupTask::className(), ['user_id' => 'id']);
//    }
//
//    public function getTasks()
//    {
//        return $this->hasMany(Task::className(), ['user_id' => 'id']);
//    }
}
