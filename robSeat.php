<?php
session_start();
if ($_SESSION["_userName"] != $_GET['name']) {
    echo $_GET['name'] . "-------" . $_SESSION["_userName"];
}
include_once("dataManager.php");
if ($_SESSION["_userName"] == $_GET['name']) {
    if ($_SESSION["_sysStatus"] == 1 || $_SESSION["_sysStatus"] == 3) {
        $_SESSION["_clickNum"] = $_SESSION["_clickNum"] + 1;
        if ($_SESSION["_clickNum"] > 0) {
            $_SESSION["_clickNum"] = 0;
            $dm = new dm();
            $id = mysql_escape_string(htmlspecialchars($_GET["id"]));
            $allSeat = $dm->getAllSeat();
            $allSeatJson = json_encode($allSeat);
            foreach ($allSeat as $seat) {
                if ($seat["id"] == $id && ($seat["status"] == 0)) {
                    $dm->removeOwnerSeat($_SESSION["_userName"]);
                    $dm->setSeat($id, $_SESSION["_userName"], 1);
                    echo '{"r":1,"d":""}';
                    return;
                }
            }
            echo '{"r":0,"d":' . $allSeatJson . '}';
            return;
        }
    }
}
echo "{}";