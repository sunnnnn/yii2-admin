<?php
namespace backend\components\widgets\upload;

use Yii;
use yii\helpers\Html; 
use yii\widgets\InputWidget; 
use yii\web\UploadedFile;
use backend\models\UploadForm;

class Upload extends InputWidget{
    
    private $_template = '<div class="form-group">{file}<div class="input-group">{input}<span class="input-group-btn">{button}</span></div></div>';
    private $_file     = '<input type="file" id="{key}-file" class="hide">';
    private $_button   = '<a id="{key}-button" class="btn btn-primary" href="javascript:;"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; 选择 …</a>';
    
    public $_key         = 'form-upload';
    public $_class       = 'form-control';
    public $_placeholder = '请直接输入文件链接地址，或选择本地文件';
    public $_action      = 'uplaod';
    public $_data        = [];
    
    public function run(){
        parent::run();
        $this->renderWidget();
    }
    
    public function renderWidget(){
        if(!empty($this->_class)){
            $this->options['class'] = empty($this->options['class']) ? $this->_class : $this->_class.' '.$this->options['class'];
        }
        
        if(!empty($this->_placeholder) && empty($this->options['placeholder'])){
            $this->options['placeholder'] = $this->_placeholder;
        }
        
        if(!empty($this->_data) && is_array($this->_data)){
            foreach($this->_data as $key => $value){
                $this->options['data-'.$key] = $value;
            }
        }
        
        $template = strtr(strtr($this->_template, ['{file}' => $this->_file, '{button}' => $this->_button]), ['{key}' => $this->_key]);
        
        if($this->hasModel()){
            $input = strtr($template, ['{input}' => Html::activeTextInput($this->model, $this->attribute, $this->options)]);
        }else{
            $input = strtr($template, ['{input}' => Html::textInput($this->name, null, $this->options)]);
        }
        
        $this->renderAsset();
        echo $input;
    }
    
    public function renderAsset(){
        $view = $this->getView();
        
        WidgetAsset::register($view);
        
        $js = <<<JS
            $(function(){
                $('#{$this->_key}-button').click(function(){
            		$('#{$this->_key}-file').click();
            	});

            });

            $('#{$this->_key}-file').change(function(){
        		var that = $(this);
        		if(!that.val()){
        			return false;
        		}
        		var formData = new FormData();
        		formData.append('UploadForm[file]', that.get(0).files[0]); 
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
        					$('#{$this->options['id']}').val(result.path);
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
    
    public static function upload($path = '', $scenario = UploadForm::SCENARIO_IMAGE, $basename = false){
        set_time_limit(0);
        $model = new UploadForm(['scenario' => $scenario]);
        $model->file = UploadedFile::getInstance($model, 'file');
        if (!empty($model->file) && $model->validate()) {
            try{
                $path = Yii::$app->helper->file()->upload($model->file, $path, $basename);
                return $path;
            }catch(\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }else{
            $errors = $model->getErrors();
            if(!empty($errors)){
                foreach($errors as $error){
                    $error = is_array($error) ? array_pop($error) : $error;
                    throw new \Exception($error);
                    break;
                }
            }
        }
    }
    
}
