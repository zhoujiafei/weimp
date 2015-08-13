<?php
use backend\widgets\LinkPager;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');
AppAsset::addScript($this,'@web/js/jquery.dataTables.min.js');
AppAsset::addScript($this,'@web/js/unicorn.tables.js');

$this->params = ['breadcrumb'  => [
                                    ['name' => '用户管理','url' => '#','current' => 0],
                                    ['name' => '用户列表','url' => '#','current' => 1],
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
			<h5>用户列表</h5>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped with-check">
				<thead>
					<tr>
						<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
						<th>用户昵称</th>
						<th>是否订阅</th>
						<th>订阅时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				   <?php if (!empty($models)):?>
				   <?php foreach ($models AS $k => $v): ?>
					<tr id="tr_<?= $v['id'] ?>">
						<td><input type="checkbox" /></td>
						<td><?= $v['nickname'] ?></td>
						<td><?= $v['is_subscribe_text'] ?></td>
						<td><?= $v['subscribe_time_text'] ?></td>
						<td>
						   <a href="<?= Url::to(['members/form','id' => $v['id'],'pid' => Yii::$app->controller->pid]);?>" class="btn btn-primary"><i class="icon-pencil icon-white"></i> 查看</a>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
					   <td colspan="5">
   					   <div class="alert alert-info" style="margin-top:22px;">
   							<button class="close" data-dismiss="alert">×</button>
   							<strong>友情提醒！</strong> 还没有人订阅您的公众号
   						</div>
					   </td>
			      </tr>
					<?php endif; ?>
					
				</tbody>
			</table>
			<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
      			<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers">
         			<div class="pagination alternate">
						<?php echo LinkPager::widget(['pagination' => $pages]);?>
						</div>
      			</div>
			</div>
			<input type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
		</div>
	</div>
</div>
</div>