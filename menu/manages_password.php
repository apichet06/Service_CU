<?php @session_start();
 require_once '../db/config.php';

 $m_id = $_POST['m_id'];
 $pass = $_POST['password1'];

 $sql = mysqli_query($conn,"UPDATE member SET password = '$pass' Where m_id = '$m_id' ");

 if($sql){

 	$show = "1";
	session_destroy();
	
 }else{

 	$show = "0";

 }

$name = array('data' => $show );
echo json_encode($name);

 ?>