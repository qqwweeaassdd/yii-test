<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Register model
 */
class Register extends ActiveRecord
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
     * Check email validation
     * @param string $attribute the attribute currently being validated
     */
    public function checkEmail($attribute)
    {
        if (!$this->hasErrors()) {
            if (RegisterModel::isEmailBusy($this->email)) {
                $this->addError($attribute, 'You\'re registered already.');
            }
        }
    }

    /**
     * Check register confirmation
     * @param string $email
     * @param string $secure
     * @return bool
     */
    public static function checkConfirm($email, $secure)
    {
        return RegisterModel::checkConfirm($email, $secure);
    }

    /**
     * Set register record used
     * @param $email
     */
    public static function setUsed($email)
    {
        $register = self::findOne($email);
        $register->used = true;
        $register->update(false);
    }
}
