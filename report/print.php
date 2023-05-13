<!DOCTYPE html>
<html>
<head>
	<?php session_start(); 
	require_once '../db/config.php';
	require_once '../db/title.php' ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=$title?></title>
	<link rel="shortcut icon" href="<?=$icon;?>" type="image/x-icon">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../font/stylesheet.css">
</head>
<body onload="window.onafterprint = function() {  window.close();}; window.print();">
	<?php 
	$sql = mysqli_query($conn,"SELECT *,b.ws_id,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl
		FROM  worksheet b 
		LEFT JOIN zone c 
		on b.z_id = c.z_id 
		LEFT JOIN place d 
		on d.place_id = b.place_id 
		LEFT JOIN  division e 
		on e.dv_id = b.dv_id
		LEFT JOIN member f 
		on f.m_id = b.ws_sender
		LEFT JOIN member g 
		on g.m_id = b.m_id
		LEFT JOIN category h
		on h.c_id = b.c_id
		LEFT JOIN position i
		on g.p_id = i.p_id
		LEFT JOIN transfer_job j 
		on b.ws_id = j.ws_id
		LEFT JOIN pending k 
		on k.pd_id = b.panding_status
		where  b.ws_id = '".$_GET['id']."'
		ORDER BY b.ws_id asc")or die(mysqli_error($conn));
		$rs = mysqli_fetch_assoc($sql); ?>
		<table class="table table-bordered">
			<thead class="text-nowrap align-middle">
				<tr>
					<th width="200" rowspan="3"><img src="<?=$icon;?>" width="120" ></th>
					<th class="align-middle text-center"  width="70%" rowspan="3"><h3>ใบงาน</h3></th>
					<th class="text-right">เลขที่ใบงาน :</th>
					<th ><?=$rs['ws_number_id']; ?></th>
				</tr>
				<tr>
					<th class="text-right">แผนก :</th>
					<th><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></th>
				</tr>
				<tr>
					<th class="text-right">วันที่สร้าง :</th>
					<th><?=date_format(date_create($rs['ws_date']),"d/m/Y");?></th>
				</tr>
			</thead>
		</table>

		<?php if(strtotime($rs['ws_assess_date']) >= strtotime(date('Y-m-d')) or $rs['ws_assess_date'] ==''){ ?> 
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="2">ชื่อใบงาน : <?=$rs['ws_name'];?></th>
						<th><strong>ผู้สร้างใบงาน :</strong> <?=$rs['m_sender']?></th>
					</tr>
					<tr>
						<th><strong>(Zone)เขตพื้นที่ : </strong> <?=$rs['z_name']=="" ? " -" : $rs['z_name'];?></th>
						<th> <strong>สถานที่ : </strong><?=$rs['place_name']=="" ? " -" : $rs['place_name'];?></th>
						<th> <strong>ประเภทงาน : </strong><?=$rs['c_name'];?></th>
					</tr>
					<tr>
						<th><strong>กำหนดเริ่มงาน : </strong> <?=$rs['ws_start_date'];?></th>
						<th><strong>กำหนดงานเสร็จ : </strong><?=$rs['ws_end_date'];?></th>
						<th><strong>ช่างเริ่มงาน : </strong><?=$rs['ws_job_start'];?></th>
					</tr>
					<tr>
						<th colspan="3">รายละเอียดงาน : <br> &nbsp; &nbsp; &nbsp; &nbsp; <?=$rs['ws_jobdescription']?></th>
					</tr>
					<?php if($rs['panding_note']){ ?>
						<tr>
							<th colspan="3">รายการงานคงค้าง : <br> &nbsp; &nbsp; &nbsp; &nbsp; <?=$rs['pd_name'];?></th>
						</tr>
						<tr>
							<th colspan="3">รายละเอียดงานคงค้าง : <br> &nbsp; &nbsp; &nbsp; &nbsp; <?=$rs['panding_note'];?></th>
						</tr>
					<?php } if($rs['t_reason']){ ?>
						<tr>
							<th colspan="3">เหตุผลที่คืนงาน : <br> &nbsp; &nbsp; &nbsp; &nbsp; <?=$rs['t_reason'];?></th>
						</tr>
					<?php } ?>

					<tr>
						<th colspan="3">
							<div class="row justify-content-center">
								<?php 
								$sql0 = mysqli_query($conn,"SELECT * FROM  image_work WHERE ws_id = '".$rs['ws_id']."' ");
								while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
									<div class="col-md-4 p-2">          
										<img src="../../xservice_site2/<?=$rs0['img_name'];?>" class="img-thumbnail card-img-top img-fluid ">
									</div>
								<?php } ?>
								<!--data-max-height="auto"-->
							</div>
						</th>
					</tr>
					<tr>
						<th><strong>ช่างดำเนินการ : </strong><?=$rs['m_name']=="" ? "<strong class='text-danger'>คืนงาน</strong>" : $rs['m_name'];?></th>
						<th>ตำแหน่ง : <?=$rs['p_name']?></th>
						<th><strong>เวลาปิดงาน : </strong><?=$rs['ws_job_end'];?></th>
					</tr>
				</thead>

			</table>	

<?php } ?>


<?php require_once '../link_js/link_js.php';   ?>
<script type="text/javascript">
	//setTimeout()
</script>
</body>
</html>