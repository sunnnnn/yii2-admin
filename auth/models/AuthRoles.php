<?php
namespace sunnnnn\admin\auth\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "auth_roles".
 *
 * @property string $id
 * @property string $name
 * @property string $routes
 * @property string $remark
 * @property string $add_time
 * @property string $edit_time
 */
class AuthRoles extends \yii\db\ActiveRecord
{
	public $keywords;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'routes'], 'required'],
            [['add_time', 'edit_time'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['routes', 'remark'], 'string', 'max' => 1024],
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
            'name' => '角色名',
            'routes' => '路由集合',
            'remark' => '角色说明',
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
}
