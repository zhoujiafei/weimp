<?php
use backend\widgets\LinkPager;
use backend\widgets\Delete;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');
AppAsset::addScript($this,'@web/js/jquery.dataTables.min.js');
AppAsset::addScript($this,'@web/js/unicorn.tables.js');

$this->params = ['breadcrumb'  => [
                                    ['name' => '素材管理','url' => '#','current' => 0],
                                    ['name' => '永久素材','url' => '#','current' => 1],
                                  ]
                ];
?>
<div class="row-fluid">
<div class="span12">
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-th"></i>
			</span>
			<h5>永久素材列表</h5>
			<a class="btn btn-info label" href="<?= Url::to(['forever-material/form','pid' => Yii::$app->controller->pid]);?>">创建</a>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped with-check">
				<thead>
					<tr>
						<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
						<th>素材名称</th>
						<th>素材类型</th>
						<th>上传时间</th>
						<th>操作</th>
					</tr>