<?php include_once './authority.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <title>NABSEAT</title>
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.js"></script>
    <script type="text/javascript" src="./js/lib.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.css"/>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-responsive.css"/>
    <link rel="stylesheet" type="text/css" href="./css/common.css"/>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse"
                    data-target=".nav-collapse">
                <span class="icon-bar"></span> <span class="icon-bar"></span> <span
                        class="icon-bar"></span>
            </button>
            <a class="brand" href="./index.php">NABSEAT</a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    <a href="./authority.php?__aum=lout" class="navbar-link">loginOut</a>
                </p>
                <p class="navbar-text pull-right" style="margin-right: 20px">
                    <a href="./authority.php?__aum=adlPage" class="navbar-link">managerPage</a>
                </p>
                <?php
                if (isLogin() || isAdmin()) {
                    echo <<<eof
	<p class="navbar-text pull-right" style="margin-right: 20px">
			<a href="./changePwd.php" class="navbar-link">change password</a>
	</p>
eof;
                } ?>
                <ul class="nav">
                    <!-- <li class="active"><a href="{$Mabpath}"></a></li> -->
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<div class="container ">
