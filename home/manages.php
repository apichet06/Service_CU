<?php  session_start();  require_once '../db/config.php'; require_once '../menu/datetime_function.php';

$id = mysqli_escape_string($conn,$_POST['id']);
$ps = mysqli_escape_string($conn,$_POST['ps']);

if($ps =="sla"){ 
	$out .='<table class="table  table-bordered table-sm table-responsive-sm" id="data4">
		<thead  class="align-middle text-nowrap">
			<tr>
				<th>No.</th>
				<th>ชื่อช่าง</th>
				<th>ชื่อใบงาน</th>
				<th>สถานที่</th>
				<th>กำหนดเริ่มงาน</th>
				<th>กำหนดเสร็จ</th>
				<th>เวลาที่เหลือ</th>
			</tr>
		</thead>  
		<tbody  class="align-middle text-nowrap">';

			//$strNewDate = date ("Y-m-d H:i:s", strtotime("+2 day", strtotime(date('Y-m-d H:i:s'))));
      $strNewDate = date("Y-m-d H:i:s");
      if($id){
			$sql = mysqli_query($conn,"SELECT * FROM worksheet a 
				INNER JOIN member b 
				on a.m_id = b.m_id
				INNER JOIN division c 
				on a.dv_id = c.dv_id
				INNER JOIN place e 
				on a.place_id = e.place_id
				WHERE  date(a.ws_end_date) <=  '$strNewDate' and ISNULL(a.ws_job_end) and a.ws_id = '$id' and a.ws_end_date !='0000-00-00 00:00:00'
				ORDER BY a.m_id")or die(mysqli_error($conn)); 
    }else{
       $sql = mysqli_query($conn,"SELECT * FROM worksheet a 
        INNER JOIN member b 
        on a.m_id = b.m_id
        INNER JOIN division c 
        on a.dv_id = c.dv_id
        INNER JOIN place e 
        on a.place_id = e.place_id
        WHERE  date(a.ws_end_date) <=  '$strNewDate' and ISNULL(a.ws_job_end) and a.ws_end_date !='0000-00-00 00:00:00'
        ORDER BY a.m_id")or die(mysqli_error($conn)); 
    }
			$i=1;
			while ($rs = mysqli_fetch_assoc($sql)) { 
				$date0 = strtotime($rs['ws_end_date']);
				$name  = explode(' ',$rs['m_name']);

				if(strtotime(date($rs['ws_end_date'])) <= strtotime(date("Y-m-d H:i:s")) ){
					$date = DateDiff_Before_timeout($rs['ws_end_date'],date("Y-m-d H:i:s"));
				}else{
					$date = DateDiff_Over_time(date("Y-m-d H:i:s"),$rs['ws_end_date']);
				}
				
				$out .='<tr>
							<td>'.$i++.'</td>
							<td>'.$name[0]." (".$rs['dv_name_short'].")".'</td>
							<td>'.$rs['ws_name'].'</td>
							<td>'.$rs['place_name'].'</td>
							<td>'.$rs['ws_start_date'].'</td>
							<td>'.$rs['ws_end_date'].'</td>
							<td>'.$date.'</td>
					    </tr>';
					}
				$out .='</tbody>
			</table>';
	 }

if($ps =="mechanic_start_work_today"){

	$out .='<table class="table table-striped table-sm table-responsive table-bordered" id="data3">
                  <thead class="text-nowrap align-middle">
                    <tr>
                      <th>#</th>
                      <th>ชื่อช่าง</th>
                      <th>ใบงาน</th>
                      <th>สถานที่ปฏิบัติงาน</th>
                      <th>แผนก</th>
                      <th>กำหนดเริ่มงาน</th>
                      <th>กำหนดปิดงาน</th>
                      <th>วันที่เริ่มงาน</th>
                      <th>วันที่ปิดงาน</th>
                      <th>รายละเอียดการปิดงาน</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody class="text-nowrap align-middle"> ';
                  if($id){
                    $date = date("Y-m-d");
                    $sql = mysqli_query($conn,"SELECT * FROM worksheet a 
                      INNER JOIN member b 
                      on a.m_id = b.m_id
                      LEFT JOIN place c 
                      on a.place_id = c.place_id
                      INNER JOIN division d 
                      on a.dv_id = d.dv_id
                      Where date(a.ws_job_start) = '$date' and a.ws_id = '$id' ");
                  }else{
                    $date = date("Y-m-d");
                    $sql = mysqli_query($conn,"SELECT * FROM worksheet a 
                      INNER JOIN member b 
                      on a.m_id = b.m_id
                      LEFT JOIN place c 
                      on a.place_id = c.place_id
                      INNER JOIN division d 
                      on a.dv_id = d.dv_id
                      Where date(a.ws_job_start) = '$date'");
                  }
                   
                    $i = 1; 
                    while ($rs = mysqli_fetch_assoc($sql)) { 
            $out .= '<tr>
                      <td>'.$i++.'</td>
                      <td>'.$rs['m_name'].'</td>
                      <td>'.$rs['ws_name'].'</td>
                      <td>'.$rs['place_name'].'</td>
                      <td>'.$rs['dv_name_short'].'</td>
                      <td>'.$rs['ws_start_date'].'</td>
                      <td>'.$rs['ws_end_date'].'</td>
                      <td>'.$rs['ws_job_start'].'</td>

                      <td>';
                    
                        if($rs['ws_job_end']){
                         $out .=$rs['ws_job_end'];
                        }else{
                         $out .='<div class="text-center">-</div>';
                        }
              $out .= '</td>
                         <td>';
              $out .=  $rs['ws_jobdescription']=="" ? "-" :  $rs['ws_jobdescription'];
              $out .=  '</td>
                        <td class="text-nowrap align-middle text-center">';
                        if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == '' ){
                       $out .= $rs['panding_note'] =='' ? '<i class="fa fa-play-circle fa-lg text-success"></i>'
                        : '<i class="fa fa-spinner fa-lg text-info fa-spin"></i>';
                        }else{
                       $out .= '<i class="fa fa-lg fa-step-forward"></i>';
                        }
                      
             $out .= ' </td>
                    </tr>';
                  }
           $out .= '</tbody>
              </table>';

}


if($ps == "work_today"){

$out .='<table class="table table-striped table-sm table-responsive-sm" id="data1">
              <thead class="align-middle text-nowrap">
                <tr>
                  <th>#</th>
                  <th>ชื่อใบงาน</th>
                  <th>ประเภท</th>
                  <th class="text-center">สถานที่</th>
                  <th>สร้างใบงาน</th>
                  <th>รับงาน</th>
                  <th>แผนก</th>
                  <th>วันที่เริ่มงาน</th>
                  <th class="text-center">สถานะ</th>
                </tr>
              </thead>
              <tbody class="text-nowrap align-middle thead-dark">';
              if($id){
                $date = date("Y-m-d");
                $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
                  LEFT JOIN category b 
                  on a.c_id = b.c_id 
                  LEFT JOIN place c 
                  on c.place_id = a.place_id
                  INNER JOIN member d 
                  on a.m_id = d.m_id
                  LEFT JOIN member e 
                  on a.ws_sender = e.m_id 
                  LEFT JOIN division f 
                  on a.dv_id = f.dv_id
                  WHERE date(a.ws_start_date) = '$date'  and a.ws_id = '$id'
                  ORDER BY a.m_id asc"); 
              }else{
                $date = date("Y-m-d");
                $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
                  LEFT JOIN category b 
                  on a.c_id = b.c_id 
                  LEFT JOIN place c 
                  on c.place_id = a.place_id
                  INNER JOIN member d 
                  on a.m_id = d.m_id
                  LEFT JOIN member e 
                  on a.ws_sender = e.m_id 
                  LEFT JOIN division f 
                  on a.dv_id = f.dv_id
                  WHERE date(a.ws_start_date) = '$date' 
                  ORDER BY a.m_id asc"); 
              }
               
                $i=1;
                while($rs = mysqli_fetch_assoc($sql)){ 
                  $sender = explode(" ",$rs['sender']);
         
                 $out .='<tr>
                    <td>'.$i++.'</td>
                    <td>'.$rs['ws_name'].'</td>
                    <td>'.$rs['c_name'].'</td><td class="text-center">';
                $out .=$rs['place_name'] =="" ? "-" : $rs['place_name'];
                $out .='</td><td>K. '.$sender[0].'</td>
                    <td>K. '.$rs['m_name'].'</td>
                    <td>'.$rs['dv_name_short'].'</td>
                    <td>'.$rs['ws_job_start'].'</td>
                    <td class="text-center">';
                     $out .= $rs['ws_job_start'] =="" ? "<i class='fa fa-ban fa-lg text-danger'></i>" : 
                      "<i class='fa fa-play-circle fa-lg text-success'>";
                     $out .='</td>
                  </tr>';
                } 
             $out .=' </tbody>
            </table>';
}


if($ps == "transfer_job"){

   $out .='<table class="table table-inverse table-striped table-responsive-sm table-sm" id="data1">
         <thead class="text-nowrap align-middle ">
           <tr>
            <th>#</th>
            <th>เลขที่ใบงาน</th>
            <th>ชื่อใบงาน</th>
            <th>(Zone)เขตพื้นที่</th>
            <th>สถานที่</th>
            <th>แผนก</th>
            <th>ประเภทงาน</th>
            <th>ผู้สร้างใบงาน</th>
            <th>ชื่อช่าง</th>
            <th>เหตุผลที่ช่างคืนงาน</th>
            <th>วันที่ช่างคืนงาน</th>
          </tr>
        </thead>
        <tbody class="text-nowrap align-middle">';

          if($id){
           $date = date("Y-m-d");
           $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl
           FROM transfer_job a 
           INNER JOIN worksheet b 
           on a.ws_id = b.ws_id
           LEFT JOIN zone c 
           on b.z_id = c.z_id 
           LEFT JOIN place d 
           on d.place_id = b.place_id 
           INNER JOIN  division e 
           on e.dv_id = b.dv_id
           LEFT JOIN member f 
           on f.m_id = b.ws_sender
           LEFT JOIN member g 
           on g.m_id = a.m_id
           INNER JOIN category h 
           on h.c_id = b.c_id
           WHERE date(a.t_date) = '$date'  and b.ws_id = '$id' 
           ORDER BY a.t_id DESC")or die(mysqli_error($conn));
       
        }else{
           $date = date("Y-m-d");
           $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl
           FROM transfer_job a 
           INNER JOIN worksheet b 
           on a.ws_id = b.ws_id
           LEFT JOIN zone c 
           on b.z_id = c.z_id 
           LEFT JOIN place d 
           on d.place_id = b.place_id 
           INNER JOIN  division e 
           on e.dv_id = b.dv_id
           LEFT JOIN member f 
           on f.m_id = b.ws_sender
           LEFT JOIN member g 
           on g.m_id = a.m_id
           INNER JOIN category h 
           on h.c_id = b.c_id
           WHERE date(a.t_date) = '$date' 
           ORDER BY a.t_id DESC")or die(mysqli_error($conn));
        } 
          $i=1;
          while($rs = mysqli_fetch_assoc($sql)){ 
            $out .='<tr>
             <td>'.$i.'</td>
             <td>'.$rs['ws_number_id'].'</td>
             <td>'.$rs['ws_name'].'</td>
             <td>'.$rs['z_name'].'</td>
             <td>'.$rs['place_name'].'</td>
             <td>'.$rs['dv_name']." (".$rs['dv_name_short'].")".'</td> 
             <td>'.$rs['c_name'].'</td>
             <td>'.$rs['m_sender'].'</td>
             <td>'.$rs['m_name'].'</td>
             <td>'.$rs['t_reason'].'</td>
             <td>'.$rs['t_date'].'</td>
           </tr>';
          $i++; }
         $out .=' </tbody>
       </table>';

}


$data = array('data_ws' => $out );
echo json_encode($data);
