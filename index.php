<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT); 
include_once('authority.php');
if (!isLogin()) {
    include_once("login.php");
} else {
    if (!isCanTakeSeat()) {
        include_once("showSeatPage.php");
    } else {
        include_once("takeSeatPage.php");
    }

}
?>
