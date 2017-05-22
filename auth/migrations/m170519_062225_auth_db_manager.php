<?php
use yii\db\Migration;
//php   yii migrate/create auth_db_manager
//php   yii migrate --migrationPath=@sunnnnn/admin/auth/migrations/
class m170519_062225_auth_db_manager extends Migration{
	
    public function up(){
    	
    	$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%auth_route}}', [
			'id' => $this->primaryKey(),
        	'name' => $this->string(64)->notNull(),
        	'route' => $this->string(64)->notNull(),
        	'add_time' => $this->integer()->notNull(),
        	'edit_time' => $this->integer()->notNull(),
		], $tableOptions);
        
        $this->batchInsert('{{%auth_route}}',
        	['id', 'name', 'route', 'add_time', 'edit_time'], 
        	[
				[1, '所有权限', '/*', time(), 0],
				[2, '权限管理【所有权限】', '/auth/*', time(), 0],
				[3, '权限管理-路由【所有权限】', '/auth/route/*', time(), 0],
				[4, '权限管理-路由【首页展示】', '/auth/route/index', time(), 0],
				[5, '权限管理-路由【添加操作】', '/auth/route/add', time(), 0],
				[6, '权限管理-路由【编辑操作】', '/auth/route/edit', time(), 0],
				[7, '权限管理-路由【删除操作】', '/auth/route/delete', time(), 0],
				[8, '权限管理-角色【所有权限】', '/auth/role/*', time(), 0],
				[9, '权限管理-角色【首页展示】', '/auth/role/index', time(), 0],
				[10, '权限管理-角色【添加操作】', '/auth/role/add', time(), 0],
				[11, '权限管理-角色【编辑操作】', '/auth/role/edit', time(), 0],
				[12, '权限管理-角色【删除操作】', '/auth/role/delete', time(), 0],
				[13, '权限管理-菜单【所有权限】', '/auth/menu/*', time(), 0],
				[14, '权限管理-菜单【首页展示】', '/auth/menu/index', time(), 0],
				[15, '权限管理-菜单【添加操作】', '/auth/menu/add', time(), 0],
				[16, '权限管理-菜单【编辑操作】', '/auth/menu/edit', time(), 0],
				[17, '权限管理-菜单【删除操作】', '/auth/menu/delete', time(), 0],
        	]
		);
        
        $this->createTable('{{%auth_roles}}', [
			'id' => $this->primaryKey(),
        	'name' => $this->string(64)->notNull(),
        	'routes' => $this->string(1024)->notNull(),
        	'remark' => $this->string(1024)->notNull(),
        	'add_time' => $this->integer()->notNull(),
        	'edit_time' => $this->integer()->notNull(),
		], $tableOptions);
        
        $this->insert('{{%auth_roles}}', [
			'id' => 1,
			'name' => '超级管理员',
			'routes' => '1',
			'remark' => '拥有全部操作权限以及开发权限',
			'add_time' => time(),
			'edit_time' => 0,
        ]);
        
        $this->createTable('{{%auth_menu}}', [
			'id' => $this->primaryKey(),
        	'name' => $this->string(64)->notNull(),
        	'parent' => $this->integer()->notNull(),
        	'route' => $this->integer()->notNull(),
        	'order' => $this->integer()->notNull(),
        	'icon' => $this->string(64)->notNull(),
        	'add_time' => $this->integer()->notNull(),
        	'edit_time' => $this->integer()->notNull(),
		], $tableOptions);
        
        $this->batchInsert('{{%auth_menu}}', 
        	['id', 'name', 'parent', 'route', 'order', 'icon', 'add_time', 'edit_time'], 
        	[
				[1, '权限管理', 0, 0, 1000, 'key', time(), 0],
				[2, '菜单', 1, 14, 1001, '', time(), 0],
				[3, '角色', 1, 9, 1002, '', time(), 0],
				[4, '路由', 1, 4, 1003, '', time(), 0],
        	]
		);
        
    }

    public function down(){
        $this->dropTable('{{%auth_test}}');
        $this->dropTable('{{%auth_roles}}');
        $this->dropTable('{{%auth_menu}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
