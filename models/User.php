<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $password_repeat
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'username', 'password', 'password_repeat'], 'required'],
            [['first_name', 'last_name', 'username'], 'string', 'max' => 16],
            [['email', 'password', 'password_repeat'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Password Repeat',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        
        return static::findOne(['access_token' => $token]);
        
    }

    
    public function getId()
    {
        return $this->id;
    }

    
    public function getAuthKey()
    {
        // return $this->auth_Key;
    }

    
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
        
    }


        public function validatePassword($password)
    {
        return $this->password === $password;
    }

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         if ($this->isNewRecord) {
    //             $this->auth_key = \Yii::$app->security->generateRandomString();
    //         }
    //         return true;
    //     }
    //     return false;
    // }

    public function getFriends(){
        return $this->hasMany(Friends::className(), ['user_id' => 'id']);
    }

    public function getOutgoingfriends(){
        return $this->hasMany(Friends::className(), ['user_id' => 'id'])->where(['status' => Friends::PENDING]);
    }
    
    public function getIncomingfriends(){
        return $this->hasMany(Friends::className(), ['friend_id' => 'id'])->where(['status' => Friends::PENDING]);
    }
    
    public function getfriendsAccepted(){
        return $this->hasMany(Friends::className(), ['user_id' => 'id'])->where(['status' => Friends::ACCEPTED]);
    }
    public function getAcceptedfriends(){
        return $this->hasMany(Friends::className(), ['friend_id' => 'id'])->where(['status' => Friends::ACCEPTED]);
    }

}
