<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Admin;

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
	<div class="row">
        <div class="col-md-6">
			<?php $form = ActiveForm::begin([
				'action' => Url::to(['/admin/index']),
				'method' => 'get',
				'enableClientValidation' => false,
			]); ?>
                            
			<?= $form->field($searchModel, 'keywords',[  
	            'template' => '<div class="input-group">{input}<span class="input-group-btn">'.Html::submitButton('<i class="fa fa-search"></i> 搜索', ['class' => 'btn btn-info btn-flat']).'</span></div>',  
	            'inputOptions' => ['class' => 'form-control', 'placeholder' => '输入管理员名称进行搜索'],
	        ])->textInput(); ?>

		    <?php ActiveForm::end(); ?>
        </div>
    </div>


	<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
					
					<div class="box-tools">
						<?= Html::a('<i class="fa fa-plus"></i> 添加管理员', ['/admin/add'], ['class' => 'btn btn-success']) ?>
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
								"headerOptions" => ["width" => "15%"],
							],
							[
								"attribute" => "username",
								"headerOptions" => ["width" => "25%"],
							],
							[
								"attribute" => "role",
								"headerOptions" => ["width" => "15%"],
								"contentOptions" => [],
								"format" => "raw",
								'value' => function($model) {
									return isset($model->roles->name) ? $model->roles->name : '未分配';
								},
							],
							[
								"attribute" => "status",
								"headerOptions" => ["width" => "15%"],
								"format" => "raw",
								'value' => function($model) {
									return Admin::$statusArr[$model->status];
								},
							],
							[
								'class' => 'yii\grid\ActionColumn',
								"template" => "{update} {delete}",
								"header" => "操作",
								"buttons" => [
									"update" => function ($url, $model, $key){
										return Html::a('<i class="fa fa-pencil"></i> 编辑', ['/admin/edit', 'id' => $model->id], [
											"class" => "btn btn-sm btn-primary"
										]);
									},
									"delete" => function($url, $model, $key){
										return Html::a('<i class="fa fa-trash-o"></i> 删除', 'javascript:;', [
											'class' => 'btn btn-sm btn-danger ajax-table-delete',
										    'data-action' => Url::to(['/admin/delete'])
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