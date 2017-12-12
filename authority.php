<?php
session_start();
include_once("dataManager.php");
set_sys();
if ('' != ($met = $_REQUEST['__aum'])) {
    switch ($met) {
        case 'lg':
            loginJudge();
            break; // us
        case 'lout':
            loginOut();
            break;
        case 'adminlg':
            adminLoginJudge();
            break;
        case "adlPage":
            if (!isAdmin()) {
                include_once "adminLogin.php";
                exit(0);
            } else {
                include_once "setSeatPage.php";
            }
            break;

    }
}
function isAdmin()
{
    if ($_SESSION["type"] == "admin" && $_SESSION["admin"] != null)
        return true;
}

function isLogin()
{
    //var_dump($_SESSION);
    if ($_SESSION['_userName'] != null || $_SESSION['_userId'])
        return true;
    else return false;
}

function gotoAdmin()
{
    header("location:./adminLogin.php");
}

function gotoLogin()
{
    header("location:./index.php");
}

function adminLoginJudge()
{
    $user = htmlspecialchars($_REQUEST["name"]);
    $password = ($_REQUEST["pwd"]);
    $password = md5($password . "___salt___");
    $dm = new dm();
    $admin = '';
    $pwd = '';
    $c = $dm->getConfig();
    $tmps = null;
    foreach ($c as $t) {
        switch ($t['name']) {
            case 'admin': {
                $admin = $t['value'];
                break;
            }
            case 'adminpwd': {
                $pwd = $t['value'];
                break;
            }
                break;
        }
    }

    if ($user == $admin && $password == $pwd) {
        $_SESSION["admin"] = $user;
        $_SESSION["type"] = "admin";
        header("Location:./setSeatPage.php");
    } else {
        header("Location:./adminLogin.php");
    }
    exit(0);
}

function loginJudge()
{
    $user = htmlspecialchars($_REQUEST["name"]);
    $password = htmlspecialchars($_REQUEST["pwd"]);
    $dm = new dm();
    $r = $dm->getUserByName($user);
    if ($r != null && $r != '') {
        $pr = md5($password . '___salt___');
        if ($pr == $r[0]['pwd']) {
            $_SESSION['_userId'] = $r[0]['id'];
            $_SESSION['_userName'] = $r[0]['name'];
            $_SESSION['_userStatus'] = $r[0]['status'];
            $_SESSION['_clickNum'] = 0;
            header("Location:./index.php");
            exit(0);
        }
    }
    include_once("./login.php");

}

function loginOut()
{
    unset($_SESSION['_userId']);
    unset($_SESSION['_userName']);
    unset($_SESSION['_userStatus']);
    unset($_SESSION['_sessionStart']);
    unset($_SESSION['_clickNum']);
    if ($_SESSION["type"]) {
        unset($_SESSION["type"]);
        unset($_SESSION["admin"]);
    }
    unset($_SESSION);
    header("Location:index.php");
}

function isCanTakeSeat()
{
    //var_dump($_SESSION);
    if ($_SESSION["_sessionStart"] == ''
        || ($_SESSION["_sysStatus"] == '' && $_SESSION["_sysStatus"] != 0)
        || time() - $_SESSION["_sessionStart"] > 5
    ) {
        $dm = new dm();
        $c = $dm->getConfig();
        $tmps = null;
        foreach ($c as $t) {
            switch ($t['name']) {
                case 'sysStatus': {
                    $_SESSION["_sessionStart"] = time();
                    $_SESSION["_sysStatus"] = $t['value'];
                }
                    break;
            }
        }


    }

    if ($_SESSION["_sysStatus"] - 0 != 1 && $_SESSION["_sysStatus"] - 0 != 3) {

        return false;
    } else return true;

}

function set_sys()
{
    $dm = new dm();
    $c = $dm->getConfig();
    $config = array();
    foreach ($c as $t) {
        switch ($t['name']) {
            case 'starttime':
                $config['st'] = $t['value'];
                break;
            case 'endtime':
                $config['et'] = $t['value'];
                break;
            case 'sysStatus':
                $config['ss'] = $t['value'];
                break;
        }
    }
    date_default_timezone_set("Asia/Shanghai");
    $tmpdate = date("y-m-d-H-i-s");
    list ($ye, $mo, $d, $h, $im, $se) = split('-', $tmpdate);
    list ($sd, $sh) = split(',', $config['st']);
    list ($ed, $eh) = split(',', $config['et']);
    if (($config['ss'] - 0) < 2) {
        if ((($d - $sd) * 24 + $h - $sh >= 0) && (($ed - $d) * 24 + $eh - $h > 0)) {
            if ($config['ss'] == 0) {
                $dm->resetAllSeat();
            }
            $dm->setConfigByName("sysStatus", 1);

        } else {
            // if($config['ss']==1)
            // {$dm->randDisSeat();}
            $dm->setConfigByName("sysStatus", 0);
        }
    }
}