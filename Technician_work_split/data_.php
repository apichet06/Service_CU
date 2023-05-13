<?php  require_once '../db/config.php';

if(!$_POST['full']){


###########################
#    งานตก lsa 			  #
###########################
	$date = date("Y-m-d H:i:s");
	$sql0 = mysqli_query($conn,"SELECT * FROM worksheet a 
		LEFT JOIN member b 
		on a.m_id = b.m_id
		LEFT JOIN division c 
		on a.dv_id = c.dv_id
		LEFT JOIN place e 
		on a.place_id = e.place_id
		LEFT JOIN category f 
		ON f.c_id = a.c_id
		LEFT JOIN zone g 
		ON g.z_id = a.z_id
		WHERE  a.ws_end_date <= '$date' and ISNULL(a.ws_job_end)  and a.ws_end_date !='' and a.c_id = '".$_POST['c_id']."' and a.z_id = '".$_POST['z_id']."' and date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."' and a.m_id = '".$_POST['m_id']."' ");
	$sla = mysqli_num_rows($sql0);


###########################
#    	   คืนงาน 		  #
###########################
	$sql = mysqli_query($conn,"SELECT * FROM transfer_job a
		INNER JOIN worksheet b 
		ON a.ws_id = b.ws_id 
		INNER JOIN zone c 
		on c.z_id = b.z_id 
		WHERE  b.z_id = '".$_POST['z_id']."' and date(b.ws_date) >= '".$_POST['date_1']."' and date(b.ws_date) <= '".$_POST['date_2']."'  and a.m_id = '".$_POST['m_id']."' "); 
	$transfer = mysqli_num_rows($sql);

#########################################################

	$sql0 = mysqli_query($conn,"SELECT count(panding_note)as panding from worksheet 
		Where panding_note!='' and ISNULL(ws_job_end) and c_id = '".$_POST['c_id']."' and z_id = '".$_POST['z_id']."' and date(ws_date) >= '".$_POST['date_1']."' and date(ws_date) <= '".$_POST['date_2']."' and m_id = '".$_POST['m_id']."' 
		")or die(mysqli_error($conn));
	$rs0 = mysqli_fetch_assoc($sql0);

##################################
#  			เริ่มงานแล้วยังไม่ปิดงาน		 # 
################################## 

	$sql_job_start  = mysqli_query($conn,"SELECT * FROM worksheet WHERE  ws_job_start !='' and ISNULL(ws_job_end) and 
		c_id = '".$_POST['c_id']."' and z_id = '".$_POST['z_id']."' and m_id = '".$_POST['m_id']."' and (date(ws_date) >= '".$_POST['date_1']."' and date(ws_date) <= '".$_POST['date_2']."') "); 
	$job_start 	= mysqli_num_rows($sql_job_start);

################################## 
#  			ยังไม่เริ่มงาน			 # 
################################## 

	$sqlno_job  = mysqli_query($conn,"SELECT * FROM worksheet WHERE  ISNULL(ws_job_start) and 
		c_id = '".$_POST['c_id']."' and z_id = '".$_POST['z_id']."' and m_id = '".$_POST['m_id']."' and (date(ws_date) >= '".$_POST['date_1']."' and date(ws_date) <= '".$_POST['date_2']."') "); 
	$rsno_job 	= mysqli_num_rows($sqlno_job);

#########################################################

	$sql = mysqli_query($conn,"SELECT m_name,dv_name,dv_name_short,c_name,z_name,year(b.ws_date)as year,count(b.c_id)as s_sum,count(ws_job_end)as end_job,count(b.ws_id)as sum_transfer FROM member a
		LEFT JOIN worksheet b 
		ON a.m_id = b.m_id
		LEFT JOIN division c 
		ON a.dv_id = c.dv_id 
		LEFT JOIN category d 
		ON b.c_id = d.c_id
		LEFT JOIN zone e 
		ON e.z_id = b.z_id
		Where date(b.ws_date) >= '".$_POST['date_1']."' and date(b.ws_date) <='".$_POST['date_2']."'  and b.m_id = '".$_POST['m_id']."' and b.c_id = '".$_POST['c_id']."' and b.z_id = '".$_POST['z_id']."'
		Group by b.m_id")or die(mysqli_error($conn));
	$rs = mysqli_fetch_assoc($sql);

	$x  = $rs['end_job']+$transfer+$rs0['panding']+$sla+$rsno_job+$job_start; ?>
	<div  class="tile "> <hr>
		<table class="table table-bordered table-inverse text-center">
			<thead>
				<tr>
					<th colspan="2"><?=$rs['m_name']?> : <?=$rs['dv_name']."(".$rs['dv_name_short'].")"?></th>
					<th>ปี : <?=$rs['year']?></th>
				</tr>
				<tr>
					<th>ประเภท : <?=$rs['c_name'];?></th>
					<th colspan="2">โซน : <?=$rs['z_name']?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th><a href="" class="full_job"
						data-m_id="<?=$_POST['m_id']?>"
						data-date_1 ="<?=$_POST['date_1']?>"
						data-date_2 ="<?=$_POST['date_2']?>"
						data-z_id = "<?=$_POST['z_id']?>"
						data-c_id = "<?=$_POST['c_id']?>"
						data-action = "เริ่มงานแล้วยังไม่ปิดงาน">เริ่มงานแล้วยังไม่ปิดงาน</a></th>
						<th colspan="2">(<?=$job_start?>)</th>
					</tr>
					<tr>
						<th><a href="" class="full_job"
							data-m_id="<?=$_POST['m_id']?>"
							data-date_1 ="<?=$_POST['date_1']?>"
							data-date_2 ="<?=$_POST['date_2']?>"
							data-z_id = "<?=$_POST['z_id']?>"
							data-c_id = "<?=$_POST['c_id']?>"
							data-action = "ยังไม่เริ่มงาน">ยังไม่เริ่มงาน</a></th>
							<th colspan="2">(<?=$rsno_job?>)</th>
						</tr>
						<tr>
							<th><a href="#" class="full_job"
								data-m_id="<?=$_POST['m_id']?>"
								data-date_1 ="<?=$_POST['date_1']?>"
								data-date_2 ="<?=$_POST['date_2']?>"
								data-z_id = "<?=$_POST['z_id']?>"
								data-c_id = "<?=$_POST['c_id']?>"
								data-action = "ปิดงานแล้ว" 
								>ปิดงานแล้ว</a></th>
								<th colspan="2">(<?=$rs['end_job']?>)</th>

							</tr>
							<tr>
								<th><a href="" class="full_job"
									data-m_id="<?=$_POST['m_id']?>"
									data-date_1 ="<?=$_POST['date_1']?>"
									data-date_2 ="<?=$_POST['date_2']?>"
									data-z_id = "<?=$_POST['z_id']?>"
									data-c_id = "<?=$_POST['c_id']?>"
									data-action = "คืนงาน" 
									>คืนงาน</a></th>
									<th colspan="2">(<?=$transfer; ?>)</th>
								</tr>
								<tr>
									<th><a href="" class="full_job"
										data-m_id="<?=$_POST['m_id']?>"
										data-date_1 ="<?=$_POST['date_1']?>"
										data-date_2 ="<?=$_POST['date_2']?>"
										data-z_id = "<?=$_POST['z_id']?>"
										data-c_id = "<?=$_POST['c_id']?>"
										data-action = "pending"> งานคงค้าง</a></th>
										<th colspan="2">(<?=$rs0['panding']?>)</th>
									</tr>
									<tr>
										<th><a href="" class="full_job"
											data-m_id="<?=$_POST['m_id']?>"
											data-date_1 ="<?=$_POST['date_1']?>"
											data-date_2 ="<?=$_POST['date_2']?>"
											data-z_id = "<?=$_POST['z_id']?>"
											data-c_id = "<?=$_POST['c_id']?>"
											data-action = "sla">ตก SLA</a></th>
											<th colspan="2">(<?=$sla?>)</th>
										</tr>
										<tr>
											<th>รวมทั้งหมด</th>
											<th colspan="2">(<?=$x;?>)</th>
										</tr>
									</tbody>
								</table>
							</div>		

						<?php  }else{ 

							$sql = mysqli_query($conn,"SELECT *,b.m_name as m_name,a.ws_id as ws_id, count(a.ws_id)as sum_ws_id,year(a.ws_date)as year FROM worksheet a 
								LEFT JOIN member b 
								on a.m_id = b.m_id
								INNER JOIN division d 
								on a.dv_id = d.dv_id
								LEFT JOIN zone e 
								on a.z_id = e.z_id 
								WHERE a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') and a.m_id = '".$_POST['m_id']."'
								ORDER BY a.ws_id DESC");   
								$rs0 = mysqli_fetch_assoc($sql); ?>
								<div class="tile"><hr>
								<table class="table table-bordered table-inverse text-center">
								<thead>
								<tr>
								<th><?=$rs0['m_name']?> : <?=$rs0['dv_name']." (".$rs0['dv_name_short'].")";?></th>	
								<th>ปี : <?=$rs0['year']?></th>
								</tr>
								<tr>
								<th>ประเภท : ทั้งหมด</th>
								<th>โซน : <?=$rs0['z_name']?></th>
								</tr>
								<tr>
								<th>รวมทั้งหมด</th>
								<th><?='('.$rs0['sum_ws_id'].')'?></th>
								</tr>
								</thead>
								</table>
								</div>



								<?php } ?>
								<script type="text/javascript">
								$('.full_job').click(function(event) {
									event.preventDefault();
									var m_id = $(this).data("m_id");
									var date_1 = $(this).data("date_1");
									var date_2 = $(this).data("date_2");
									var z_id = $(this).data("z_id");
									var c_id = $(this).data("c_id");
									var action = $(this).data("action");
									$.ajax({
										url: 'data_report.php',
										type: 'POST',
										data: {'m_id':m_id,'date_1':date_1 ,'date_2':date_2 , 'z_id' : z_id,'c_id': c_id,'action': action },
										success: function(data){
											$('.data_full_job').html(data);
										}
										})
										});
										</script>