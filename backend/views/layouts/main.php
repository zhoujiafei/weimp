<?php
use backend\widgets\Breadcrumb;
use backend\widgets\Menu;
use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<?php $this->head() ?>
	<title><?= Yii::$app->name ?></title>
	<meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
	<?= Html::csrfMetaTags() ?>
</head>
<body>
	<?php $this->beginBody() ?>
	<div id="header">
		<h1><a href="javascript:void(0);"><?= Yii::$app->name ?></a></h1>	
	</div>
	
	<!-- 搜索框 -->
	<div id="search">
		<input type="text" placeholder="Search here..." /><button type="submit" class="tip-right" title="Search"><i class="icon-search icon-white"></i></button>
	</div>
	<!-- 搜索框 -->
	
	<!-- 右侧导航栏 -->
	<div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav btn-group">
            <li class="btn btn-inverse"><a title="" href="#"><i class="icon icon-user"></i> <span class="text">Profile</span></a></li>
            <li class="btn btn-inverse dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a class="sAdd" title="" href="#">new message</a></li>
                    <li><a class="sInbox" title="" href="#">inbox</a></li>
                    <li><a class="sOutbox" title="" href="#">outbox</a></li>
                    <li><a class="sTrash" title="" href="#">trash</a></li>
                </ul>
            </li>
            <li class="btn btn-inverse"><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
            <li class="btn btn-inverse"><a title="退出" href="<?php echo Url::to(['admin/logout']);?>"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
        </ul>
    </div>
    <!-- 右侧导航栏 -->
    
    <!-- 左侧菜单栏 -->
	<?php echo Menu::widget([
	       'active' => isset($this->params['active_menu']) ? $this->params['active_menu'] : null,
	]);?>
	<!-- 左侧菜单栏 -->
	
	<div id="content">
		<div id="content-header">
			<h1>Dashboard</h1>
			<div class="btn-group">
				<a class="btn btn-large tip-bottom" title="Manage Files"><i class="icon-file"></i></a>
				<a class="btn btn-large tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
				<a class="btn btn-large tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a>
				<a class="btn btn-large tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
			</div>
		</div>
		
		<!-- 面包屑 -->
		<?php echo Breadcrumb::widget();?>
		<!-- 面包屑 -->
		
		<div class="container-fluid">			
			<?php echo $content;?>
			<div class="row-fluid">
				<div id="footer" class="span12">
					2015 &copy; 加菲猫科技有限公司. Powerd by <a href="http://www.yiya520.com">周星星</a>
				</div>
			</div>
		</div>
	</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>