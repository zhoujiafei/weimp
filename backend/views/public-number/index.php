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

$this->params = ['breadcrumb'  => [['name' => '公众号设置','url' => '#','current' => 1]]];
?>
<div class="row-fluid">
<div class="span12">
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-th"></i>
			</span>
			<h5>公众号列表</h5>
			<a class="btn btn-info label" href="<?= Url::to(['public-number/form']);?>">创建</a>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped with-check">
				<thead>
					<tr>
						<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
						<th>公众号名称</th>
						<th>公众号类型</th>
						<th>公众号状态</th>
						<th>是否已接入开发平台</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				   <?php if (!empty($models)):?>
				   <?php foreach ($models AS $k => $v): ?>
					<tr id="tr_<?= $v['id'] ?>">
						<td><input type="checkbox" /></td>
						<td><?= $v['name'] ?></td>
						<td><?= $v['type_text'] ?></td>
						<td><?= $v['status_text'] ?></td>
						<td><?= $v['is_access_text'] ?></td>
						<td>
						   <a href="<?= Url::to(['public-number/form','id' => $v['id']]);?>" class="btn btn-primary"><i class="icon-pencil icon-white"></i> 编辑</a>
						   <a href="javascript:void(0);" _id=<?= $v['id'] ?> class="btn btn-danger remove-row"><i class="icon-remove icon-white"></i> 删除</a>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
					   <td colspan="6">
   					   <div class="alert alert-info" style="margin-top:22px;">
   							<button class="close" data-dismiss="alert">×</button>
   							<strong>友情提醒！</strong> 您还未创建一条公众号！
   						</div>
					   </td>
			      </tr>
					<?php endif; ?>
					
				</tbody>
			</table>
			<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
			      <!--
   			   <div class="dataTables_filter" style="margin-top:-4px;margin-left: 14px;">
      			   <label>搜索: <input type="text"></label>
      			</div>
      			-->
      			<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers">
         			<div class="pagination alternate">
						<?php echo LinkPager::widget(['pagination' => $pages]);?>
						</div>
      			</div>
			</div>
			<input type="hidden" class="delete-action" value="<?= Url::to(['public-number/delete']);?>" />
			<input type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
		</div>
	</div>
</div>
</div>
<?php echo Delete::widget();?>