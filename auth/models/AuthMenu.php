<?php
namespace sunnnnn\admin\auth\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "auth_menu".
 *
 * @property string $id
 * @property string $name
 * @property string $parent
 * @property string $route
 * @property string $order
 * @property string $icon
 * @property string $add_time
 * @property string $edit_time
 */
class AuthMenu extends \yii\db\ActiveRecord
{
	const CACHE_MENU = 'cacheAuthMenu';
	public $keywords;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'route', 'order', 'add_time', 'edit_time'], 'integer'],
            [['name', 'icon'], 'string', 'max' => 64],
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
            'name' => '菜单名称',
            'parent' => '父级菜单',
            'route' => '路由',
            'order' => '排序（越小越靠前）',
            'icon' => '图标【参考：http://fontawesome.dashgame.com/】',
            'add_time' => 'Add Time',
            'edit_time' => 'Edit Time',
        ];
    }
    
    public static function adpSearch($condition = [], $andFilter = [], $order = ['order' => SORT_ASC]){
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
    
    public static function getMenu(){
    	if(Yii::$app->cache->exists(self::CACHE_MENU)){
    		return Yii::$app->cache->get(self::CACHE_MENU);
    	}else{
    		$_return = [];
    		self::normalizeMenu($_return);
    		Yii::$app->cache->set(self::CACHE_MENU, $_return);
    		return $_return;
    	}
    }
    
    private static function normalizeMenu(&$_return = [], $parent = 0){
    	
    	$menus = static::find()->with(['routes'])->where(['parent' => $parent])->orderBy(['order' => SORT_ASC])->all();
    	if(!empty($menus)){
    		if(isset($_return['url'])){
    			unset($_return['url']);
    		}
    		foreach($menus as $menu){
    			$_temp = [
    				'id' => $menu->id,
	    			'label' => $menu->name,
	    			'url' => isset($menu->routes->route) ? [$menu->routes->route] : '',
	    			'icon' => empty($menu->icon) ? 'fa fa-circle-o' : 'fa fa-'.$menu->icon,
	    			'items' => []
    			];
    			self::normalizeMenu($_temp, $menu->id);
    			
    			if(empty($parent)){
    				$_return[] = $_temp;
    			}else{
	    			$_return['items'][] = $_temp;
    			}
    		}
    	}else{
    		if(isset($_return['items'])){
    			unset($_return['items']);
    		}
    	}
    	
    }
    
    public function getRoutes(){
    	return $this->hasOne(AuthRoute::className(), ['id' => 'route']);
    }
}
