<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/select2.min.js');
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
                                    ['name' => '公众号设置','url' => Url::to(['public-number/index']),'current' => 0],
                                    ['name' => $op_text . '公众号','url' => '#','current' => 1]
                                  ],
                ];
?>
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-align-justify"></i>								
				</span>
				<h5><?= $op_text;?>公众号</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="<?= Url::to(['public-number/' . $action]) ?>" method="post" class="form-horizontal" />
					<div class="control-group">
						<label class="control-label">公众号名称</label>
						<div class="controls">
							<input type="text" placeholder="这里输入公众号名称..." name="name" value="<?= $name ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">AppID(应用ID)</label>
						<div class="controls">
							<input type="text" placeholder="这里输入AppID..." name="appid" value="<?= $appid ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">AppSecret(应用密钥)</label>
						<div class="controls">
							<input type="text" placeholder="这里输入AppSecret..." name="appsecret" value="<?= $appsecret ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">选择类型</label>
						<div class="controls">
							<select name="type">
								<option value=1 />订阅号
								<option value=2 />服务号
							</select>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" name="id" value="<?= $id ?>" />
						<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
						<button type="submit" class="btn btn-primary"><?= $op_text;?></button>
					</div>
				</form>
			</div>
		</div>						
	</div>
</div>