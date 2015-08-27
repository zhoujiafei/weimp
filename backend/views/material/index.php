<?php
use yii\helpers\Html;
use common\helpers\Common;
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
                                    ['name' => '本地素材','url' => '#','current' => 1],
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
			<h5>本地素材列表</h5>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped with-check">
				<thead>
					<tr>
						<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
						<th>文件名</th>
						<th>素材类型</th>
						<th>文件大小</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				   <?php if (!empty($models)):?>
				   <?php foreach ($models AS $k => $v): ?>
					<tr id="tr_<?= $v['id'] ?>">
						<td><input type="checkbox" /></td>
						<td><?= Html::encode($v['name']); ?></td>
						<td><?= $v['type'] ?></td>
						<td><?= Common::fileSizeConv($v['filesize']); ?></td>
						<td><?= $v['create_time'] ?></td>
						<td>
						   <a href="<?= Url::to(['material/form','id' => $v['id'],'pid' => Yii::$app->controller->pid]);?>" class="btn btn-primary"><i class="icon-pencil icon-white"></i> 查看详情</a>
						   <a href="javascript:void(0);" _id=<?= $v['id'] ?> class="btn btn-danger remove-row"><i class="icon-remove icon-white"></i> 删除</a>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
					   <td colspan="5">
   					   <div class="alert alert-info" style="margin-top:22px;">
   							<button class="close" data-dismiss="alert">×</button>
   							<strong>友情提醒！</strong> 目前还没有本地素材！
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
			<input type="hidden" class="delete-action" value="<?= Url::to(['material/delete','pid' => Yii::$app->controller->pid]);?>" />
			<input type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
		</div>
	</div>
</div>
</div>
<?php echo Delete::widget();?>