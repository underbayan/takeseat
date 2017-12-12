<?php
include_once "authority.php";
if (!isAdmin()) die;
if ('' == $met = $_REQUEST['m']) die;
else {
    switch ($met) {
        case 'gs':
            _gs();
            break;
        case 'as':
            _as();
            break;//add
        case 'ds':
            _ds();
            break;//delete
        case 'ss':
            _ss();
            break;//set seatstaus

    }
}
function _gs()
{
    $dm = new dm();
    var_dump($dm->getAllSeat());
}

function _ss()
{
    $id = htmlspecialchars($_REQUEST['id']);
    $status = htmlspecialchars($_REQUEST['s']);
    $owner = htmlspecialchars($_REQUEST['ow']);
    $oldOwner = htmlspecialchars($_REQUEST['oldow']);
    $dm = new dm();
    if ($oldOwner != '')
        $dm->removeOwnerSeat($oldOwner);
    echo $dm->setSeat($id, $owner, $status);
}

function _ds()
{
    $dm = new dm();
    $id = htmlspecialchars($_REQUEST['id']);
    echo $dm->deleteSeat($id);
}

function _as()
{
    $dm = new dm();
    $layer = htmlspecialchars($_REQUEST['lid']);
    $px = htmlspecialchars($_REQUEST['x']);
    $py = htmlspecialchars($_REQUEST['y']);
    $w = htmlspecialchars($_REQUEST['w']);
    $h = htmlspecialchars($_REQUEST['h']);
    echo $dm->addSeat($layer, $px, $py, $w, $h);
}