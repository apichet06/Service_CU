<?php 
require_once '../db/config.php';
$sql0 = mysqli_query($conn,"SELECT * FROM schedule  Where m_id = '".$_POST['m_id']."' ORDER BY wd_id asc ");
                 $wd_id      = array(); 
                 $work_start = array();
                 $work_end   = array();                   
                 while ($rs0 = mysqli_fetch_assoc($sql0)){
                  array_push($wd_id,$rs0['wd_id']); 
                  array_push($work_start,$rs0['work_start']);
                  array_push($work_end,$rs0['work_end']);   
                }

	$show .= '<table class="table table-sm table-responsive-sm">
					<thead>
						<tr>
							<th>#</th>
							<th>วันทำงาน</th>
							<th>เวลาเริ่ม</th>
							<th>เวลาสิ้นสุด</th>
						</tr>
					</thead>
					<tbody>';

$sql0 = mysqli_query($conn,"SELECT * FROM schedule  Where m_id = '".$_POST['m_id']."'");
$row = mysqli_num_rows($sql0);
	if($row >= 1){
			$sql = mysqli_query($conn,"SELECT * FROM  working_day a 
			 	LEFT JOIN schedule b 
			 	ON a.wd_id = b.wd_id
			 	where b.m_id = '".$_POST['m_id']."'
			 	ORDER BY a.wd_id asc");
	
	}else{

	$sql = mysqli_query($conn,"SELECT * FROM  working_day ORDER BY wd_id asc");	
	
	}				
			 
                $i=0; $ii=1; 
                while ($rs= mysqli_fetch_assoc($sql)) { 

					$show .= '<tr>
								<td>'.$ii++.'. </td>
								<td>'.$rs['wd_name'].'</td>
								<td><select name="work_start[]" class="form-control-sm form-control">
									<option value="">--- เวลาเริ่ม ---</option> ';
						 $sql0 = mysqli_query($conn,"SELECT * FROM attend_work"); 
									while ($rs0 = mysqli_fetch_assoc($sql0)) {
									$show .= '<option value="'.$rs0['at_attend'].'"';
									 if ($rs0['at_attend']==$work_start[$i]) { $show .='SELECTED'; }
									$show .='>'.$rs0['at_attend'].'</option>';
									}
				      $show .= '</select></td>
								<td><select name="work_end[]" class="form-control-sm form-control">
									<option value="">--- เวลาสิ้นสุด ---</option>';
								$sql0 = mysqli_query($conn,"SELECT * FROM attend_work"); 
									while ($rs0 = mysqli_fetch_assoc($sql0)) {
					 $show .= '<option value="'.$rs0['at_finish'].'"';
									 if ($rs0['at_finish']==$work_end[$i]) { $show .='SELECTED'; }
									$show .='>'.$rs0['at_finish'].'</option>';
									}
				      $show .= '</select></td>
							</tr>';
						$i++; } 
					$show .= '</tbody>
				</table>';


$name = array('data' => $show);
echo   json_encode($name);
?>


