<?php require_once '../db/config.php'; 
//sleep(1);
if(isset($_POST['zid'])) {

	if($_POST['place'] == "place"){
		$sql = mysqli_query($conn,"SELECT place_id,place_name FROM place WHERE z_id = '".$_POST['zid']."'");
		$data = array();
		while($row = mysqli_fetch_assoc($sql)) {
			$data[] = $row;
		}
		echo json_encode($data);
	}

	if($_POST['member'] == "member"){
		$sql = mysqli_query($conn,"SELECT a.m_id,c.z_id,m_name,d.dv_name_short,p_name FROM member a 
			INNER JOIN area_zone b 
			on a.m_id = b.m_id 
			INNER JOIN zone c 
			on c.z_id = b.z_id  
			INNER JOIN division d 
			on d.dv_id = a.dv_id
			INNER JOIN position e 
			on e.p_id = a.p_id
			WHERE c.z_id = '".$_POST['zid']."'  and a.p_id != '3' ");
		$data = array();
		while($row = mysqli_fetch_assoc($sql)) {
			$data[] = $row;
		}
		echo json_encode($data);
	}

	
}
?>