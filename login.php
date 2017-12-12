<?php
include_once ('authority.php');
$dm= new dm();
$user = $dm->getAllUser();
include_once("h.php");

echo <<<EOF
<div class="ab-center well" >
<div id="userList" class="">
<span style="background-color:#000;color:#fff;margin:5px;">user list:</span>
EOF;
    foreach ($user as $tmps){
        echo <<<eof
        <span name={$tmps['name']}  id="userid_{$tmps['name']}" style="margin:2px">{$tmps['name']}</span>
eof;
    
    }
echo <<<eof
</div>
    <hr>
<form method="post" class="form-signin" action='./authority.php?__aum=lg'>
<h2 class="form-signin-heading"></h2>
<input style="width:300px" name='name' type="text" class="input-block-level" placeholder="user"><br/>
<input style="width:300px"  name='pwd' type="password" class="input-block-level" placeholder="password(default password is 12345678)"><br/>
<button class="btn btn-large btn-primary" type="submit">login</button>
</form>
</div>
eof;
include_once("f.php");