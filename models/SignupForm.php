<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $pin;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['pin', 'trim'],
            ['pin', 'required'],
            ['pin', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Этот PIN уже используется.'],
            ['pin', 'integer', 'min' => 1000, 'max' => 10000000],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->pin = $this->pin;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save();

    }

}
