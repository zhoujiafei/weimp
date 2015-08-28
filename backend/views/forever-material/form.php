<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');

$action = 'create';
$op_text = '创建';
$this->params = ['breadcrumb'  => [
                                    ['name' => '素材管理','url' => '#','current' => 0],
                                    ['name' => '永久素材','url' => Url::to(['forevel-material/index','pid' => Yii::$app->controller->pid]),'current' => 0],
                                    ['name' => $op_text . '素材','url' => '#','current' => 1]
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
				<h5>创建永久素材</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="<?= Url::to(['tmp-material/' . $action]) ?>" method="post" class="form-horizontal" enctype="multipart/form-data" />
					<div class="control-group">
						<label class="control-label">素材名称</label>
						<div class="controls">
							<input type="text" placeholder="这里输入素材名称..." name="name" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">选择类型</label>
						<div class="controls">
							<select name="type" id="material_type_selector">
							   <option value="notype" /> 选择素材类型
							   <?php foreach ($material_types AS $v): ?>
								<option value="<?= $v ?>" /><?= $v ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">上传文件</label>
						<div class="controls">
							<input type="file" name="FileData" />
						</div>
					</div>
					
					<div class="form-actions">
						<input type="hidden" name="id" value="<?= $id ?>" />
						<input type="hidden" name="pid" value="<?= Yii::$app->controller->pid ?>" />
						<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
						<button type="submit" class="btn btn-primary"><?= $op_text;?></button>
					</div>
				</form>
			</div>
		</div>						
	</div>
</div>