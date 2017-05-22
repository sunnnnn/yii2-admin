<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Admin;

$this->title = empty($model->id) ? '添加管理员' : '编辑管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => Url::to(['/admin/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= Html::encode($this->title);?></h3>
				</div>
				
				<?php $form = ActiveForm::begin([
			        'id' => 'ajax-form',
	        		'action' => null,
	        		'options' => ['class' => 'ajax-form', 'data-action' => empty($model->id) ? Url::to(['/admin/add']) : Url::to(['/admin/edit', 'id' => $model->id])],
	        		'fieldConfig' => [
	        			'template' => "<div class=\"form-group\">{label}\n{input}\n</div>",
	        			'inputOptions' => ['class' => 'form-control'],
	        		],
			    ]); ?>
				
					<div class="box-body">
						<?= $form->field($model, 'username')->textInput(['autocomplete' => 'off'])->label('用户名'); ?>
						<?php if(empty($model->id)){
							echo $form->field($model, 'password')->passwordInput(['autocomplete' => 'off'])->label('密码');
						}else{
							echo $form->field($model, 'password')->passwordInput(['autocomplete' => 'off', 'value' => '', 'placeholder' => '不修改密码请留空'])->label('密码');
						}?>
						<?= $form->field($model, 'role')->dropDownList(ArrayHelper::map($optionsRole, 'id', 'name'))->label('角色'); ?>
						<?= $form->field($model, 'status')->radioList(Admin::$statusArr)->label('状态'); ?>
					</div>

					<div class="box-footer">
						<?= Html::button('提交', ['class' => 'btn btn-primary ajax-form-submit']); ?>
						<?= Html::a('返回', 'javascript:history.back();', ['class' => 'btn btn-default']); ?>
					</div>
				
				<?php ActiveForm::end(); ?>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
</section>