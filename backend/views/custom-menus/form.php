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
                                    ['name' => '菜单管理','url' => '#','current' => 0],
                                    ['name' => '自定义菜单','url' => Url::to(['custom-menus/index','pid' => Yii::$app->controller->pid]),'current' => 0],
                                    ['name' => $op_text . '菜单','url' => '#','current' => 1]
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
				<h5><?= $op_text;?>菜单</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="<?= Url::to(['custom-menus/' . $action]) ?>" method="post" class="form-horizontal" />
					<div class="control-group">
						<label class="control-label">菜单名</label>
						<div class="controls">
							<input type="text" placeholder="这里输入菜单名..." name="title" value="<?= $title ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">选择父级菜单</label>
						<div class="controls">
							<select name="fid">
							   <option value=0 />一级菜单
							   <?php if (!empty($first_menus)): ?>
							   <?php foreach ($first_menus AS $k => $v): ?>
							   <?php $selected = $v['id'] == $fid ? 'selected="selected"' : '';?>
								<option value=<?= $v['id'] ?> <?= $selected ?>/><?= $v['title'] ?>
								<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">菜单类型</label>
						<div class="controls">
							<input type="text" placeholder="这里输入菜单类型..." name="type" value="<?= $type ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">url链接</label>
						<div class="controls">
							<input type="text" placeholder="这里输入链接..." name="url" value="<?= $url ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">菜单关键字</label>
						<div class="controls">
							<input type="text" placeholder="这里输入菜单关键字..." name="keyword" value="<?= $keyword ?>" />
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