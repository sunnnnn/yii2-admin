<?php
namespace app\models;

use Yii;
use yii\base\Model;

class AdminForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $surePassword;

    private $_user = false;

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'surePassword'], 'required'],
            ['surePassword', 'compare', 'compareAttribute' => 'newPassword', 'operator' => '===', 'message' => '两次密码输入必须相同']  ,
            ['oldPassword', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if(empty($user)){
            	$this->addError($attribute, '用户名无效 !');
            }else{
            	if(!$user->validatePassword($this->oldPassword)){
            		$this->addError($attribute, '旧密码错误 !');
            	}
            }
        }
    }
    
    public function updatePassword(){
    	if ($this->validate()) {
    		$user = $this->getUser();
    		$user->setPassword($this->newPassword);
    		return $user->save();
    	}
    	return false;
    }


    public function getUser(){
        if ($this->_user === false) {
            $this->_user = Admin::findIdentity(Yii::$app->user->identity->id);
        }

        return $this->_user;
    }
    
    public function attributeLabels(){
    	return [
	    	'oldPassword' => '旧密码',
	    	'newPassword' => '新密码',
	    	'surePassword' => '确认密码',
    	];
    }
}
