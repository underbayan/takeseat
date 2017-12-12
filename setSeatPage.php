<?php
include_once("h.php");
include_once("dataManager.php");
include_once './authority.php';

$dm = new dm();
$layer = $dm->getAllLayer();
$seat = $dm->getAllSeat();
$user = $dm->getAllUser();
if (isAdmin()) {
    echo <<<eof
    <div class="well span3" style="width: 200px; min-width: 200px">
	<ul class="nav nav-list">
		<li><a href="./userManager.php">UserManager</a></li>
		<li><a href="./setSeatPage.php">SeatManager</a></li>
		<li><a href="./sysPage.php">systemManager</a></li>	
	</ul>
	</div>		
eof;
}
echo <<<eof
    <ul class="list-unstyled min-width-800" >
eof;

foreach ($layer as $tmpl) {
    echo <<<eof
   <li class="well">
   <div style="width:800px;min-width:800px;margin-left:300px">
       <div class="seat mapImg" ><img src="images/{$tmpl['imagePath']}" id="image_{$tmpl['id']}" style="width:600px;height:400px;"/></div>
       <div class="seat operation">
           <div class="well span"> 
            <button imageid="image_{$tmpl['id']}" id="button_add_seat_{$tmpl['id']}" class="btn " style="margin:2px;">添加座位</button>
            <button class="btn" onclick="javascript:deleteLayer({$tmpl['id']})" style="margin:2px;">删除楼层</button>
           </div>
           <span class="well span" >
           <button class="btn" style="margin:2px;width:60px">可抢</button>
           <button class="btn-occupyblack" style="margin:2px;width:60px">已占</button>
           <button class="btn-holdgray" style="margin:2px;width:60px">固定</button>
           </span>
          <span class="well span" id="infoimage_{$tmpl['id']}"></span>
       </div>
   </div>
   <div style="clear:both" ></div> <span id="image_{$tmpl['id']}_btnCls">
eof;

    foreach ($seat as $tmps) {
        if ($tmpl['id'] == $tmps['layer']) {
            echo <<<eof
        <button class="seat" status={$tmps['status']} imageId="image_{$tmpl['id']}" px={$tmps['px']} py={$tmps['py']} id="seat_{$tmps['id']}" style="width:{$tmps['w']}px;height:{$tmps['h']}px">{$tmps['owner']}</button>
eof;
        }
    }

    echo '</span>
        
        </li>';
}
echo <<<eof
<li>
<form  id="addLayerForm" class="well" method="post"  enctype="multipart/form-data"  name="layer" >
<span class="info">请上传平面图</span>
<input  type="file" name='layerImage'/>
<button class="btn btn-success" style="float:right" onclick="javascript:addLayer()">保存</button>
</form></li></ul>
<div id="userList" class="well span3" style="position:absolute;top:250px;width:200px;min-width:200px">
eof;
foreach ($user as $tmps) {
    if ($tmps['status'] == 0)
        echo <<<eof
        <button name={$tmps['name']}  id="userid_{$tmps['name']}" class="btn btn-small" style="margin:2px">{$tmps['name']}</button>
eof;
    else
        echo <<<eof
        <button name={$tmps['name']} style="display:none" id="userid_{$tmps['name']}" class="btn btn-small" style="margin:2px">{$tmps['name']}</button>
eof;

}
echo <<<eof
</div>

<script type="text/javascript">window.onload = function() { setSeatInitial();}</script>
eof;
include_once("f.php");