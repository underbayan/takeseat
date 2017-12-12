<?php
include_once("h.php");
include_once "authority.php";
if (isAdmin()) {
    echo <<<eof
    <div class="span2 well" style="margin-left:4%;">
<form id="adminPwdFormId" class="form-signin">
<h6 class="form-signin-heading">change admin's pwd</h6>
<input name='oldpwd' type="password" class="input-block-level" placeholder="oldPassword">
<input  name='pwd' type="password" class="input-block-level" placeholder="newPassword">
<input  name='newpwd' type="password" class="input-block-level" placeholder="newPassword">
<button type="button" class="btn btn-primary" onclick="javascript:changePwd('./sys.php?m=cadpwd','adminPwdFormId')">confirm</button>
    
</form>
</div>
eof;
}
if (isLogin()) {
    echo <<<eof
<div class="span2 well" style="margin-left:4%;">
<form id="userPwdFormId" class="form-signin" >
<h6 class="form-signin-heading">change the user's password</h6>
<input name='oldpwd' type="password" class="input-block-level" placeholder="oldPassword">
<input  name='pwd' type="password" class="input-block-level" placeholder="newPassword">
<input  name='newpwd' type="password" class="input-block-level" placeholder="newPassword">
<button type="button" class="btn btn-primary" onclick="javascript:changePwd('./user.php?m=cpwd','userPwdFormId')">confirm</button>
</form>
</div>

eof;

}
echo '<span id="info" style=""></span>';
include_once("f.php");