<?php
	require_once '../db/config.php';
	
	$sql  =  mysqli_query($conn,"SELECT * FROM job_in_out Where m_id LIKE '%5%' ");
	$rs   = mysqli_fetch_array($sql);
    $data = array('gps' => $rs['gps'] );

	echo json_encode($data);
?>
