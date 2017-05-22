```
yii-admin  后台管理系统-快速开发框架

使用：

1、在yii项目跟目录下：composer require sunnnnn/yii2-admin

2、根据yii版本，advanced版本则将advanced目录下全部文件复制覆盖到yii项目中；basic版本则将basic目录下所有文件复制覆盖，config文件根据注释添加

3、添加数据表及数据：
	yii migrate --migrationPath=@sunnnnn/admin/auth/migrations/
	失败可尝试：
	php yii migrate --migrationPath=@sunnnnn/admin/auth/migrations/
	
4、直接访问 http://your-domain/site/login页面，用户名admin、密码123456