<?php
namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use app\models\Admin;
use app\models\AdminForm;
use sunnnnn\admin\auth\models\AuthRoles;

class AdminController extends Controller{

    public function actionIndex(){
		$searchModel = new Admin();
    	$searchModel->load(Yii::$app->request->queryParams);
    	$condition = $andFilter = [];
    	if(!empty($searchModel->keywords)){
    		$andFilter[] = ['like', 'username', $searchModel->keywords];
    	}
    	
    	$dataProvider  = $searchModel::adpSearch($condition, $andFilter);
    	return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }
    
    public function actionAdd(){
    	$model = new Admin();
    	if(Yii::$app->request->isPost){
	    	$model->load(Yii::$app->request->post());
	    	$model->setPassword($model->password);
	    	$model->add_time = time();
	    	$model->login_time = 0;
	    	if ($model->save()) {
	    		return $this->outAjaxForm(Url::to(['/admin/index']));
	    	}else{
	    		$errors = $model->getErrors();
	    		if(!empty($errors)){
	    			foreach($errors as $error){
	    				$error = is_array($error) ? array_pop($error) : $error;
	    				return $this->outAjaxForm('', $error);
	    				break;
	    			}
	    		}
	    	}
    	}
    	$model->status = 0;
    	return $this->render('form', [
    		'model' => $model, 
    		'optionsRole' => AuthRoles::find()->all()
		]);
    }
    
    public function actionEdit(){
    	$model = Admin::findOne(['id' => $this->getGetValue('id')]);
    	if(empty($model)){
    		throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    	}
    	
    	if(Yii::$app->request->isPost){
    		$data = Yii::$app->request->post('Admin');
    		$data['password'] = empty($data['password']) ? $model->password : Yii::$app->security->generatePasswordHash($data['password']);
    		$model->setAttributes($data);
    		if($model->save()){
    			$this->outAjaxForm(Url::to(['/admin/index']));
    		}else{
    			$errors = $model->getErrors();
    			if(!empty($errors)){
    				foreach($errors as $error){
    					$error = is_array($error) ? array_pop($error) : $error;
    					$this->outAjaxForm('', $error);
    					break;
    				}
    			}
    		}
    	}
    	return $this->render('form', [
    		'model' => $model, 
    		'optionsRole' => AuthRoles::find()->all()
		]);
    }
    
    public function actionDelete(){
    	$model = Admin::findOne(['id' => $this->getPostValue('id')]);
    	if(empty($model)){
    		throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    	}
    
    	if($model->delete()){
    		$this->outAjaxRequest(true);
    	}else{
    		$errors = $model->getErrors();
    		if(!empty($errors)){
    			foreach($errors as $error){
    				$error = is_array($error) ? array_pop($error) : $error;
    				$this->outAjaxRequest(false, $error);
    				break;
    			}
    		}
    	}
    }
    
    public function actionEditPassword(){
    	$model = new AdminForm();
    	if(Yii::$app->request->isPost){
    		if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {
    			$this->outAjaxForm('#', '密码修改成功');
    		}else{
    			$error = $model->getErrors();
    			if(!empty($error)){
    				foreach($error as $err){
    					$err = is_array($err) ? array_pop($err) : $err;
    					$this->outAjaxForm('', $err);
    					break;
    				}
    			}
    		}
    	}
    	return $this->render('password', ['model' => $model]);
    }
}
