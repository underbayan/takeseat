<?php
if(''==$met=$_REQUEST['pm'])die;
else
{
    switch ($met)
    {
        case 'adLogin':include_once 'adminLogin.php';
        case 'tkst':include_once 'takeSeatPage.php';break;
        case 'stst':include_once 'setSeatPage.php';break;//add
        case 'stsp':include_once 'takeSeatPage.php';break;//delete
        case 'ss':;include_once 'takeSeatPage.php';break;//set seatstaus
    }
}