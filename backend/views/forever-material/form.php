<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/select2.css');
AppAsset::addScript($this,'@web/js/jquery.uniform.js');
AppAsset::addScript($this,'@web/js/select2.min.js');
AppAsset::addScript($this,'@web/js/unicorn.js');
AppAsset::addScript($this,'@web/js/jquery.tmpl.min.js');
AppAsset::addScript($this,'@web/js/forever-material/forevermaterial.js');

$action = 'create';
$op_text = '创建';
$this->params = ['breadcrumb'  => [
                                    ['name' => '素材管理','url' => '#','current' => 0],
                                    ['name' => '永久素材','url' => Url::to(['forever-material/index','pid' => Yii::$app->controller->pid]),'current' => 0],
                                    ['name' => $op_text . '永久素材','url' => '#','current' => 1]
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
				<h5>创建永久素材</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="<?= Url::to(['forever-material/' . $action]) ?>" method="post" class="form-horizontal" enctype="multipart/form-data" />
					<div class="control-group">
						<label class="control-label">素材名称</label>
						<div class="controls">
							<input type="text" placeholder="这里输入素材名称..." name="name" />
						</div>
					</div>
					<div class="control-group" id="material-type">
						<label class="control-label">选择类型</label>
						<div class="controls">
							<select name="type" id="material_type_selector">
							   <option value="notype" /> 选择素材类型
							   <?php foreach ($material_types AS $v): ?>
								<option value="<?= $v ?>" /><?= $v ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div id="material-tpl-content"></div>
					
					<div class="form-actions">
						<input type="hidden" name="id" value="<?= $id ?>" />
						<input type="hidden" name="pid" value="<?= Yii::$app->controller->pid ?>" />
						<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
						<button type="submit" class="btn btn-primary"><?= $op_text;?></button>
					</div>
				</form>
			</div>
		</div>						
	</div>
</div>
<!-- 图文小模板 -->
<script type="text/x-jquery-tmpl" id="news-tpl">
	<div class="control-group">
		<label class="control-label">图文标题</label>
		<div class="controls">
			<input type="text" placeholder="这里输入图文标题..." name="title[]" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">作者</label>
		<div class="controls">
			<input type="text" placeholder="这里输入作者..." name="author[]" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">摘要</label>
		<div class="controls">
			<input type="text" placeholder="这里输入摘要..." name="digest[]" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">显示封面</label>
		<div class="controls">
			<label><input type="radio" name="show_cover_pic[]" value=1 /> 是</label>
			<label><input type="radio" name="show_cover_pic[]" value=0 /> 否</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">内容</label>
		<div class="controls">
			<textarea name="content[]"></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">原文地址</label>
		<div class="controls">
			<input type="text" placeholder="这里输入原文地址..." name="content_source_url[]" />
		</div>
	</div>
</script>

<!-- 视频小模板 -->
<script type="text/x-jquery-tmpl" id="video-tpl">
	<div class="control-group" id="video_title">
		<label class="control-label">视频标题</label>
		<div class="controls">
			<input type="text" placeholder="这里输入视频标题..." name="title" />
		</div>
	</div>
	<div class="control-group" id="video_introduction">
		<label class="control-label">视频描述</label>
		<div class="controls">
			<textarea  placeholder="这里输入视频描述..." name="introduction"></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">上传文件</label>
		<div class="controls">
			<input type="file" name="FileData" />
		</div>
	</div>
</script>

<!-- 上传小模板 -->
<script type="text/x-jquery-tmpl" id="upload-tpl">
	<div class="control-group">
		<label class="control-label">上传文件</label>
		<div class="controls">
			<input type="file" name="FileData" />
		</div>
	</div>
</script>