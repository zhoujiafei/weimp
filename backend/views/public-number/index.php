<?php
use yii\widgets\LinkPager;
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
      			<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" id="DataTables_Table_0_paginate">
         			<a tabindex="0" class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_first">First</a>
         			<a tabindex="0" class="previous fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_previous">Previous</a>
         			<span>
            			<a tabindex="0" class="fg-button ui-button ui-state-default ui-state-disabled">1</a>
            			<a tabindex="0" class="fg-button ui-button ui-state-default">2</a>
            			<a tabindex="0" class="fg-button ui-button ui-state-default">3</a>
            			<a tabindex="0" class="fg-button ui-button ui-state-default">4</a>
            			<a tabindex="0" class="fg-button ui-button ui-state-default">5</a>
         			</span>
         			<a tabindex="0" class="next fg-button ui-button ui-state-default" id="DataTables_Table_0_next">Next</a>
         			<a tabindex="0" class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default" id="DataTables_Table_0_last">Last</a>
      			</div>
			</div>
						
		</div>
	</div>
</div>
</div>
				

