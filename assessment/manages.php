<?php 

require_once '../db/config.php';

$id 	   = mysqli_escape_string($conn,$_POST['id']);
$ws_assess = mysqli_escape_string($conn,$_POST['ws_assess']);
$date      = date("Y-m-d");
if ($_POST['insert_success'] === "insert_success") {
	$id = mysqli_escape_string($conn,$_POST['id']);
	$success = "ผ่าน";

	$sql = mysqli_query($conn,"UPDATE worksheet Set 
		ws_assess_status = '$success',
		ws_assess_date = '$date'
		Where  ws_id = '$id' ");
	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}

if($_POST['not_success'] === "not_success"){


	$not = "ไม่ผ่าน";
	$sql = mysqli_query($conn,"UPDATE worksheet Set 
		ws_assess_status = '$not',
		ws_assess ='$ws_assess',
		ws_assess_date = '$date'
		Where  ws_id = '$id'");
	if($sql){

		echo "1";

	}else{

		echo "0";

	}
}



?>