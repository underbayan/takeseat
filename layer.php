<?php
include_once "authority.php";
include_once "dataManager.php";
if (!isadmin()) return;
if ('' == $met = $_REQUEST['m'])
    die();
else {
    switch ($met) {
        case 'al':
            al();
            header("Location:./setSeatPage.php");
            break; // add
        case 'dl':
            dl();
            break; // delete
        case 'ul':
            ul();
            break; // update
        case 'gl':
            gl();
            break; // get
    }
}

function gl()
{
    $dm = new dm();
    var_dump($dm->getAllLayer());
}

function dl()
{
    $dm = new dm();
    $dm->resetAllSeat();
    echo $dm->deleteLayer(htmlspecialchars($_REQUEST['id']));
}

function al()
{
    if (!$_FILES['layerImage']) return;
    if (!((($_FILES["layerImage"]["type"] == "image/gif")
            || ($_FILES["layerImage"]["type"] == "image/jpeg")
            || ($_FILES["layerImage"]["type"] == "image/pjpeg"))
        && ($_FILES["layerImage"]["size"] < 1000000))
    ) return;

    $fileName = time() . $_FILES['layerImage']['name'];
    while (file_exists("./images/" . $fileName))
        $fileName = time() . $_FILES['file']['name'];

    if (is_uploaded_file($_FILES['layerImage']['tmp_name']))
        if (move_uploaded_file($_FILES['layerImage']['tmp_name'], "./images/" . $fileName)) {
            $dm = new dm();
            $dm->addLayer($fileName);
        }

}

function ul()
{
    $dm = new dm();
    echo $dm->updateLayer($_REQUEST['imagepath'], htmlspecialchars($_REQUEST["id"]));
}
