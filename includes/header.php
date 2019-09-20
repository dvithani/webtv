<?php


session_start();
include_once 'includes/functions.php';
require_once "includes/util.php";
include ("configuration.php");
$checkLicense = '';
$bar = '/';
$XCStreamHostUrl = (isset($XCStreamHostUrl) ? $XCStreamHostUrl : '');
$XClicenseIsval = (isset($XClicenseIsval) ? $XClicenseIsval : '');

$results = validate($LegazyLicense);

//         if ($results != 1) {
//             //echo $results;
// 			//echo "<p class=\"alert alert-warning\">Please Introducing a Valid Licensed Number in you Config File.</p><center>";
// 			echo "<script>window.location.href = 'license_install.php';</script>";
// 			exit();
// 			//exit();
//         }
		
if ('/' === substr($XCStreamHostUrl, -1)) {
    $bar = '';
}

if ('success' === $configFileCheck['result']) {
    if ('0777' === $configFileCheck['permission'] || '0755' === $configFileCheck['permission']) {
        require 'configuration.php';
    } else {
        require 'configuration.php';
    }
} else {
    if (!file_exists('configuration.php')) {
        $my_file = 'configuration.php';
        $handle = fopen($my_file, 'w') || exit('Cannot open file:  '.$my_file);
    }
}

if (!isset($_SESSION['webTvplayer']) && empty($_SESSION['webTvplayer']) && 'index' !== $activePage) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

if (empty($XClicenseIsval)) {
    echo "<script>window.location.href = 'player_install.php';</script>";
    exit();
}

//$checkLicense = webtvpanel_CheckLicense($XClicenseIsval);
/*if ('Active' !== $checkLicense['status'] && 'player_install' !== $activePage) {
    echo "<script>window.location.href = 'player_install.php';</script>";
    exit();
}*/

if (isset($_SESSION['webTvplayer'])) {
    $username = $_SESSION['webTvplayer']['username'];
    $password = $_SESSION['webTvplayer']['password'];
    $hostURL = $XCStreamHostUrl;
}

$ShiftedTimeEPG = 0;
$headerparentcondition = '';
$GlobalTimeFormat = '12';
if (isset($_COOKIE['settings_array'])) {
    $SettingArray = json_decode($_COOKIE['settings_array']);
    if (isset($SettingArray->{$_SESSION['webTvplayer']['username']}) && !empty($SettingArray->{$_SESSION['webTvplayer']['username']})) {
        $ShiftedTimeEPG = $SettingArray->{$_SESSION['webTvplayer']['username']}->epgtimeshift;
        $GlobalTimeFormat = $SettingArray->{$_SESSION['webTvplayer']['username']}->timeformat;
        $headerparentcondition = $SettingArray->{$_SESSION['webTvplayer']['username']}->parentpassword;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?php
echo isset($XCsitetitleval) ? $XCsitetitleval : '';
echo "</title>";
?>
<!-- Bootstrap -->

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/scrollbar.css" rel="stylesheet">
<?php
echo "
<script src=\"js/jquery-1.11.3.min.js\"></script> 
<link rel=\"stylesheet\" type=\"text/css\" href=\"css/rippler.css\" />


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->
    <style>
    #cbp-spmenu-s1
    {
      padding-bottom: 80px;
    }
  </style>
</head>
<body>

\t<div class=\"body-content\">
  \t<div class=\"overlay\"></div>
    
  \t";

?>