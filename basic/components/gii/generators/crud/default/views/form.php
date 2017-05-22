<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
	$safeAttributes = $model->attributes();
}

echo "<?php\n";
?>
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = empty($model->id) ? <?= $generator->generateString('添加' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?> : <?= $generator->generateString('编辑' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['/<?= Inflector::camel2words(StringHelper::basename($generator->modelClass), false); ?>/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= '<?= ' ?> Html::encode($this->title);?></h3>
				</div>
				
				<?= '<?php ' ?>$form = ActiveForm::begin([
			        'id' => 'ajax-form',
	        		'action' => null,
	        		'options' => [
	        			'class' => 'ajax-form', 
	        			'data-action' => empty($model->id) ? Url::to(['/<?= Inflector::camel2words(StringHelper::basename($generator->modelClass), false); ?>/add']) : Url::to(['/<?= Inflector::camel2words(StringHelper::basename($generator->modelClass), false); ?>/edit', 'id' => $model->id])
	        		],
	        		'fieldConfig' => [
	        			'template' => '<div class="form-group">{label}{input}</div>',
	        			'inputOptions' => ['class' => 'form-control'],
	        		],
			    ]); ?>
				
					<div class="box-body">
					<?php foreach ($generator->getColumnNames() as $attribute) {
					    if (in_array($attribute, $safeAttributes)) {
					        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
					    }
					} ?>
					</div>

					<div class="box-footer">
						<?= '<?= ' ?>Html::button('提交', ['class' => 'btn btn-primary ajax-form-submit']); ?>
						<?= '<?= ' ?>Html::a('返回', 'javascript:history.back();', ['class' => 'btn btn-default']); ?>
					</div>
				
				<?= '<?php ' ?> ActiveForm::end(); ?>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
</section>