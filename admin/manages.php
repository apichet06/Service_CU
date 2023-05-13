<?php require_once '../db/config.php';
session_start();
$sql = mysqli_query($conn,"SELECT * FROM member a 
	INNER JOIN division b 
	on a.dv_id = b.dv_id
	Where username = '".$_SESSION['login_user']."' ");
$rs0 		   = mysqli_fetch_assoc($sql);
$dv_id 		   = $rs0['dv_id'];
$ws_sender 	   = $rs0['m_id'];

$ws_id 		   = mysqli_escape_string($conn,$_POST['id']); //รหัสใบงาน
$m_id 		   = mysqli_escape_string($conn,$_POST['m_id']); //รหัสช่าง
$z_id 		   = mysqli_escape_string($conn,$_POST['z_id']); //zone ภูมิภาค
$place_id 	   = mysqli_escape_string($conn,$_POST['place_id']); //พื้นที่ต้องการไปซ่อมงาน
$c_id 		   = mysqli_escape_string($conn,$_POST['c_id']); // ประเภทงาน
//$dv_id 		   = mysqli_escape_string($conn,$_POST['dv_id']); // แผนกของช่าง
//$ws_sender	   = mysqli_escape_string($conn,$_POST['ws_sender']);//ผู้ส่งใบงาน
$ws_request    = mysqli_escape_string($conn,$_POST['ws_request']); //รายละเอียดงาน
$ws_name 	   = mysqli_escape_string($conn,$_POST['ws_name']); //ชื่อใบงาน
$ws_start_date = mysqli_escape_string($conn,$_POST['ws_start_date']); //เวลาที่ต้องการให้เริ่มงาน
$ws_end_date   = mysqli_escape_string($conn,$_POST['ws_end_date']); //เวลาที่ต้องการให้งานเสร็จ
$ws_end_date_hour = mysqli_escape_string($conn,$_POST['ws_end_date_hour']); //เวลาที่ต้องการให้งานเสร็จแบบชั่วโมง
$date 		   = date("Y-m-d");//เวลาสร้างใบงาน
//exit();
//$strStartDate =date('Y-m-d H:m:i');
if($ws_end_date_hour ==""){
	
	if($ws_end_date){
		$ws_end_date = $ws_end_date;
	}else{
		$ws_end_date = "0000-00-00 00:00:00";
	}	
}else{
	$ws_end_date = date ("Y-m-d H:i:s", strtotime("+$ws_end_date_hour hours", strtotime(date($ws_start_date))));
}


if($dv_id =='1'){
	$ws_number_id  = "CM".date('Ymdmis');
}elseif ($dv_id =='2') {
	$ws_number_id  = "PM".date('Ymdmis');
}elseif ($dv_id =='3') {
	$ws_number_id  = "IN".date('Ymdmis');
}elseif ($dv_id =='4') {
	$ws_number_id  = "AD".date('Ymdmis');
}


if ($_POST['insert_worksheet'] == "insert_worksheet") {
	
	$sql = mysqli_query($conn,"INSERT INTO worksheet (m_id,z_id,place_id,c_id,dv_id,ws_number_id,ws_sender,
		ws_request,ws_name,ws_start_date,ws_end_date,ws_date,ws_jobdescription)
		VALUES('$m_id','$z_id','$place_id','$c_id','$dv_id','$ws_number_id','$ws_sender','$ws_request','$ws_name','$ws_start_date','$ws_end_date','$date','$ws_request')")or die(mysqli_error($conn));

	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}

if($_POST['update_work']=="update_work"){
	if($place_id){ $sql = mysqli_query($conn,"UPDATE worksheet SET place_id = '$place_id' WHERE ws_id = '$ws_id'");}
	if($m_id){ $sql = mysqli_query($conn,"UPDATE worksheet SET m_id = '$m_id' WHERE ws_id = '$ws_id'"); }
	if($z_id){ $sql = mysqli_query($conn,"UPDATE worksheet SET z_id = '$z_id' WHERE ws_id = '$ws_id'");}		
	
	$sql = mysqli_query($conn,"UPDATE worksheet SET 
		c_id 			  = '$c_id',
		ws_request 		  = '$ws_request',
		ws_jobdescription = '$ws_request',
		ws_name 		  = '$ws_name',
		ws_start_date 	  = '$ws_start_date',
		ws_end_date 	  = '$ws_end_date'
		WHERE ws_id 	  = '$ws_id' ")or die(mysqli_error($conn));
	if($sql){
		$show = '1';
	}else{
		$show = '0';
	}

	$arrayName = array('data' => $show );
	echo json_encode($arrayName);
}




if ($_POST['insert_deliver_work'] == "insert_deliver_work") {
	$sql = mysqli_query($conn,"UPDATE worksheet set new_job ='1'  WHERE  ws_id = '$ws_id' ");

	$sql = mysqli_query($conn,"INSERT INTO worksheet (m_id,z_id,place_id,c_id,dv_id,ws_sender,
		ws_request,ws_name,ws_start_date,ws_end_date,ws_date,ws_number_id)
		VALUES('$m_id','$z_id','$place_id','$c_id','$dv_id','$ws_sender','$ws_request','$ws_name','$ws_start_date',
		'$ws_end_date','$date','$ws_number_id')")or die(mysqli_error($conn));

	if($sql){
		echo "1";
	}else{
		echo "0";
	}
}




if($_POST['del_ws'] == "del_ws"){
	$sql0 = mysqli_query($conn,"SELECT a.ws_job_start,b.ws_id FROM worksheet a 
		LEFT JOIN transfer_job b 
		on a.ws_id = b.ws_id
		WHERE a.ws_id = '$ws_id' ")or die(mysqli_error($conn));
	$rows = mysqli_fetch_assoc($sql0);

	if($rows['ws_job_start'] == "" and $rows['ws_id'] == "" ){
		$sql = mysqli_query($conn,"DELETE FROM worksheet  WHERE  ws_id = '$ws_id' ");
		if($sql){
			echo "1";
		}else{
			echo "0";
		}	
	}else{
		echo "11";
	}
}





if($_POST['todu'] == "update_report"){

	$ws_id 				= mysqli_escape_string($conn,$_POST['ws_id']);
	$ws_request1 		= mysqli_escape_string($conn,$_POST['ws_request']);
	$panding_note 		= mysqli_escape_string($conn,$_POST['panding_note']);
	$t_reason 			= mysqli_escape_string($conn,$_POST['t_reason']); //คืนงาน
    $panding_status     = mysqli_escape_string($conn,$_POST['panding_status']);
	$ws_name  			= mysqli_escape_string($conn,$_POST['ws_name']);
	$dv_id  			= mysqli_escape_string($conn,$_POST['dv_id']);
	$z_id  				= mysqli_escape_string($conn,$_POST['z_id']);
	$p_id  				= mysqli_escape_string($conn,$_POST['p_id']);
	$sender_id  		= mysqli_escape_string($conn,$_POST['sender_id']);
	$c_id  				= mysqli_escape_string($conn,$_POST['c_id']);
	$m_id  				= mysqli_escape_string($conn,$_POST['m_id']);
	$ws_start_date  	= mysqli_escape_string($conn,$_POST['ws_start_date']);
	$ws_end_date  		= mysqli_escape_string($conn,$_POST['ws_end_date']);
	$ws_job_start  		= mysqli_escape_string($conn,$_POST['ws_job_start']);
	$ws_job_end  		= mysqli_escape_string($conn,$_POST['ws_job_end']);    
    

 if($ws_start_date){
$sql = mysqli_query($conn,"UPDATE worksheet SET ws_start_date = '$ws_start_date' WHERE ws_id = '$ws_id' ")or die(mysqli_error($conn));
 }   
 if($ws_end_date){
$sql = mysqli_query($conn,"UPDATE worksheet SET ws_end_date  = '$ws_end_date' WHERE ws_id = '$ws_id' ")or die(mysqli_error($conn)); 
}
 if($ws_job_start){
$sql = mysqli_query($conn,"UPDATE worksheet SET ws_job_start = '$ws_job_start' WHERE ws_id = '$ws_id' ")or die(mysqli_error($conn)); 
 } 
 if($ws_job_end){
$sql = mysqli_query($conn,"UPDATE worksheet SET ws_job_end = '$ws_job_end' WHERE ws_id = '$ws_id' ")or die(mysqli_error($conn)); 
 }

	$sql = mysqli_query($conn,"UPDATE worksheet SET 
		panding_note		= '$panding_note' ,
		ws_jobdescription 	= '$ws_request1',
		ws_name 			= '$ws_name',
		dv_id 				= '$dv_id',
		z_id 				= '$z_id',
		place_id			= '$p_id',
		ws_sender 			= '$sender_id',
		c_id 				= '$c_id',
		m_id 				= '$m_id',
		panding_status	    = '$panding_status'
		WHERE ws_id 		= '$ws_id' ")or die(mysqli_error($conn));

	$sql = mysqli_query($conn,"UPDATE transfer_job SET  t_reason ='$t_reason' WHERE ws_id = '$ws_id' ");
	
	if($sql){

		$show = "1";

	}else{

		$show = "0";

	}

	$name = array('data' => $show);
	echo json_encode($name);
}


?>