<?php
include_once("h.php");
include_once("authority.php");
$dm = new dm();
$layer = $dm->getAllLayer();
$seat = $dm->getAllSeat();
$user = $dm->getAllUser();
echo <<<eof
    <ul class="  list-unstyled min-width-800">
eof;
foreach ($layer as $tmpl) {
    echo <<<eof
   <li class="well">
   <div style="width:750px;min-width:750px">
       <div class="seat mapImg" ><img src="images/{$tmpl['imagePath']}" id="image_{$tmpl['id']}" style="width:600px;height:400px;"/></div>
       <div class="seat operation">
          <span class="well span" id="infoimage_{$tmpl['id']}"></span>
       </div>
   </div>
   <div style="clear:both" ></div> <span id="image_{$tmpl['id']}_btnCls">
eof;

    foreach ($seat as $tmps) {
        if ($tmpl['id'] == $tmps['layer']) {
            echo <<<eof
        <button class="seat" seatid="{$tmps['id']}" status={$tmps['status']} imageId="image_{$tmpl['id']}" px={$tmps['px']} py={$tmps['py']} id="seat_{$tmps['id']}" style="width:{$tmps['w']}px;height:{$tmps['h']}px">{$tmps['owner']}</button>
eof;
        }
    }
    echo '</span>
        
        </li>';
}
echo <<<eof
    </ul>
<script type="text/javascript">window.onload = function() { takeSeatInitial('{$_SESSION['_userName']}');}</script>
eof;
include_once("f.php");