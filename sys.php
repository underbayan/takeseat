<?php
include_once "authority.php";
include_once("dataManager.php");
if (!isadmin()) return;
if ('' != $met = $_REQUEST['m']) {
    switch ($met) {
        case 'us':
            _us();
            break;//us
        case 'chadminPage':
            include_once 'changePwd.php';
            exit(0);
            break;
        case "cadpwd":
            changeAdminPwd();
            break;
        case "randDis":
            randDis();
            break;
        case "frandDis":
            forceRandDis();
            break;
        case "resetAllSeat":
            resetAllSeat();
            break;
    }
}

function _us()
{
    $dm = new dm();
    $id = $_REQUEST['id'];
    $value = $_REQUEST['v'];
    echo $dm->setConfig($id, $value);
}

function changeAdminPwd()
{
    $dm = new dm();
    $oldpwd = $_REQUEST['oldpwd'];
    $pwd = $_REQUEST['pwd'];
    $npwd = $_REQUEST['newpwd'];
    $ret = $dm->changeAdminPwd($oldpwd, $pwd, $npwd);
    echo $ret;

}

function forceRandDis()
{
    $dm = new dm();
    $dm->forceRandDisSeat();
    header("Location:sysPage.php");
}

function randDis()
{
    $dm = new dm();
    echo $dm->randDisSeat();
}

function resetAllSeat()
{
    $dm = new dm();
    $dm->resetAllSeat();
    header("Location:sysPage.php");
}