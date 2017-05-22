<?php
namespace sunnnnn\admin\auth\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "auth_route".
 *
 * @property string $id
 * @property string $name
 * @property string $route
 * @property string $add_time
 * @property string $edit_time
 */
class AuthRoute extends \yii\db\ActiveRecord
{
	
	const CACHE_ROUTES_ROLE = 'cacheAuthRoutesByRole';
	const CACHE_ROUTES_All = 'cacheAuthRoutesAll';
	public $keywords;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'route'], 'required'],
            [['add_time', 'edit_time'], 'integer'],
            [['name', 'route'], 'string', 'max' => 64],
            [['keywords'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '路由名称',
            'route' => '路由路径',
            'add_time' => '添加时间',
            'edit_time' => '编辑时间',
        ];
    }
    
    public static function adpSearch($condition = [], $andFilter = [], $order = ['id' => SORT_DESC]){
    	$query = static::find()->where($condition);
    	if(!empty($andFilter) && is_array($andFilter)){
    		foreach($andFilter as $val){
    			$query->andFilterWhere($val);
    		}
    	}
    
    	$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pagesize' => 10,
			],
		]);
    
    	return $dataProvider;
    }
    
    public static function getRoutesByRole(){
    	if(Yii::$app->cache->exists(self::CACHE_ROUTES_ROLE)){
    		return Yii::$app->cache->get(self::CACHE_ROUTES_ROLE);
    	}else{
    		$_return = [];
    		
    		$roles = AuthRoles::find()->all();
    		foreach($roles as $role){
    			if(empty($role->routes)){
    				$_return[$role->id] = [];
    			}else{
    				$routes = explode(",", $role->routes);
    				foreach($routes as $routeId){
    					$authRoute = AuthRoute::findOne(['id' => $routeId]);
    					if(!empty($authRoute) && !empty($authRoute->route)){
    						$_return[$role->id][$authRoute->route] = [
    							'id' => $authRoute->id,
								'label' => $authRoute->name.'【'. $authRoute->route .'】',
    						];
    					}
    				}
    			}
    		}
    		
	    	Yii::$app->cache->set(self::CACHE_ROUTES_ROLE, $_return);
	    	return $_return;
    	}
    	
    }
    
    public static function getRoutesAll(){
    	if(Yii::$app->cache->exists(self::CACHE_ROUTES_All)){
    		return Yii::$app->cache->get(self::CACHE_ROUTES_All);
    	}else{
    		$_return = [];
    		
    		$routes = static::find()->orderBy(['route' => SORT_ASC])->all();
    		foreach($routes as $route){
    			if(!empty($route->route)){
    				$_return[$route->route] = [
    					'id' => $route->id,
    					'label' => $route->name.'【'. $route->route .'】',
					];
    			}
    		}
    		
    		Yii::$app->cache->set(self::CACHE_ROUTES_All, $_return);
    		return $_return;
    	}
    }
}
