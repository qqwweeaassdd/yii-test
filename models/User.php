<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['name', 'string', 'length' => [1, 255]],
            ['password', 'string', 'length' => [1, 255]],
        ];
    }

    /**
     * Register user
     * @param $email
     */
    public static function register($email)
    {
        // mark register record used
        Register::setUsed($email);

        // save user in user table
        $user = new self();
        $user->email = $email;
        $user->name = '';
        $user->password = YHelper::generatePassword(8);
        $user->save();

        Yii::$app->user->login($user);

        // TODO: send email with password
    }

    /**
     * Check authorize information
     * @param string $email login
     * @param string $password
     * @return boolean
     */
    public static function checkAuth($email, $password)
    {
        $matchesCount = self::find()
            ->where([
                'email'    => $email,
                'password' => /*md5*/($password) // TODO: take hash
            ])->count();

        return ($matchesCount > 0);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($email)
    {
        return static::findOne($email);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return md5($this->email . $this->password);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
