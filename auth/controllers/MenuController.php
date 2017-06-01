<?php
namespace sunnnnn\admin\auth\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use sunnnnn\admin\auth\components\Controller;
use sunnnnn\admin\auth\models\AuthMenu;
use sunnnnn\admin\auth\models\AuthRoute;
use sunnnnn\admin\auth\components\helpers\MenuHelper;

class MenuController extends Controller{
	
	public function actionIndex(){
		return $this->render('index', [
			'items' => MenuHelper::renderMenuItmes()
		]);
	}
	
	public function actionAdd(){
		$model = new AuthMenu();
		if(Yii::$app->request->isPost){
			$model->load(Yii::$app->request->post());
			$model->parent = empty($model->parent) ? 0 : $model->parent;
			$model->order  = empty($model->order) ? 0 : $model->order;
			$model->add_time = time();
			$model->edit_time = 0;
			if ($model->save()) {
				$this->checkCache();
				return $this->outAjaxForm(Url::to(['/auth/menu/index']));
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
		return $this->render('form', [
			'model' => $model,
			'optionsMenu' => AuthMenu::find()->all(),
			'optionsRoute' => AuthRoute::getRoutesAll(),
		]);
	}
	
	public function actionEdit(){
		$model = AuthMenu::findOne(['id' => $this->getGetValue('id')]);
		if(empty($model)){
			throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
		}
		if(Yii::$app->request->isPost){
			$model->load(Yii::$app->request->post());
			$model->parent = empty($model->parent) ? 0 : $model->parent;
			$model->order  = empty($model->order) ? 0 : $model->order;
			$model->edit_time = time();
			if($model->save()){
				$this->checkCache();
				return $this->outAjaxForm('#', 'success');
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
		return $this->render('form', [
			'model' => $model,
			'optionsMenu' => AuthMenu::find()->all(),
			'optionsRoute' => AuthRoute::getRoutesAll(),
		]);
	}
	
	public function actionDelete(){
		$model = AuthMenu::findOne(['id' => $this->getPostValue('id')]);
		if(empty($model)){
			throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
		}
	
		if($model->delete()){
			$this->checkCache();
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
	
	private function checkCache(){
		if(Yii::$app->cache->exists(AuthMenu::CACHE_MENU)){
			Yii::$app->cache->delete(AuthMenu::CACHE_MENU);
		}
	}
}