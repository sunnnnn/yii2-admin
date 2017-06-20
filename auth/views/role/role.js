$(function(){
	var init = function(){
		search('avaliable');
		search('assigned');
	}
	
	var search = function(target){
		var $list = $('select.list[data-target="' + target + '"]');
	    $list.html('');
	    var q = $('.search[data-target="' + target + '"]').val();
	
	    $.each(_opts[target], function (route, value) {
	        if (value.label.indexOf(q) >= 0) {
				$list.append($('<option>').text(value.label).val(value.id).data('route', route));
	        }
	    });
	}
	
	$('.search[data-target]').keyup(function () {
	    search($(this).data('target'));
	});
	
	$('.btn-assigned').click(function () {
	    var $this = $(this);
	    var assigned_list = $('select.list[data-target="assigned"]');
	    var avaliable_list = $('select.list[data-target="avaliable"]');
		
		var options = avaliable_list.find('option:selected');
		
		if (options && options.length) {
			$.each(options, function(){
				var route = $(this).data('route');
				var id  = $(this).val();
				var label  = $(this).html();
				delete _opts.avaliable[route];
				_opts.assigned[route] = {'id':id, 'label':label};
			});
		}
		console.log(_opts);
		init();
	});
	
	$('.btn-avaliable').click(function () {
	    var $this = $(this);
	    var assigned_list = $('select.list[data-target="assigned"]');
	    var avaliable_list = $('select.list[data-target="avaliable"]');
		
		var options = assigned_list.find('option:selected');
		
		if (options && options.length) {
			$.each(options, function(){
				var route = $(this).data('route');
				var id  = $(this).val();
				var label  = $(this).html();
				delete _opts.assigned[route];
				_opts.avaliable[route] = {'id':id, 'label':label};
			});
		}
		console.log(_opts);
		init();
	});
	
	
	$('.route-form-submit').click(function(){
    	var that = $(this);
		var form = $('.route-form');
		$('select.list[data-target="assigned"]').find('option').each(function(){
			$(this).attr('selected', 'selected');
		});
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
	
	
	init();
});
