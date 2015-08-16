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

$fid = intval(Yii::$app->request->get('fid',0));
if (!empty($fid)) {
   $this->params = ['breadcrumb'  => [
                                       ['name' => '一级菜单【' . $parent_menu['title'] . '】','url' => Url::to(['custom-menus/index','pid' => Yii::$app->controller->pid]),'current' => 0],
                                       ['name' => '二级菜单','url' => Url::to(['custom-menus/index','pid' => Yii::$app->controller->pid,'fid' => $fid]),'current' => 0],
                                       ['name' => $op_text . '菜单','url' => '#','current' => 1]
                                     ]
                   ];
}else{
   $this->params = ['breadcrumb'  => [
                                       ['name' => '一级菜单','url' => Url::to(['custom-menus/index','pid' => Yii::$app->controller->pid,]),'current' => 0],
                                       ['name' => $op_text . '菜单','url' => '#','current' => 1]
                                     ]
                   ];
}
?>
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
						<label class="control-label">所属父级菜单</label>
						<div class="controls">
						   <?php $parent_menu_title = !empty($parent_menu) ? $parent_menu['title'] : '无';?>
							<input type="text" readonly value="<?= $parent_menu_title ?>" />
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
						<input type="hidden" name="fid" value="<?= $fid ?>" />
						<input type="hidden" name="pid" value="<?= Yii::$app->controller->pid ?>" />
						<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
						<button type="submit" class="btn btn-primary"><?= $op_text;?></button>
					</div>
				</form>
			</div>
		</div>						
	</div>
</div>