<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = empty($model->id) ? '添加路由' : '编辑路由';
$this->params['breadcrumbs'][] = ['label' => '路由映射列表', 'url' => Url::to(['/auth/route/index'])];
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
	        		'options' => [
	        		    'class' => 'ajax-form', 
	        		    'data-action' => empty($model->id) ? Url::to(['/auth/route/add']) : Url::to(['/auth/route/edit', 'id' => $model->id])
	        		],
	        		'fieldConfig' => [
	        			'template' => "<div class=\"form-group\">{label}\n{input}\n</div>",
	        			'inputOptions' => ['class' => 'form-control'],
	        		],
			    ]); ?>
				
            		<div class="box-body">
            			<?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']); ?>
            			<?= $form->field($model, 'route')->textInput(['autocomplete' => 'off']); ?>
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