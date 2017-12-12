<?php
include_once "authority.php";
include_once("dataManager.php");

if ('' == $met = $_REQUEST['m']) die;
else {
    switch ($met) {
        case 'au':
            au();
            break;//add
        case 'du':
            du();
            break;//delete
        case 'ru':
            ru();
            break;//reset userstatus
        case 'uu':
            uu();
            break;//update
        case 'gu':
            gu();
            break;//getall
        case 'cpwd':
            changeUserPwd();
    }
}
function changeUserPwd()
{
    $dm = new dm();
    $oldpwd = $_REQUEST['oldpwd'];
    $pwd = $_REQUEST['pwd'];
    $npwd = $_REQUEST['newpwd'];
    echo $ret = $dm->changeUserPwd($oldpwd, $pwd, $npwd);
}

function gu()
{
    $dm = new dm();
    var_dump($dm->getAllUser());
}

function au()
{
    if (!isadmin()) return;
    $dm = new dm();
    echo $dm->addUser(htmlspecialchars($_REQUEST['name']));
}

function du()
{
    if (!isadmin()) return;
    $dm = new dm();
    echo $dm->deleteUser(htmlspecialchars($_REQUEST['id']));
}

function ru()
{
    if (!isadmin()) return;
    $id = htmlspecialchars($_REQUEST['id']);
    $dm = new dm();
    echo $dm->resetUserPwd($id);
}

function uu()
{
    //$dm=new dm();$dm->setUser($id, $name, $status);
}
