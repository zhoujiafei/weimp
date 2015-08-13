<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');

if(!empty($model)) {
    $action = 'update';
    $op_text = '更新';
    foreach ($model AS $k => $v)
        ${$k} = $v;
}else{
    $action = 'create';
    $op_text = '创建';
}
$this->params = ['breadcrumb'  => [
                                    ['name' => '用户管理','url' => '#','current' => 0],
                                    ['name' => '用户分组','url' => Url::to(['members-group/index']),'current' => 0],
                                    ['name' => $op_text . '分组','url' => '#','current' => 1]
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
				<h5><?= $op_text;?>分组</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="<?= Url::to(['members-group/' . $action]) ?>" method="post" class="form-horizontal" />
					<div class="control-group">
						<label class="control-label">分组名称</label>
						<div class="controls">
							<input type="text" placeholder="这里输入分组名称..." name="name" value="<?= $name ?>" />
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