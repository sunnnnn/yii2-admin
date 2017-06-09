$(function(){
	$(window).on('load', function() {
		if($(".loading-screen").length){
		    $(".loading-screen").fadeOut("slow");
		}
	});
	
	if($('.select2').length){
		$('.select2').select2();
	}
	
	$('.ajax-form-submit').click(function(){
    	var that = $(this);
		var form = $('.ajax-form');
    	that.attr('disabled', 'disabled');
    	var load = layer.load();
		$.ajax({
	        type: 'post',
	        url: form.data('action'),
	        data: form.serialize(),
	        dataType: 'json',
	        error: function(xhr) {
	        	layer.close(load);
	        	that.attr('disabled', null);
				if(xhr.status == '403'){
					layer.msg('您没有足够的权限', {icon: 2, offset: '100px'});
				}else if(xhr.status == '404'){
					layer.msg('请求页面未找到', {icon: 2, offset: '100px'});
				}else{
		        	layer.msg('网络错误，请稍后再试', {icon: 2, offset: '100px'});
				}
	        },
	        success: function(result) {
		        if(result.url){
					if(result.message){
						layer.close(load);
	        			that.attr('disabled', null);
						layer.msg(result.message, {icon: 1, offset: '100px'});
					}
					if(result.url == '@'){
						history.back();
					}else if(result.url.substr(0, 1) == '/'){
			        	location.href = result.url;
					}
		        }else{
		        	layer.close(load);
	        		that.attr('disabled', null);
		        	layer.msg(result.message, {icon: 2, offset: '100px'});
		        }
	        }
	    });
	});
	
	$('.ajax-table-delete').on('click', function(){
		var that = $(this);
		var father = that.parent().parent();
		layer.confirm('确认删除数据？', {
			  btn: ['确定','取消']
		}, function(){
			layer.closeAll();
			var load = layer.load();
			$.ajax({
				url: that.data('action'),
				type: 'post',
				data: {'id':father.data('key'), '_csrf':_csrf},
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
					}else if(xhr.status == '404'){
						layer.msg('请求页面未找到', {icon: 2, offset: '100px'});
					}else{
			        	layer.msg('网络错误，请稍后再试', {icon: 2, offset: '100px'});
					}
				}  
			});
		});
	});
	
	$('.ajax-file-button').click(function(){
		$('.ajax-file-input').click();
	});
	
	$('.ajax-file-input').change(function(){
		var that = $(this);
		if(!that.val()){
			return false;
		}
		var formData = new FormData();
		formData.append('UploadForm[file]', that.get(0).files[0]); 
		$.each(that.data(), function(k, v){
			formData.append('Data['+ k +']', v); 
		});
		var load = layer.load();
		$.ajax({
			url: that.data('action'),
			type: 'post',
			timeout: 600000,
			data: formData,
			contentType: false,
			processData: false,
			success: function(result){
				layer.close(load);
				console.log(result);
				if (result.status == 1) {
					ajax_file_success(result);
				}else{
					layer.msg(result.message, {icon: 2, offset: '100px'});
				}  
			},  
			error: function(xhr) {
				layer.close(load);
				if(xhr.status == '403'){
					layer.msg('您没有足够的权限', {icon: 2, offset: '100px'});
				}else if(xhr.status == '404'){
					layer.msg('请求页面未找到', {icon: 2, offset: '100px'});
				}else{
		        	layer.msg('网络错误，请稍后再试', {icon: 2, offset: '100px'});
				}
			}  
		});
	});
});