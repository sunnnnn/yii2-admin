<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = '路由映射列表';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
	'id' => 'operate-modal',
	'header' => '<h4 class="modal-title"></h4>',
]);
Modal::end();
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
						<?= Html::a('<i class="fa fa-plus"></i> 添加路由', 'javascript:;', [
								'class' => 'btn btn-success ajax-add', 
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
										return Html::a('<i class="fa fa-pencil"></i> 编辑', 'javascript:;', [
											"class" => "btn btn-sm btn-primary ajax-edit"
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
<?php $this->beginBlock('form') ?> 
$(function(){
	$('.ajax-add').click(function(){
		var load = layer.load();
		$.get(
			'<?= Url::to(['/auth/route/add']); ?>',
			function(result){
				layer.close(load);
				$('.modal-body').html(result);
				$('#operate-modal').modal();
			}
		).error(function(xhr){
			layer.close(load);
			if(xhr.status == '403'){
				layer.msg('您没有足够的权限', {icon: 2, offset: '100px'});
			}else if(xhr.status == '404'){
				layer.msg('请求的页面不存在', {icon: 2, offset: '100px'});
			}else{
	        	layer.msg('网络错误，请稍后再试', {icon: 2, offset: '100px'});
			}
		});
	});
	
	$('.ajax-edit').click(function(){
		var id = $(this).closest('tr').data('key');
		var load = layer.load();
		$.get(
			'<?= Url::to(['/auth/route/edit']); ?>',
			{'id': id},
			function(result){
				layer.close(load);
				$('.modal-body').html(result);
				$('#operate-modal').modal();
			}
		).error(function(xhr){
			layer.close(load);
			if(xhr.status == '403'){
				layer.msg('您没有足够的权限', {icon: 2, offset: '100px'});
			}else if(xhr.status == '404'){
				layer.msg('请求的页面不存在', {icon: 2, offset: '100px'});
			}else{
	        	layer.msg('网络错误，请稍后再试', {icon: 2, offset: '100px'});
			}
		});
	});
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['form'], \yii\web\View::POS_END); ?> 