<?php
namespace app\components\widgets\import;

use yii\helpers\Html; 
use yii\widgets\InputWidget; 

class Import extends InputWidget{
    
    private $_template = '<span>{file}{button}</span>';
    private $_file     = '<input type="file" id="{key}-file" class="hide">';
    private $_button   = '<a id="{key}-button" class="btn btn-primary" href="javascript:;"><i class="glyphicon glyphicon-open"></i>&nbsp; {label}</a>';
    
    public $_key         = 'import';
    public $_class       = 'hide';
    public $_label       = '导入';
    public $_action      = 'import';
    public $_data        = [];
    
    public function run(){
        parent::run();
        $this->renderWidget();
    }
    
    public function renderWidget(){
        if(!empty($this->_class)){
            $this->options['class'] = empty($this->options['class']) ? $this->_class : $this->_class.' '.$this->options['class'];
        }
        
        if(!empty($this->_data) && is_array($this->_data)){
            foreach($this->_data as $key => $value){
                $this->options['data-'.$key] = $value;
            }
        }
        
        $template = strtr(strtr($this->_template, ['{button}' => $this->_button]), ['{key}' => $this->_key, '{label}' => $this->_label]);
        
        $input = strtr($template, ['{file}' => Html::fileInput($this->name, null, $this->options)]);
        
        $this->renderAsset();
        echo $input;
    }
    
    public function renderAsset(){
        $view = $this->getView();
        
        WidgetAsset::register($view);
        
        $js = <<<JS
            $(function(){
                $('#{$this->_key}-button').click(function(){
                    $('#{$this->options['id']}').click();
            	});

            });

            $('#{$this->options['id']}').change(function(){
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
        			url: '{$this->_action}',
        			type: 'post',
        			timeout: 600000,
        			data: formData,
        			contentType: false,
        			processData: false,
        			success: function(result){
                        layer.close(load);
        				console.log(result);
                        that.val('');
        				if (result.status == 1) {
                            layer.alert(result.message, {
                        		icon: 1,
                        		yes: function(index, layero){
                        			layer.close(index);
                        			location.reload();
                        		}
                        	});
        				}else{
                            layer.msg(result.message, {icon: 2, offset: '100px'});
        				}  
        			},  
        			error: function(xhr) {
                        layer.close(load);
                        that.val('');
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
JS;
        
        $view->registerJs($js, $view::POS_END);
    }
    
}
