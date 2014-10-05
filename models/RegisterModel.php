<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Register model
 */
class RegisterModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'registration';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'checkEmail'],
            ['secure', 'string', 'length' => [1, 255]],
            ['used', 'boolean'],
        ];
    }

    /**
     * Test if email in base already
     * @param string $email
     * @return bool
     */
    public static function isEmailBusy($email)
    {
        $matchesCount = self::find()
            ->where(['email' => $email])
            ->count();

        return ($matchesCount > 0);
    }

    /**
     * Check register confirmation
     * @param string $email
     * @param string $secure
     * @return bool
     */
    public static function checkConfirm($email, $secure)
    {
        $matchesCount = self::find()
            ->where([
                'email'  => $email,
                'secure' => $secure,
                'used'   => false,
            ])
            ->count();

        return ($matchesCount > 0);
    }
}
