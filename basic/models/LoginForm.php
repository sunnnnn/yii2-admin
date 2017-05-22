<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels()
    {
    	return [
	    	'username' => '用户名',
	    	'password' => '密码',
	    	'rememberMe' => '记住我',
    	];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if(empty($user)){
            	$this->addError($attribute, '用户名无效 !');
            }else{
            	if(!$user->validatePassword($this->password)){
            		$this->addError($attribute, '密码错误 !');
            	}
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
        	$User = $this->getUser();
        	$User->login_time = time();
        	$User->save();
            return Yii::$app->user->login($User, $this->rememberMe ? 3600*24*7 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findByUsername($this->username);
        }

        return $this->_user;
    }
}
