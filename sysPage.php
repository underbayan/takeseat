<?php
include_once "authority.php";
include_once("h.php");
if (!isAdmin()) return;
$dm = new dm();
$c = $dm->getConfig();
//var_dump($c);
echo <<<eof
<div class="panel panel-default span8">
  <div class="panel-heading"></div>
  <div class="panel-body">
    <table class="table table-striped table-bordered">
    <tr>
    <td ><button class="btn" onclick="javascript:window.location.href='./sys.php?m=frandDis'">强制随机分配座位</button></td>
    <td ><button class="btn" onclick="javascript:window.location.href='./sys.php?m=resetAllSeat'">重置所有座位</button></td>
    <td ><button class="btn" onclick="javascript:updateSys(5,3)">强制设置系统可以抢座</button></td>
    <td ><button class="btn" onclick="javascript:updateSys(5,4)">强制设置系统不可抢座</button></td>
    <td ><button class="btn" onclick="javascript:updateSys(5,1)">系统状态由系统自行设置</button></td>
    </tr>
    </table>
    <table class="table table-striped table-bordered">
    <tr><td>序号</td><td >变量名称</td><td >详解</td><td >数值</td><td >操作</td></tr>
eof;
foreach ($c as $t) {
    if ('adminpwd' != $t['name'])
        echo <<<eof
    <tr><td>{$t['id']}</td>
        <td>{$t['name']}</td>
        <td>{$t['lname']}</td>  
        <td><input id="sys_{$t['id']}" value="{$t['value']}" type=text /></td> 
        <td>
        <button class="btn btn-inverse " onclick="updateSys('{$t['id']}',$('#sys_{$t['id']}').val())">保存</button>
        </td> 
     </tr>
eof;
}
echo <<<eof

    </table>
    <span id="info" style="width:50%"></span>
  </div> 
</div>
eof;
include_once("f.php");