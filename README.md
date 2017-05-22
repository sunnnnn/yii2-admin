```
yii-admin  后台管理系统-快速开发框架

搭建yii2框架下的后台管理系统全过程：

1、安装yii2框架：
	basic版本：composer create-project --prefer-dist yiisoft/yii2-app-basic admin
	advanced版本：composer create-project --prefer-dist yiisoft/yii2-app-advanced admin
	
2、初始化框架：
	cd admin
	init
	开发环境选择0，正式环境选择1，yes
	如果根目录下没有vendor文件夹，请使用 composer install 命令来安装
	（需事先安装composer全局插件：composer global require "fxp/composer-asset-plugin:1.2.2"）
	
3、安装admin插件：
	composer require sunnnnn/yii2-admin
	或者安装开发分支：composer require sunnnnn/yii2-admin:dev-master

4、根据yii版本，将目录/vendor/sunnnnn/yii2-admin/下的文件复制覆盖到yii框架下：
	advanced版本，将目录下advanced目录下的文件复制覆盖到对象位置，
	basic版本，则将basic目录下所有文件复制覆盖到对象位置，
	config文件可不用覆盖，根据注释添加到原config文件中

5、添加数据表及数据：
	yii migrate --migrationPath=@sunnnnn/admin/auth/migrations/
	失败可尝试：
	php yii migrate --migrationPath=@sunnnnn/admin/auth/migrations/
	
6、直接访问 http://your-domain/site/login页面，用户名admin、密码123456