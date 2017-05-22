<?php
namespace sunnnnn\admin\auth\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use sunnnnn\admin\auth\components\Controller;
use sunnnnn\admin\auth\models\AuthRoute;

class RouteController extends Controller{
	
	public function actionIndex(){
		$searchModel = new AuthRoute();
		$searchModel->load(Yii::$app->request->queryParams);
		$condition = $andFilter = [];
		if(!empty($searchModel->keywords)){
			$andFilter[] = ['or', ['like', 'name', $searchModel->keywords], ['like', 'route', $searchModel->keywords]];
		}
		$dataProvider  = AuthRoute::adpSearch($condition, $andFilter);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	public function actionAdd(){
		$model = new AuthRoute();
		if(Yii::$app->request->isPost){
			$model->load(Yii::$app->request->post());
			$model->add_time = time();
			$model->edit_time = 0;
			if($model->save()){
				$this->checkCache();
				return $this->redirect(['/auth/route/index']);
			}
		}
		return $this->renderAjax('form', ['model' => $model]);
	}
	
	public function actionEdit(){
		$model = AuthRoute::findOne(['id' => $this->getGetValue('id')]);
		if(empty($model)){
			throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
		}
		if(Yii::$app->request->isPost){
			$model->load(Yii::$app->request->post());
			$model->edit_time = time();
			if($model->save()){
				$this->checkCache();
				return $this->redirect(['/auth/route/index']);
			}
		}
		return $this->renderAjax('form', ['model' => $model]);
	}
	
	public function actionDelete(){
		$model = AuthRoute::findOne(['id' => $this->getPostValue('id')]);
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
		if(Yii::$app->cache->exists(AuthRoute::CACHE_ROUTES_All)){
			Yii::$app->cache->delete(AuthRoute::CACHE_ROUTES_All);
		}
	}
}