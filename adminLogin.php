<?php
include_once ('authority.php');
include_once("h.php");
echo <<<EOF
<div class=" well text-center ab-center" >
<form method="post" class="form-signin" action='./authority.php?__aum=adminlg'>
<h2 class="form-signin-heading">后台</h2>
<input name='name' type="text" class="input-block-level" placeholder="用户名">
<input  name='pwd' type="password" class="input-block-level" placeholder="密码">
<button class="btn btn-large btn-primary" type="submit">登录</button>
</form>
</div>
EOF;
include_once("f.php");