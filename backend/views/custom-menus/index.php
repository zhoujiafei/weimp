<?php
use backend\widgets\Delete;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');
AppAsset::addScript($this,'@web/js/jquery.dataTables.min.js');
AppAsset::addScript($this,'@web/js/unicorn.tables.js');
AppAsset::addScript($this,'@web/js/custom-menus/custommenus.js');

$fid = intval(Yii::$app->request->get('fid',0));
if ($fid) {
   $this->params = ['breadcrumb'  => [
                                       ['name' => '一级菜单【' . $parent_menu['title'] . '】','url' => Url::to(['custom-menus/index','pid' => Yii::$app->controller->pid]),'current' => 0],
                                       ['name' => '二级菜单','url' => '#','current' => 1]
                                     ]
                   ];
}else{
   $this->params = ['breadcrumb'  => [['name' => '一级菜单','url' => '#','current' => 1]]];
}

?>
<div class="row-fluid">
<div class="span12">
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-th"></i>
			</span>
			<h5>自定义菜单列表</h5>
			<a class="btn btn-info label" href="<?= Url::to(['custom-menus/form','pid' => Yii::$app->controller->pid,'fid' => $fid]);?>">创建</a>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped with-check">
				<thead>
					<tr>
						<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
						<th>菜单名</th>
						<th>菜单类型</th>
						<th>菜单级别</th>
						<th>所属菜单</th>
						<th>菜单关键字</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				   <?php if (!empty($models)):?>
				   <?php foreach ($models AS $k => $v): ?>
					<tr id="tr_<?= $v['id'] ?>">
						<td><input type="checkbox" /></td>
						<td><?= $v['title'] ?></td>
						<td><?= $v['type'] ?></td>
						<td><?= $v['level'] ?></td>
						<td><?= $v['parent'] ?></td>
						<td><?= $v['keyword'] ?></td>
						<td>
						<a href="<?= Url::to(['custom-menus/form','id' => $v['id'],'pid' => Yii::$app->controller->pid,'fid' => $fid]);?>" class="btn btn-primary">
						      <i class="icon-pencil icon-white"></i> 编辑
						</a>
						<a href="javascript:void(0);" _id=<?= $v['id'] ?> class="btn btn-danger remove-row"><i class="icon-remove icon-white"></i> 删除</a>
						<?php if (empty($fid)): ?>
						<a href="<?= Url::to(['custom-menus/index','fid' => $v['id'],'pid' => Yii::$app->controller->pid]);?>" class="btn btn-success">
						      <i class="icon-search icon-white"></i> 查看子级菜单
						</a>
						<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
					   <td colspan="7">
   					   <div class="alert alert-info" style="margin-top:22px;">
   							<button class="close" data-dismiss="alert">×</button>
   							<strong>友情提醒！</strong> 您还未创建一个菜单！
   						</div>
					   </td>
			      </tr>
					<?php endif; ?>
					
				</tbody>
			</table>
			<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
   			   <div class="dataTables_filter" style="margin-top:-4px;margin-left: 14px;">
      			   <button class="btn btn-success" id="sycn-menus">同步线上菜单</button>
      			</div>
      			<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" style="height:22px;"></div>
			</div>
			<input type="hidden" class="delete-action" value="<?= Url::to(['custom-menus/delete','pid' => Yii::$app->controller->pid]);?>" />
			<input type="hidden" class="sync-menus-action" value="<?= Url::to(['custom-menus/sync-menus','pid' => Yii::$app->controller->pid]);?>" />
			<input type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="SyncMenusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">同步确认</h4>
      </div>
      <div class="modal-body">
        您确定要同步菜单吗？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary confirm-sync-menus" >确定</button>
      </div>
    </div>
  </div>
</div>
<div class="alert alert-success" id="SyncSuccess" style="display:none;">
	<button class="close" data-dismiss="alert">×</button>
	<strong>同步成功!</strong>
</div>
<div class="alert alert-error" id="SyncFail" style="display:none;">
	<button class="close" data-dismiss="alert">×</button>
	<strong>同步失败!</strong> <strong class="error-msg"><strong>
</div>
<?php echo Delete::widget();?>