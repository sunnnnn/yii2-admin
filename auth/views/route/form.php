<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = empty($model->id) ? '添加路由' : '编辑路由';
$this->params['breadcrumbs'][] = ['label' => '路由列表', 'url' => Url::to(['/auth/route/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
	<?php $form = ActiveForm::begin([
				'id' => 'form',
        		'action' => empty($model->id) ? Url::to(['/auth/route/add']) : Url::to(['/auth/route/edit', 'id' => $model->id]),
        		'fieldConfig' => [
        			'template' => "<div class=\"form-group\">{label}\n{input}\n{error}</div>",
        			'inputOptions' => ['class' => 'form-control'],
        		],
		    ]); ?>
	
		<div class="box-body">
			<?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']); ?>
			<?= $form->field($model, 'route')->textInput(['autocomplete' => 'off']); ?>
		</div>

		<div class="box-footer">
			<?= Html::button('提交', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
		</div>
	
	<?php ActiveForm::end(); ?>
</div>
