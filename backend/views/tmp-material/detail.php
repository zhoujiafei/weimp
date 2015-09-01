<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');
if(!empty($model)) {
    foreach ($model AS $k => $v)
        ${$k} = $v;
}
$this->params = ['breadcrumb'  => [
                                    ['name' => '素材管理','url' => '#','current' => 0],
                                    ['name' => '临时素材','url' => Url::to(['tmp-material/index','pid' => Yii::$app->controller->pid]),'current' => 0],
                                    ['name' => '查看临时素材','url' => '#','current' => 1]
                                  ],
                ];
?>
<script>
$(document).ready(function(){
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	$('select').select2();
});
</script>
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-align-justify"></i>								
				</span>
				<h5>查看临时素材</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="###" method="post" class="form-horizontal" />
					<div class="control-group">
						<label class="control-label">素材名称</label>
						<div class="controls">
							<input type="text" value="<?= $name ?>" readonly />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">素材</label>
						<div class="controls">
    						<?php $url = Yii::$app->params['upload_url'] . $model->material->filepath . $model->material->filename;?>
    						<?php if ($type == 'image' || $type == 'thumb'):?>
    						<img src="<?= $url ?>" />
    						<?php elseif ($type == 'video'):?>
    						<video src="<?= $url ?>" controls="controls">
                            	您的浏览器不支持 video 标签。
                            </video>
    						<?php elseif ($type == 'voice'):?>
    						<audio src="<?= $url ?>" controls="controls">
                            	您的浏览器不支持 audio 标签。
                            </audio>
    						<?php endif;?>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" name="id" value="<?= $id ?>" />
						<input type="hidden" name="pid" value="<?= Yii::$app->controller->pid ?>" />
						<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
					</div>
				</form>
			</div>
		</div>						
	</div>
</div>