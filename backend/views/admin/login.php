<?php use yii\helpers\Url;?>
<div id="logo">
    <img src="<?php echo Yii::$app->request->baseUrl; ?>/img/logo.png" alt="加菲猫微信综合管控平台" />
</div>
<div id="loginbox">            
    <form id="loginform" class="form-vertical" action="<?php echo Url::to(['admin/login']);?>" method="post" />
		<p>请输入用户名和密码</p>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" placeholder="请输入用户名" name="LoginForm[username]" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input type="password" placeholder="请输入密码" name="LoginForm[password]" />
                </div>
            </div>
        </div>
        <div class="form-actions">
        	<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <span class="pull-left"><a href="#" class="flip-link" id="to-recover">忘记密码</a></span>
            <span class="pull-right"><input type="submit" class="btn btn-inverse" value="登录" /></span>
        </div>
    </form>
</div>