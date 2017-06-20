<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '登陆';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
	<div class="login-logo">
		<b>后台管理系统</b>
	</div>
	
	<div class="login-box-body">
		<p class="login-box-msg">后台管理员登陆</p>
    
	    <?php $form = ActiveForm::begin([
	        'id' => 'login-form',
			'action' => null,
			'options' => ['data-action' => Url::to(['/site/ajax-login'])],
	    ]); ?>
    
    	<?= $form->field($model, 'username', [
    			'template' => '<div class="form-group has-feedback">{input}<span class="form-control-feedback"><i class="fa fa-user"></i></span></div>'
    	])->textInput(['placeholder' => '请输入用户名']) ?>
        
        <?= $form->field($model, 'password', [
            'template' => '<div class="form-group has-feedback">{input}<span class="form-control-feedback"><i class="fa fa-lock"></i></span></div>',
        ])->passwordInput(['placeholder' => '请输入密码']) ?>
        
        <div class="row">
			<div class="col-xs-12">
				<?= Html::Button('登陆', ['class'=>'btn btn-primary btn-block btn-flat login-submit']) ?>
			</div>
		</div>
    
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php $this->beginBlock('login') ?> 
$(function(){
	document.onkeydown = function(e){ 
	    var ev = document.all ? window.event : e;
	    if(ev.keyCode == 13) {
			$('.login-submit').click();
		}
	}
	
	$('.login-submit').click(function(){
    	var that = $(this);
    	that.attr('disabled', 'disabled');
    	var load = layer.load();
		$.ajax({
	        type: 'post',
	        url: $('#login-form').data('action'),
	        data: $('#login-form').serialize(),
	        dataType: 'json',
	        error: function(xhr) {
	        	layer.close(load);
	        	that.attr('disabled', null);
	        	layer.msg('网络错误，请稍后再试', {offset: '100px'});
	        },
	        success: function(result) {
		        if(result.url){
		        	location.href = result.url;
		        }else{
		        	layer.close(load);
	        		that.attr('disabled', null);
		        	layer.msg(result.message, {offset: '100px'});
		        }
	        }
	    });
	});
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['login'], \yii\web\View::POS_END); ?> 