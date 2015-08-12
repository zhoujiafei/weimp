<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');

if(!empty($model)) {
    foreach ($model AS $k => $v)
        ${$k} = $v;
}
$this->params = ['breadcrumb'  => [
                                    ['name' => '用户管理','url' => '#','current' => 0],
                                    ['name' => '用户列表','url' => Url::to(['members/index']),'current' => 0],
                                    ['name' => '用户详情','url' => '#','current' => 1],
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
				<h5>用户详情</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="###" method="post" class="form-horizontal" />
				   <div class="control-group">
						<label class="control-label">所属公众号</label>
						<div class="controls">
							<input type="text" value="<?= $cur_public['name'] ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">昵称</label>
						<div class="controls">
							<input type="text" value="<?= $nickname ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">头像</label>
						<div class="controls">
							<img src="<?= $headimgurl ?>" style="width:80px;height:60px;"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">性别</label>
						<div class="controls">
							<input type="text" value="<?= $sex ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">国家</label>
						<div class="controls">
							<input type="text" value="<?= $country ?>" />
						</div>
					</div>
			      <div class="control-group">
						<label class="control-label">省份</label>
						<div class="controls">
							<input type="text" value="<?= $province ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">城市</label>
						<div class="controls">
							<input type="text" value="<?= $city ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">备注</label>
						<div class="controls">
							<input type="text" value="<?= $remark ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">是否订阅</label>
						<div class="controls">
						   <?php $remark = $remark ? '是' : '否'; ?>
							<input type="text" value="<?= $remark ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">是否订阅</label>
						<div class="controls">
						   <?php $remark = $remark ? '是' : '否'; ?>
							<input type="text" value="<?= $remark ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">所属分组</label>
						<div class="controls">
							<input type="text" value="<?= $member_group['name'] ?>" />
						</div>
					</div>
				</form>
			</div>
		</div>						
	</div>
</div>