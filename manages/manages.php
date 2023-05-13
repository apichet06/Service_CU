<?php require_once "../db/config.php"; 

$id  = mysqli_escape_string($conn,$_POST['id']);
$dv_name = mysqli_escape_string($conn,$_POST['dv_name']);
$dv_name_short = mysqli_escape_string($conn,$_POST['dv_name_short']);

if($_POST['insert'] === "insert_division"){

	//$dv_name = $_POST['dv_name'];
	//$dv_name_short = $_POST['dv_name_short'];

	$sql = mysqli_query($conn,"INSERT INTO division (dv_name,dv_name_short)VALUES('$dv_name','$dv_name_short')");

	if($sql){
		echo "1";
	}else{
		echo "0";
	}
 //exit();
}

if($_POST['del_division'] === "del_division"){

	$sql = mysqli_query($conn,"DELETE FROM division WHERE  dv_id = '$id' ");

	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}

if($_POST['update_idvision'] === "update_idvision"){
	$sql = mysqli_query($conn,"UPDATE division SET 
		dv_name 	  = '$dv_name',
		dv_name_short = '$dv_name_short'  
		WHERE dv_id   = '$id' ");
	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}

//ตำแหน่ง 

$p_id   = mysqli_escape_string($conn,$_POST['p_id']);		
$p_name = mysqli_escape_string($conn,$_POST['p_name']);
$p_hort = mysqli_escape_string($conn,$_POST['p_hort']);

$home   = mysqli_escape_string($conn,$_POST['home']);
$worksheet   = mysqli_escape_string($conn,$_POST['worksheet']);
$assessment   = mysqli_escape_string($conn,$_POST['assessment']);
$work_transfer   = mysqli_escape_string($conn,$_POST['work_transfer']);
$mechanic_work   = mysqli_escape_string($conn,$_POST['mechanic_work']);
$work_in_out   = mysqli_escape_string($conn,$_POST['work_in_out']);
$charts   = mysqli_escape_string($conn,$_POST['charts']);
$manages   = mysqli_escape_string($conn,$_POST['manages']);

if($_POST['insert'] === "insert_position"){

	$sql  = mysqli_query($conn,"INSERT INTO position (p_name,p_hort)VALUES('$p_name','$p_hort')");
	$sql0 = mysqli_query($conn,"SELECT max(p_id)as p_id FROM position "); 
	$rs   = mysqli_fetch_assoc($sql0);

	$sql = mysqli_query($conn,"INSERT INTO practicability(p_id,home,worksheet,assessment,work_transfer,mechanic_work,work_in_out,charts,manages)
		VALUES
		('".$rs['p_id']."','$home','$worksheet','$assessment','$work_transfer','$mechanic_work','$work_in_out','$charts','$manages')");

	if($sql){
		echo "1";
	}else{
		echo "0";
	}	

}

if($_POST['update_position'] === "update_position"){

	$sql = mysqli_query($conn,"UPDATE position SET p_name = '$p_name', p_hort = '$p_hort'   WHERE p_id = '$p_id' ");

	$sql0 = mysqli_query($conn,"SELECT * FROM practicability Where p_id = '$p_id' ");
	$row = mysqli_num_rows($sql0);
 
	if($row =="0"){
 
		$sql   = mysqli_query($conn,"INSERT INTO practicability(p_id,home,worksheet,assessment,work_transfer,mechanic_work,work_in_out,charts,manages)
			VALUES
			('$p_id','$home','$worksheet','$assessment','$work_transfer','$mechanic_work','$work_in_out','$charts','$manages')");	

	}else{

		$sql = mysqli_query($conn,"UPDATE practicability SET 
			home			= '$home',
			worksheet		= '$worksheet',
			assessment		= '$assessment',
			work_transfer	= '$work_transfer',
			mechanic_work	= '$mechanic_work',
			work_in_out		= '$work_in_out',
			charts			= '$charts',
			manages			= '$manages' 
			Where p_id 		= '$p_id' ");
	}

	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}

if($_POST['del_position'] === "del_position"){

	$sql = mysqli_query($conn,"DELETE FROM position   WHERE p_id = '$p_id' ");
	$sql = mysqli_query($conn,"DELETE FROM practicability   WHERE p_id = '$p_id' ");
	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}


$date = date("Y-m-d");
$place_id = mysqli_escape_string($conn,$_POST['place_id']);
$z_id = mysqli_escape_string($conn,$_POST['z_id']);
$place_name = mysqli_escape_string($conn,$_POST['place_name']);

if($_POST['insert_place'] === "insert_place"){

	$sql0 = mysqli_query($conn,"SELECT * FROM place Where place_name = '$place_name' ");
	$row = mysqli_num_rows($sql0);

	if($row >= "1"){
		echo "2";
	}else{
		$sql = mysqli_query($conn,"INSERT INTO place (z_id,place_name,place_date)VALUES('$z_id','$place_name','$date')");
		if($sql){
			echo "1";
		}else{
			echo "0";
		}
	}
}

if($_POST['del_place'] === "del_place"){
	$sql0 = mysqli_query($conn,"SELECT  place_id FROM worksheet  WHERE  place_id = '$place_id' ");
	$rows = mysqli_num_rows($sql0);

	if($rows >="1"){
		echo "2";
	}else{

		$sql = mysqli_query($conn,"DELETE FROM place WHERE  place_id = '$place_id' ");

		if($sql){
			echo "1";
		}else{

			echo "0";
		}
	}
}
if($_POST['update_place'] === "update_place"){
	$sql0 = mysqli_query($conn,"SELECT * FROM place Where place_name = '$place_name' and place_id != '$place_id' ");
	$row = mysqli_num_rows($sql0);

	if($row >= "1"){
		echo "2";
	}else{
		$sql= mysqli_query($conn,"UPDATE place SET  place_name= '$place_name' ,z_id='$z_id' WHERE place_id = '$place_id' ");

		if($sql){
			echo "1";
		}else{
			echo "0";
		}
	}
}

//print_r($_POST['z_idx']);


$m_id 	  = mysqli_escape_string($conn,$_POST['m_id']);
$z_id 	  = mysqli_escape_string($conn,$_POST['z_id']);
$m_name   = mysqli_escape_string($conn,$_POST['m_name']);
$m_lname  = mysqli_escape_string($conn,$_POST['m_lname']);
$username = mysqli_escape_string($conn,$_POST['username']);
$m_phone  = mysqli_escape_string($conn,$_POST['m_phone']);
$p_id 	  = mysqli_escape_string($conn,$_POST['p_id']); //ชื่อตำเหน่ง สิทธิ์
$dv_id 	  = mysqli_escape_string($conn,$_POST['dv_id']); //ชื่อตำเหน่ง สิทธิ์
$photo    = mysqli_escape_string($conn,$_POST['photograph']);
$email    = mysqli_escape_string($conn,$_POST['email']);
$password = mysqli_escape_string($conn,$_POST['password']);
$photo = $photo =="" ? "0" : $photo;
$user = "$m_name $m_lname";
$date = date("Y-m-d");

if($_POST['insert'] === "insert_member"){
	$sql_w = mysqli_query($conn,"SELECT * FROM member  WHERE  username = '$username'");
	$rows = mysqli_num_rows($sql_w);	
	if ($rows >="1"){
		//
	}else{

		$sql = mysqli_query($conn,"INSERT INTO member (p_id,dv_id,m_name,username,password,m_phone,m_status,m_date,token,photograph,email)
			VALUES
			('$p_id','$dv_id','$user','$username','$password','$m_phone','$p_id','$date','','$photo','$email')")or die(mysqli_error($conn));	

		$sql0  = mysqli_query($conn,"SELECT MAX(m_id)as m_id FROM member ");
		$rs    = mysqli_fetch_assoc($sql0);

		for ($i = 0; $i < count($_POST['work_start']); $i++){ 
			$work_start = $_POST['work_start'][$i];
			$work_end = $_POST['work_end'][$i];
			$ii=$i+1;
			$work_start = $work_start =="" ? "00:00:00" : $work_start;
			$work_end =  $work_end =="" ? "00:00:00" : $work_end;

			$sql = mysqli_query($conn,"INSERT INTO  schedule(m_id,wd_id,work_start,work_end)VALUES('".$rs['m_id']."','$ii',
				'$work_start','$work_end')")or die(mysqli_error($conn));
		}



		if($_POST["z_idx"]){
			for ($i=0; $i < count($_POST["z_idx"]); $i++) { 
				$z_idx =  $_POST["z_idx"][$i];
				$sql = mysqli_query($conn,"INSERT INTO area_zone (m_id,z_id)VALUES('".$rs['m_id']."','$z_idx')");

			}
		}
		if($sql){
			echo "1";	
		}else{
			echo "0";
		}
	}
}

if($_POST['del_member'] == "del_member"){


	$sql = mysqli_query($conn,"DELETE FROM member WHERE m_id = '$m_id' ")or die(mysqli_error($conn));
	$sql = mysqli_query($conn,"DELETE FROM schedule WHERE m_id = '$m_id' ");
	if($sql){
		echo "1";
	}else{
		echo "0";
	}

}

if($_POST['update_member'] === "update_member"){

	$sql_w = mysqli_query($conn,"SELECT * FROM member  WHERE (m_name = '$m_name $m_lname' or username = '$username') and m_id !='$m_id'");
	$rows = mysqli_num_rows($sql_w);	
	if ($rows >="1") {
		echo "11";
	}else{
		$sql_del = mysqli_query($conn,"DELETE FROM area_zone WHERE  m_id = '$m_id'")or die(mysqli_error($conn));
		
		if($_POST["z_idx"]){
			for ($i=0; $i < count($_POST["z_idx"]); $i++) { 
				$z_idx =  $_POST["z_idx"][$i];
				$sql = mysqli_query($conn,"INSERT INTO area_zone (m_id,z_id)VALUES('$m_id','$z_idx')");

			}
		}
		


		$sql = mysqli_query($conn,"UPDATE member SET 
			dv_id    	= '$dv_id',
			m_name   	= '$user', 
			username 	= '$username',
			m_phone  	= '$m_phone',
			m_status 	= '$p_id',
			p_id     	= '$p_id',
			email 	 	= '$email',
			photograph  = '$photo',
			password    = '$password' 
			WHERE  m_id = '$m_id' ")or die(mysqli_error($conn));

		if($sql){
			echo "1";
		}else{
			echo "0";
		}
	}

}

$c_id = mysqli_escape_string($conn,$_POST['c_id']);
$c_name = mysqli_escape_string($conn,$_POST['c_name']);

if ($_POST['insert_category'] === "insert_category") {

	$sql_num = mysqli_query($conn,"SELECT * FROM  category Where c_name = '$c_name' ");
	$row = mysqli_num_rows($sql_num);
	if($row >= "1"){

		echo "2";

	}else{

		$sql = mysqli_query($conn,"INSERT INTO category (c_name) VALUES ('$c_name')");
		if($sql){
			echo "1";
		}else{
			echo "0";
		}	
	}
}

if($_POST['update_category'] === "update_category"){
	$sql0 = mysqli_query($conn,"SELECT * FROM category Where c_name = '$c_name' and c_id != '$c_id' ");
	$row  = mysqli_num_rows($sql0);
	$rs = mysqli_fetch_assoc($sql0);

	if($row >="1"){
		echo "2";
	}else{

		$sql = mysqli_query($conn,"UPDATE category SET  c_name= '$c_name' Where c_id = '$c_id' ");

		if($sql){
			echo "1";
		}else{
			echo "0";
		}
	}
}

if($_POST['del_category'] === "del_category"){


	$sql = mysqli_query($conn,"DELETE FROM category WHERE  c_id = '$c_id' ");
	if($sql){
		echo "1";
	}else{
		echo "0";
	}

}

$pd_name    = mysqli_escape_string($conn,$_POST['pd_name']);
$pd_status  = mysqli_escape_string($conn,$_POST['pd_status']);
$date       = date("Y-m-d");
if ($_POST['insert_pending'] === "insert_pending") {

	$sql = mysqli_query($conn,"INSERT INTO pending (pd_name,pd_status,pd_date)VALUES('$pd_name','$pd_status','$date')");
	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}

if($_POST['update_working_day'] == 'update_working_day'){
	$m_id  = mysqli_escape_string($conn,$_POST['m_id']);

	$sql = mysqli_query($conn,"SELECT * FROM schedule WHERE m_id = '$m_id' ");
	$rs = mysqli_fetch_assoc($sql);

	if($rs['m_id']){

		for ($i = 0; $i < count($_POST['work_start']); $i++){

			$work_start = $_POST['work_start'][$i];
			$work_end = $_POST['work_end'][$i];
			$ii=$i+1;
			$work_start = $work_start =="" ? "00:00:00" : $work_start;
			$work_end =  $work_end =="" ? "00:00:00" : $work_end;
			$sql = mysqli_query($conn,"UPDATE schedule SET work_start = '$work_start' ,work_end = '$work_end' 
				Where m_id = '$m_id' and wd_id ='$ii' ");	
		}

	}

	if(!$rs['m_id']){

		for ($i = 0; $i < count($_POST['work_start']); $i++){ 

			$work_start = $_POST['work_start'][$i];
			$work_end = $_POST['work_end'][$i];
			$ii=$i+1;
			$work_start = $work_start =="" ? "00:00:00" : $work_start;
			$work_end =  $work_end =="" ? "00:00:00" : $work_end;

			$sql = mysqli_query($conn,"INSERT INTO  schedule(m_id,wd_id,work_start,work_end)VALUES('$m_id','$ii',
				'$work_start','$work_end')")or die(mysqli_error($conn));
		}

	}      


	
	if($sql){
		$show = '1';
	}else{
		$show ='0';
	}

	$name = array('data' => $show);
	echo json_encode($name);

}


if($_POST['update_zone'] == "update_zone"){

	$id = mysqli_escape_string($conn,$_POST['z_id']);
	$z_name = mysqli_escape_string($conn,$_POST['z_name']);

	$sql = mysqli_query($conn,"UPDATE zone SET  z_name = '$z_name' WHERE z_id = '$id' ");

	if($sql){
		$show  = "1";
	}else{
		$show = "0";
	}	

	$arrayName = array('data' => $show);
	echo json_encode($arrayName);

}


if($_POST['del_zone'] == "del_zone"){

	$id = mysqli_escape_string($conn,$_POST['z_id']);
	$sql = mysqli_query($conn,"DELETE FROM zone WHERE z_id = '$id' ");

	if($sql){
		$show = "1";
	}else{
		$show = "0";
	}

	$arrayName = array('data' => $show );
	echo json_encode($arrayName);
}

if($_POST['insert_zone'] =="insert_zone"){

	$id = mysqli_escape_string($conn,$_POST['z_id']);
	$z_name = mysqli_escape_string($conn,$_POST['z_name']);
	$sql = mysqli_query($conn,"INSERT INTO zone(z_name)values('$z_name')"); 

	if($sql){
		$show = '1';
	}else{
		$show = "0";
	}
	$arrayName = array('data' => $show );
	echo json_encode($arrayName);
}

if($_POST['update_comm'] == "update_comm"){
	
	$com_name = mysqli_escape_string($conn,$_POST['com_name']);

	$path="img/";
	$file= $_FILES['file']['name'];
	$file_type=strrchr($file,'.');
	$pic_name="logo".strtoupper($file_type);
	copy($_FILES["file"]["tmp_name"],$path.$pic_name);

	$sql = mysqli_query($conn,"UPDATE company_logo SET com_name = '$com_name',com_logo='$pic_name' Where com_id = 1 ");

	
	if($sql){
		$show = '1';
	}else{
		$show = "0";
	}
	$arrayName = array('data' => $show );
	echo json_encode($arrayName);
	

}



?>