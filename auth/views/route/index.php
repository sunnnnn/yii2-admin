<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = '路由映射列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="content">
	<div class="row">
        <div class="col-md-6">
			<?php $form = ActiveForm::begin([
				'action' => Url::to(['/auth/route/index']),
				'method' => 'get',
				'options'=>['class' => 'table-search'],
				'enableClientValidation' => false,
			]); ?>
			<div class="input-group">
				<?= Html::activeTextInput($searchModel, 'keywords', ['class' => 'form-control', 'placeholder' => '输入路由名称或者路径进行搜索']); ?>
	        	<span class="input-group-btn">
	        		<?= Html::submitButton('<i class="fa fa-search"></i> 搜索', ['class' => 'btn btn-info btn-flat']); ?>
	        	</span>
			</div>
		    <?php ActiveForm::end(); ?>
        </div>
    </div>

	<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
					
					<div class="box-tools">
						<?= Html::a('<i class="fa fa-plus"></i> 添加路由', ['/auth/route/add'], [
								'class' => 'btn btn-success', 
						]) ?>
					</div>
				</div>
				
				<div class="box-body table-responsive no-padding">
					<?= GridView::widget([
						'summary' => false,
						'tableOptions' => ['class' => 'table table-hover'],
						'dataProvider' => $dataProvider,
						'columns' => [
							[
								"attribute" => "id",
								"headerOptions" => ["width" => "10%"],
								"contentOptions" => [],
							],
							[
								"attribute" => "name",
								"headerOptions" => ["width" => "30%"],
							],
							[
								"attribute" => "route",
								"headerOptions" => ["width" => "40%"],
							],
							[
								'class' => 'yii\grid\ActionColumn',
								"template" => "{update} {delete}",
								"header" => "操作",
								"buttons" => [
									"update" => function ($url, $model, $key){
                                        return Html::a('<i class="fa fa-pencil"></i> 编辑', ['/auth/route/edit', 'id' => $model->id], [
											"class" => "btn btn-sm btn-primary"
										]);
									},
									"delete" => function($url, $model, $key){
										return Html::a('<i class="fa fa-trash-o"></i> 删除', 'javascript:;', [
											'class' => 'btn btn-sm btn-danger ajax-table-delete',
										    'data-action' => Url::to(['/auth/route/delete'])
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