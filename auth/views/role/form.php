<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

$this->registerJs($this->render('role.js'), yii\web\View::POS_END);

$this->title = empty($model->id) ? '添加角色' : '编辑角色';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => Url::to(['/auth/role/index'])];
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
			        'id' => 'route-form',
	        		'action' => null,
	        		'options' => ['class' => 'route-form', 'data-action' => empty($model->id) ? Url::to(['/auth/role/add']) : Url::to(['/auth/role/edit', 'id' => $model->id])],
	        		'fieldConfig' => [
	        			'template' => "<div class=\"form-group\">{label}\n{input}\n</div>",
	        			'inputOptions' => ['class' => 'form-control'],
	        		],
			    ]); ?>
				
					<div class="box-body">
						<?= $form->field($model, 'name')->textInput(); ?>
						<?= $form->field($model, 'remark')->textarea(); ?>
						
						<div class="row">
					        <div class="col-sm-5">
					        	<label>未分配权限</label>
					        	<?= Html::textInput(null, null, ['class' => 'form-control search', 'data-target' => 'avaliable', 'placeholder' => '输入路由名称搜索']); ?>
					        	<?= Html::ListBox(null, null, [], ['multiple' => 'multiple', 'size' => '20', 'class' => 'form-control list', 'data-target' => 'avaliable']); ?>
					        </div>
					        <div class="col-sm-2">
					            <br><br>
					            <?= Html::a('&gt;&gt; 分配', 'javascript:;', [
					                'class' => 'btn btn-success btn-assigned',
					            ]) ?><br><br>
					            <?= Html::a('&lt;&lt; 移除', 'javascript:;', [
					                'class' => 'btn btn-danger btn-avaliable',
					            ]) ?>
					        </div>
					        <div class="col-sm-5">
					        	<label>已有权限</label>
					        	<?= Html::textInput(null, null, ['class' => 'form-control search', 'data-target' => 'assigned', 'placeholder' => '输入路由名称搜索']); ?>
					            <?= Html::activeListBox($model, 'routes', [], ['multiple' => 'multiple', 'size' => '20', 'class' => 'form-control list', 'data-target' => 'assigned']); ?>
					        </div>
					    </div>
					</div>

					<div class="box-footer">
						<?= Html::button('提交', ['class' => 'btn btn-primary route-form-submit']); ?>
						<?= Html::a('返回', 'javascript:history.back();', ['class' => 'btn btn-default']); ?>
					</div>
				
				<?php ActiveForm::end(); ?>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
</section>
<script>
	var opts = <?= Json::htmlEncode($options); ?>;
	var _opts = new Object;
	_opts.avaliable = opts.avaliable || {};
	_opts.assigned  = opts.assigned || {};
</script>