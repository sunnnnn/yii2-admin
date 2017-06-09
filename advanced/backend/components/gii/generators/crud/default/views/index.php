<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
	<div class="row">
        <div class="col-md-6">
			<?= '<?php ' ?> $form = ActiveForm::begin([
				'action' => Url::to(['/<?= Inflector::camel2words(StringHelper::basename($generator->modelClass), false) ?>/index']),
				'method' => 'get',
				'options'=>['class' => 'table-search'],
				'enableClientValidation' => false,
			]); ?>
			<div class="input-group">
				<?= '<?= ' ?> Html::activeTextInput($searchModel, 'keywords', ['class' => 'form-control', 'placeholder' => '输入关键词进行搜索']); ?>
	        	<span class="input-group-btn">
	        		<?= '<?= ' ?> Html::submitButton('<i class="fa fa-search"></i> 搜索', ['class' => 'btn btn-info btn-flat']); ?>
	        	</span>
			</div>
		    <?= '<?php ' ?> ActiveForm::end(); ?>
        </div>
    </div>
    
	<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><?= '<?= ' ?> Html::encode($this->title) ?></h3>
					
					<div class="box-tools">
						<?= '<?= ' ?> Html::a('<i class="fa fa-plus"></i> 添加', ['/<?= Inflector::camel2words(StringHelper::basename($generator->modelClass), false) ?>/add'], ['class' => 'btn btn-success']) ?>
					</div>
				</div>
				
				<div class="box-body table-responsive no-padding">
					<?= '<?= ' ?> GridView::widget([
						'summary' => false,
						'tableOptions' => ['class' => 'table table-hover'],
						'dataProvider' => $dataProvider,
						'columns' => [ 
//							[
//								'attribute' => '',
//								'headerOptions' => ['width' => '20%'],
//								'contentOptions' => [],
//								'format' => 'raw',
//								'value' => function($model) {
//									return '';
//								},
//							],
							<?php
							$count = 0;
							if (($tableSchema = $generator->getTableSchema()) === false) {
							    foreach ($generator->getColumnNames() as $name) {
							        if (++$count < 6) {
							            echo "            '" . $name . "',\n";
							        } else {
							            echo "            // '" . $name . "',\n";
							        }
							    }
							} else {
							    foreach ($tableSchema->columns as $column) {
							        $format = $generator->generateColumnFormat($column);
							        if (++$count < 6) {
							            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
							        } else {
							            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
							        }
							    }
							}
							?>
            				[
								'class' => 'yii\grid\ActionColumn',
								"template" => "{update} {delete}",
								"header" => "操作",
								"buttons" => [
									"update" => function ($url, $model, $key){
										return Html::a('<i class="fa fa-pencil"></i> 编辑', ['/<?= Inflector::camel2words(StringHelper::basename($generator->modelClass), false) ?>/edit', 'id' => $model->id], [
											"class" => "btn btn-sm btn-primary"
										]);
									},
									"delete" => function($url, $model, $key){
										return Html::a('<i class="fa fa-trash-o"></i> 删除', 'javascript:;', [
											'class' => 'btn btn-sm btn-danger ajax-table-delete',
											'data-action' => Url::to(['/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), false) ?>/delete'])
										]);
									}
								]
							],
        				],
    				]); ?>
    			</div>
    		</div>
    	</div>
    </div>
</section>