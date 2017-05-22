<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use sunnnnn\admin\auth\models\AuthRoles;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string $add_time
 * @property string $login_time
 * @property string $status
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	public $keywords;
	const STATUS_N = 0;
	const STATUS_D = 1;
	public static $statusArr = [
		self::STATUS_N => '正常',
		self::STATUS_D => '禁用',
	];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['role', 'status', 'add_time', 'login_time'], 'integer'],
            [['add_time', 'login_time'], 'safe'],
            [['username'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 128],
            [['username'], 'unique'],
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
            'username' => '用户名',
            'password' => '密码',
            'role' => '角色',
            'add_time' => '添加时间',
            'login_time' => '最后登陆时间',
            'status' => '状态',
        ];
    }
    
	public static function adpSearch($condition = [], $andFilter = [], $order = ['id' => SORT_DESC]){
    	$query = static::find()->with(['roles'])->where($condition);
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
    
/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_N]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
    	return \Yii::$app->security->generatePasswordHash($this->username);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
    	return Yii::$app->security->validatePassword($authKey, $this->getAuthKey());
    }

    /**
     * @param     $username
     * @param int $status
     *
     * @return null|static
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_N]);
    }
    
    public static function getIndexList(){
    	return static::find()->indexBy('id')->all();
    }

    /**
     * @param $password
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->getPassword());
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     *
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function getRoles(){
    	return $this->hasOne(AuthRoles::className(), ['id' => 'role']);
    }
}
