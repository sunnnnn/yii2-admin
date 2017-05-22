<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">修改密码</h3>
				</div>
				
				<?php $form = ActiveForm::begin([
			        'id' => 'ajax-form',
	        		'action' => null,
	        		'options' => ['class' => 'ajax-form', 'data-action' => Url::to(['/admin/update-password'])],
	        		'fieldConfig' => [
	        			'template' => "<div class=\"form-group\">{label}\n{input}\n</div>",
	        			'inputOptions' => ['class' => 'form-control'],
	        		],
			    ]); ?>
				
					<div class="box-body">
						<?= $form->field($model, 'oldPassword')->passwordInput()->label('旧密码'); ?>
						<?= $form->field($model, 'newPassword')->passwordInput()->label('新密码'); ?>
						<?= $form->field($model, 'surePassword')->passwordInput()->label('确认新密码'); ?>
					</div>

					<div class="box-footer">
						<?= Html::button('提交', ['class' => 'btn btn-primary ajax-form-submit']); ?>
					</div>
				
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</section>
