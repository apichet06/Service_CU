<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once '../db/title.php' ?>
  <title><?=$title?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?=$icon;?>" type="image/x-icon">
  <?php require_once '../link_css/link_css.php'; ?>
</head>
<body >
 <div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <?php $date = date("Y-m-d");
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
       LEFT JOIN transfer_job i 
       on b.ws_id = i.ws_id 
       where  b.ws_id = '".$_GET['id']."'
       ORDER BY b.ws_id asc")or die(mysqli_error($conn));
      $i=1;
      while($rs = mysqli_fetch_assoc($sql)){ 

        if(strtotime($rs['ws_assess_date']) >= strtotime(date('Y-m-d')) or $rs['ws_assess_date'] ==''){ ?>  
          <div class="col-md-12 p-1">
            <!--//////////-->
            <div class="row justify-content-end">
              <div class="col-md-9">
                <!-- <strong class="text-danger">*** รายการจะหายไปหลังจากทำการประเมินแล้ว 1 วัน ***</strong> -->
              </div>
              <div class="col-md-3">
                <strong>เลขที่ใบงาน <i class="fa fa-angle-double-right"></i> <?=$rs['ws_number_id']; ?></strong>
              </div>
            </div><hr>

            <div class="row justify-content-start">
              <div class="col-md-5">
                <h5>ชื่อใบงาน : <?=$rs['ws_name'];?></h5> 
              </div>
              <div class="col-md-6">
                <h5> แผนก : <?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></h5>
              </div>
            </div><hr>
            <div class="row justify-content-start">
              <div class="col-md-5">
                <strong>(Zone)เขตพื้นที่ : </strong> <?=$rs['z_name']=="" ? " -" : $rs['z_name'];?>
              </div>
              <div class="col-md-6">
                <strong> สถานที่ : </strong><?=$rs['place_name']=="" ? " -" : $rs['place_name'];?>
              </div>
            </div><hr>
            <div class="row justify-content-around">
              <div class="col-md-4">
                <strong>ผู้สร้างใบงาน :</strong> <?=$rs['m_sender']?>
              </div>
              <div class="col-md-3">
               <strong>ประเภทงาน : </strong><?=$rs['c_name'];?>
             </div>
             <div class="col-md-5">
               <strong>ช่างดำเนินการ : </strong><?=$rs['m_name']=="" ? "<strong class='text-danger'>คืนงาน</strong>" : $rs['m_name'];?>
             </div>
           </div><hr>
           <div class="row justify-content-around">
            <div class="col-md-3">
              <strong> กำหนดเริ่มงาน : </strong> <?=$rs['ws_start_date'];?>
            </div>
            <div class="col-md-3">
              <strong>กำหนดงานเสร็จ : </strong><?=$rs['ws_end_date'];?>
            </div>
            <div class="col-md-3">
              <strong>ช่างเริ่มงาน : </strong><?=$rs['ws_job_start'] =="" ? "-" : $rs['ws_job_start'];?>
            </div>
            <div class="col-md-3">
             <strong>ช่างปิดงาน : </strong><?=$rs['ws_job_end']=="" ? "-" : $rs['ws_job_end'];?>
           </div>
         </div><hr>
         <div class="row justify-content-around">
          <div class="col-md-11">
            <strong>สิ่งที่ขอให้ดำเนินการ : </strong><?=$rs['ws_request']=="" ? "-" : $rs['ws_request'];?>
          </div>
        </div><hr>
        <div class="row justify-content-around">
          <div class="col-md-11">
            <strong>รายละเอียดงานคงค้าง : </strong><?=$rs['panding_note']=="" ? "-" : $rs['panding_note'];?>
          </div>
        </div><hr>
        <div class="row justify-content-around">
          <div class="col-md-11">
            <strong>เหตุผลที่คืนงาน : </strong><?=$rs['t_reason']=="" ? "-" : $rs['t_reason'];?>
          </div>
        </div><hr>
        <div class="row justify-content-around">
          <div class="col-md-11">
            <strong>รายละเอียดการปิดงาน : </strong><?=$rs['ws_jobdescription']=="" ? "-" : $rs['ws_jobdescription'];?>
          </div>
        </div><hr>
        <style type="text/css">
          .card-img-top{
            height: 9rem;
            /*object-fit: cover;*/
          }
        </style>
        <div class="row">
          <?php 
          $sql0 = mysqli_query($conn,"SELECT * FROM  image_work WHERE ws_id = '".$rs['ws_id']."' ");
          while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>

           <div class="col-md-2 p-2">
            <a href="../../xservice_site2/<?=$rs0['img_name'];?>" 
              data-toggle="img" 
              class="img01"
              data-gallery="<?=$rs0['ws_id'];?>">
              <img src="../../xservice_site2/<?=$rs0['img_name'];?>" class="img-thumbnail card-img-top img-fluid ">
            </a>
          </div>
        <?php } ?>
        <!--data-max-height="auto"-->
      </div><hr>  

      <!---วางรูปภาพ---->
      <?php if ($rs['ws_assess_status'] != "ไม่ผ่าน" and $rs['ws_assess_status']!="") { ?> 
       <div class="row justify-content-end">
        <div class="col-md-2">
          <strong class="text-success">สถานะ : <?=$rs['ws_assess_status']?> <i class="fa fa fa-check fa-lg"></i></strong>
        </div>
      </div>
    <?php }else if($rs['ws_assess_status'] != "ผ่าน" and $rs['ws_assess_status']!=""){ ?>

      <div class="row">
        <div class="col-md-10">
          <strong class="text-danger">เหตุผลที่ไม่ผ่าน :  <?=$rs['ws_assess']?></strong>
        </div>
        <div class="col-md-2">
          <strong class="text-danger">สถานะ : <?=$rs['ws_assess_status']?> <i class="fa fa-times fa-lg"></i></strong>
        </div>
      </div>

    <?php } ?>

    <div class="modal-footer">
      <a href="print.php?id=<?=$_GET['id']?>" target="_black" class="btn btn-info">พิมพ์</a>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>

    <!--//////////-->

  </div>

<?php } } ?>
</div>
</div>
</div>


<script type="text/javascript">
  $('.img01').click(function (e) {
    e.preventDefault();
    $(this).ekkoLightbox();
  });
</script>
</body>
</html>

