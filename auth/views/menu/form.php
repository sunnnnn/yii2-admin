<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use sunnnnn\admin\auth\assets\SelectAsset;
SelectAsset::register($this);
$this->registerJs("$('.select2').select2();", yii\web\View::POS_END);

$this->title = empty($model->id) ? '添加菜单' : '编辑菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => Url::to(['/auth/menu/index'])];
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
	        		'options' => ['class' => 'ajax-form', 'data-action' => empty($model->id) ? Url::to(['/auth/menu/add']) : Url::to(['/auth/menu/edit', 'id' => $model->id])],
	        		'fieldConfig' => [
	        			'template' => "<div class=\"form-group\">{label}\n{input}\n</div>",
	        			'inputOptions' => ['class' => 'form-control'],
	        		],
			    ]); ?>
				
					<div class="box-body">
						<?= $form->field($model, 'name')->textInput(); ?>
						<?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($optionsMenu, 'id', 'name'), ['prompt'=>'一级菜单', 'class' => 'form-control select2']); ?>
						<?= $form->field($model, 'route')->dropDownList(ArrayHelper::map($optionsRoute, 'id', 'label'), ['class' => 'form-control select2']); ?>
						<?= $form->field($model, 'order')->textInput(); ?>
						<?= $form->field($model, 'icon')->textInput(); ?>
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