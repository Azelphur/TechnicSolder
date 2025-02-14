<?php
session_start();
$config = require("./config.php");
require("dbconnect.php");
if(!$_SESSION['user']||$_SESSION['user']=="") {
	die("Unauthorized request or login session has expired!");
}
if(substr($_SESSION['perms'],4,1)!=="1") {
	echo 'Insufficient permission!';
	exit();
}
if(empty($_GET['id'])){
	die("Mod not specified.");
}
$result = mysqli_query($conn, "SELECT * FROM `mods` WHERE `id` = ".$_GET['id']);
$mod = mysqli_fetch_array($result);
if($mod['link']!==$_POST['link']){
	mysqli_query($conn, "UPDATE `mods` SET `link` = '".mysqli_real_escape_string($conn, $_POST['link'])."' WHERE `id` = ".$_GET['id']);
}
if($mod['author']!==$_POST['author']){
	mysqli_query($conn, "UPDATE `mods` SET `author` = '".mysqli_real_escape_string($conn, $_POST['author'])."' WHERE `id` = ".$_GET['id']);
}
if($mod['donlink']!==$_POST['donlink']){
	mysqli_query($conn, "UPDATE `mods` SET `donlink` = '".mysqli_real_escape_string($conn, $_POST['donlink'])."' WHERE `id` = ".$_GET['id']);
}
if($mod['version']!==$_POST['version']){
	mysqli_query($conn, "UPDATE `mods` SET `version` = '".mysqli_real_escape_string($conn, $_POST['version'])."' WHERE `id` = ".$_GET['id']);
}
if($mod['mcversion']!==$_POST['mcversion']){
	mysqli_query($conn, "UPDATE `mods` SET `mcversion` = '".mysqli_real_escape_string($conn, $_POST['mcversion'])."' WHERE `id` = ".$_GET['id']);
}
if($mod['url']!==$_POST['url']){
	mysqli_query($conn, "UPDATE `mods` SET `url` = '".mysqli_real_escape_string($conn, $_POST['url'])."' WHERE `id` = ".$_GET['id']);
}
if($mod['md5']!==$_POST['md5']){
	mysqli_query($conn, "UPDATE `mods` SET `md5` = '".mysqli_real_escape_string($conn, $_POST['md5'])."' WHERE `id` = ".$_GET['id']);
}
if($_POST['submit']=="Save and close") {
	header("Location: ".$config['dir']."mod?id=".$mod['name']);
	exit();
}
header("Location: ".$config['dir']."modv?id=".$_GET['id']);
exit();