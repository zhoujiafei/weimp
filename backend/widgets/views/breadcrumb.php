<div id="breadcrumb">
	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a>
	<?php if(!empty($nav)):?>
	<?php foreach ($nav AS $k => $v) :?>
	   <?php $current = $v['current'] ? 'current' : '';?>
		<a href="<?= $v['url'];?>" class="tip-bottom <?= $current; ?>"><?= $v['name'];?></a>
	<?php endforeach;?>
	<?php endif;?>
</div>