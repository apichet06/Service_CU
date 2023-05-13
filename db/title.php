<?php 
if ($_SERVER['REQUEST_URI'] == '/service/index.php' or $_SERVER['REQUEST_URI'] == '/service/') { 
require_once 'db/config.php';
}else{
require_once '../db/config.php';	
}
$sql  = mysqli_query($conn,"SELECT * FROM company_logo")or die(mysqli_error($conn));
$ex = mysqli_fetch_assoc($sql);
$title = $ex['com_name']; //CloudWork
$logo  = "../manages/img/".$ex['com_logo'].""; 
$icon  = "../manages/img/".$ex['com_logo']."";
$logo_index  = "manages/img/".$ex['com_logo'].""; 
$icon_index  = "manages/img/".$ex['com_logo']."";

 ?>