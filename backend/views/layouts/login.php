<?php
use backend\assets\LoginAsset;
use yii\helpers\Html;
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <?= Html::csrfMetaTags() ?>
    <title>登陆</title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
	<?php echo $content;?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
