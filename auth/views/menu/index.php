<?php
use yii\helpers\Html;
use yii\helpers\Url;
use sunnnnn\admin\auth\assets\MenuAsset;
MenuAsset::register($this);

$this->title = '菜单列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="content">
	<div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
					
					<div class="box-tools">
						<?= Html::a('<i class="fa fa-plus"></i> 添加菜单', ['/auth/menu/add'], [
								'class' => 'btn btn-success ajax-add', 
						]) ?>
					</div>
				</div>
				
				<div class="box-body table-responsive no-padding">
					<ul class="mtree bubba">
						<?= $items; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
</section>
<?php $this->beginBlock('menu');?>
	$('.btn-edit').click(function(){
		var key = $(this).data('key');
		location.href = '<?= Url::to(['/auth/menu/edit']) ?>' + '?id=' + key;
	});

	$('.btn-delete').click(function(){
		var that = $(this);
		var father = that.parent().parent().parent();
		var key = that.data('key');
		layer.confirm('确认删除数据？', {
			  btn: ['确定','取消']
		}, function(){
			layer.closeAll();
			var load = layer.load();
			$.ajax({
				url: '<?= Url::to(['/auth/menu/delete']); ?>',
				type: 'post',
				data: {'id':key, '_csrf':_csrf},
				dataType: 'json',
				success: function(result){
					layer.close(load);
					if(result.status == 1){
						father.remove();
						layer.msg('删除成功', {icon: 1, offset: '100px'});
					}else{
						layer.msg(result.message, {icon: 2, offset: '100px'});
					}  
				},  
				error: function(xhr) {
					layer.close(load);
					if(xhr.status == '403'){
						layer.msg('您没有足够的权限', {icon: 2, offset: '100px'});
					}else{
			        	layer.msg('网络错误，请稍后再试', {icon: 2, offset: '100px'});
					}
				}  
			});
		});
	});
<?php $this->endBlock();?>
<?php $this->registerJs($this->blocks['menu'], yii\web\View::POS_END);?>