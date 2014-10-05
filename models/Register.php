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
     * Register validate
     * @param array $attributeNames list of attribute names that should be validated.
     * If this parameter is empty, it means any attribute listed in the applicable
     * validation rules should be validated.
     * @param boolean $clearErrors whether to call [[clearErrors()]] before performing validation
     * @return boolean whether the validation is successful without any error.
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        //print_r([$attributeNames, $clearErrors]); die('');
        return parent::validate($attributeNames, $clearErrors);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    /*public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }*/

    /**
     * Check email validation
     * @param string $attribute the attribute currently being validated
     */
    public function checkEmail($attribute)
    {
        if (!$this->hasErrors()) {
            $matchesCount = self::find() // TODO: split RegisterForm & Register DB model
                ->where(['email' => $this->email])
                ->count();

            if ($matchesCount > 0) {
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
        $matchesCount = self::find()
            ->where([
                'email'  => $email,
                'secure' => $secure,
                'used'   => false,
            ])
            ->count();

        return ($matchesCount > 0);
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
