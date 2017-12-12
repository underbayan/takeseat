<?php
include_once 'authority.php';
if (!isAdmin()) return;
include_once("h.php");
$dm = new dm();
$user = $dm->getAllUser();
echo <<<eof
<div class="panel panel-default span8">
  <div class="panel-heading"></div>
  <div class="panel-body">
    <table class="table table-striped table-bordered">
    <tr><td>序号</td><td >姓名</td><td >状态</td><td >操作</td></tr>
eof;
$userOrder = 0;
foreach ($user as $t) {
    echo <<<eof
    <tr><td>{$userOrder}</td>
        <td>{$t['name']}</td>
        <td>{$t['status']}</td>  
        <td>
        <button class="btn btn-inverse " onclick="deleteUser('{$t['id']}')">删除</button>
        <button class="btn btn-inverse " onclick="resetUserPwd('{$t['id']}')">重置密码</button>
         </td> 
     </tr>
eof;
    $userOrder++;
}
echo <<<eof
<tr><td>添加</td><td><input id="new_user_input" name='name' type="text" style="margin:0;height:11px" placeholder="用户名">
         </td><td>0</td><td>
    <button class="btn btn-inverse " onclick="addUser()">添加（密码默认是12345678）</button>
    </td></tr>
    </table>
    <span id="info" style="width:50%"></span>
  </div> 
</div>
eof;
include_once("f.php");