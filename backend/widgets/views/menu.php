<?php
use yii\helpers\Url;
?>
<div id="sidebar">
<?php if (!empty($menus)):?>
  <ul>
  <?php foreach ($menus AS $k => $v): ?>
     <?php if (isset($v['submenus'])): ?>
         <?php 
            $parent_active = ($active == $v['mark']) ? 'active' : '';
            if (empty($parent_active)) {
               $submarks = array_map(function($a){return $a['mark'];}, $v['submenus']);
               if (in_array($active,$submarks))
                  $parent_active = 'active';
            }
         ?>
   		<li class="submenu <?= $parent_active; ?>">
   			<a href="#"><i class="icon <?= $v['icon'];?>"></i> <span><?= $v['name']; ?></span> <span class="label"><?= count($v['submenus']); ?></span></a>
   			<ul <?php if(!empty($parent_active)): ?>style="display:block;" <?php endif;?>>
   			   <?php foreach ($v['submenus'] AS $kk => $vv): ?>
   			   <li class="<?php if($active == $vv['mark']): ?>active<?php endif; ?>"><a href="<?= Url::to($vv['url']); ?>"><?= $vv['name'] ?></a></li>
   				<?php endforeach; ?>
   			</ul>
   		</li>
     <?php else: ?>
     	<li class="<?php if($active == $v['mark']): ?>active<?php endif; ?>"><a href="<?= Url::to($v['url']); ?>"><i class="icon <?= $v['icon'];?>"></i> <span><?= $v['name']; ?></span></a></li>
     <?php endif; ?>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
</div>