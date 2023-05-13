<?php require_once '../db/config.php';

$id = mysqli_escape_string($conn,$_POST['id']);
$t_note = mysqli_escape_string($conn,$_POST['t_note']);

if($_POST['update']=="update_t_note"){
	$sql = mysqli_query($conn,"UPDATE   job_in_out  SET  t_note = '$t_note' Where j_inout_id = '$id' ");

	if($sql){
		$show = "1";
	}else{
		$show = "0";
	}
	$name = array('data' => $show );
	echo json_encode($name);
}

if($_POST['update'] == "update_leave"){
	$date 		= $_POST['date_time'];
	$j_approve	= $_POST['j_approve'];

	$date_time = date("$date H:i:s");

	$sql0 = mysqli_query($conn,"SELECT * FROM job_in_out Where date(date_in_out) = '$date' and m_id = '$id' ");
	$rs = mysqli_fetch_assoc($sql0);

	/****** ค้นหารายการ in out *******/
	$sql_in  = mysqli_query($conn,"SELECT * FROM job_in_out Where date(date_in_out) = '$date' and m_id = '$id' and action = 'In'");
	$rs_in   = mysqli_fetch_assoc($sql_in);
	$sql_out = mysqli_query($conn,"SELECT * FROM job_in_out Where date(date_in_out) = '$date' and m_id = '$id' and action = 'Out' ");
	$rs_out = mysqli_fetch_assoc($sql_out);

	if(mysqli_num_rows($sql0) >= "1"){
		
		if($rs['action']=="In"){
			if(mysqli_num_rows($sql_out) <= "0"){
				$sql = mysqli_query($conn,"INSERT INTO job_in_out(m_id,action,date_in_out,t_note,gps,j_approve)
					VALUES('$id','Out','".$rs['date_in_out']."','$t_note','','$j_approve')");
			}
		}
		if($rs['action']=="Out"){
			if(mysqli_num_rows($sql_in) <= "0"){
				$sql = mysqli_query($conn,"INSERT INTO job_in_out(m_id,action,date_in_out,t_note,gps,j_approve)
					VALUES('$id','In','".$rs['date_in_out']."','$t_note','','$j_approve')")or die(mysqli_error($conn));
			}
		}

		/* update พร้อมกันทั้งเข้างาน และออกงาน(เลิกงาน) กรณที่มีค่าว่าง */
		if($rs['trans_pic']=="" and $rs['gps']==""){
			$sql = mysqli_query($conn,"UPDATE job_in_out SET t_note = '$t_note' ,j_approve ='$j_approve' Where m_id = '$id' and date(date_in_out) = '$date'");
		}
		 //echo $rs['trans_pic']." -- 8848"; echo $rs_out['gps']." -- 8848";
		if($t_note=="" and $rs_in['gps'] =="" and $rs_in['trans_pic']==""){
			$sql = mysqli_query($conn,"DELETE FROM job_in_out Where m_id = '$id' and date(date_in_out) = '$date' and action = 'In' "); 
		}
		if($t_note=="" and $rs_out['gps'] =="" and $rs_out['trans_pic']==""){
			$sql = mysqli_query($conn,"DELETE FROM job_in_out Where m_id = '$id' and date(date_in_out) = '$date' and action = 'Out' ");
		}	

		if($sql){
			$show = "1";
		}else{
			$show = "0";
		}

	}else{

		$sql = mysqli_query($conn,"INSERT INTO job_in_out(m_id,action,date_in_out,t_note,gps,j_approve)
			VALUES('$id','In','$date_time','$t_note','','$j_approve')")or die(mysqli_error($conn));
		$sql = mysqli_query($conn,"INSERT INTO job_in_out(m_id,action,date_in_out,t_note,gps,j_approve)
			VALUES('$id','Out','$date_time','$t_note','','$j_approve')");

		if($sql){
			$show = "1";
		}else{
			$show = "0";
		}

	}

	$data =  array('data'=> $show);
	echo json_encode($data);
}

?>