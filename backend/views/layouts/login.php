<?php
use backend\assets\LoginAsset;
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>登陆</title>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <body>
    	<?php $this->beginBody() ?>
        <?php echo $content;?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>