<?php
use backend\widgets\LinkPager;

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
			<span class="label label-info">Featured</span>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped with-check">
				<thead>
					<tr>
						<th>
   						<div class="checker" id="uniform-title-table-checkbox">
   						   <span><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" style="opacity: 0;"></span>
   						</div>
						</th>
						<th>公众号名称</th>
						<th>公众号类型</th>
						<th>公众号状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				   <?php if (!empty($models)):?>
				   <?php foreach ($models AS $k => $v): ?>
					<tr>
						<td>
   						<div class="checker"><span><input type="checkbox" style="opacity: 0;"></span></div>
						</td>
						<td><?= $v['name'] ?></td>
						<td><?= $v['type'] ?></td>
						<td><?= $v['status'] ?></td>
						<td>
						   <button class="btn btn-primary"><i class="icon-pencil icon-white"></i> Edit</button>
						   <button class="btn btn-danger"><i class="icon-remove icon-white"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
   			   <div class="dataTables_filter" style="margin-top:-4px;margin-left: 14px;">
      			   <label>搜索: <input type="text"></label>
      			</div>
      			<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" style="height:28px;">
         			<div class="pagination alternate">
								<?php
               			 echo LinkPager::widget(['pagination' => $pages]);
               			?>
						</div>
      			</div>
			</div>	
		</div>
	</div>
</div>
</div>
				

