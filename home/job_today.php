<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once '../db/title.php'; ?>
  <title><?=$title?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?=$icon;?>" type="image/x-icon">
  <?php require_once '../link_css/link_css.php'; ?>
  <style type="text/css" media="screen">
    table { font-size: 12px }
  </style>
</head>
<body class="app sidebar-mini">
  <?php require_once '../menu/menu.php'; require_once '../menu/datetime_function.php';?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-home" ></i> Job Today </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>

    <?php if($_GET['ws_start_date']){ ?>
      <div class="row">
       <div class="col-md-12">
        <div class="tile">

          <div class="row">
            <div class="col-md-10">
              <h4>งานที่ต้องทำวันนี้</h4>
            </div>
            <div class="col-md-2">
             <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
           </div>
         </div>
         <hr>
         <table class="table table-striped table-sm example">
          <thead class="align-middle text-nowrap">
            <tr>
              <th>#</th>
              <th>ชื่อใบงาน</th>
              <th>ประเภท</th>
              <th>สถานที่</th>
              <th>มอบหมายงาน</th>
              <th>รับงาน</th>
              <th>แผนก</th>
              <th class="text-center">สถานะ</th>
              <th>เวลาเริ่มงาน</th>
              <th>สถานะ SLA</th>
            </tr>
          </thead>
          <tbody class="text-nowrap align-middle thead-dark">
            <?php $date = date("Y-m-d");
            $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
              INNER JOIN category b 
              on a.c_id = b.c_id 
              LEFT JOIN place c 
              on c.place_id = a.place_id
              INNER JOIN member d 
              on a.m_id = d.m_id
              INNER JOIN member e 
              on a.ws_sender = e.m_id 
              INNER JOIN division f 
              on a.dv_id = f.dv_id
              WHERE date(a.ws_start_date) = '".$_GET['ws_start_date']."'
              ORDER BY a.m_id asc"); 
            $i=1;
            while($rs = mysqli_fetch_assoc($sql)){ 
              $sender = explode(" ",$rs['sender']);
              if(strtotime(date($rs['ws_end_date'])) <= strtotime(date("Y-m-d H:i:s")) ){
                   $date10 = DateDiff_Before_timeout($rs['ws_end_date'],date("Y-m-d H:i:s"));
                 }else{
                   $date10 = DateDiff_Over_time(date("Y-m-d H:i:s"),$rs['ws_end_date']);
                 }

              ?> 
              <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
                <td><?=$i++;?></td>
                <td><?=$rs['ws_name']?></td>
                <td><?=$rs['c_name']?></td>
                <td><?=$rs['place_name']=="" ? "-" : $rs['place_name'];?></td>
                <td>K. <?=$sender[0];?></td>
                <td><?=$rs['m_name'] == "" ? "<strong class='text-danger'>ช่างคืนงาน</strong>" : "K.".$rs['m_name'];?></td>
                <td><?=$rs['dv_name_short']?></td>
                <td class="text-center">
                  <?=$rs['ws_job_start'] =="" ? "<i class='fa fa-ban fa-lg text-danger'></i>" : 
                  "<i class='fa fa-play-circle fa-lg text-success'>";?>
                </td>
                <td><?=$rs['ws_job_start']=="" ? "<strong class='center'>-</strong>" : $rs['ws_job_start']; ?></td>
                <td class="text-nowrap align-middle"> <?php  if($rs['ws_id'] === $rs['g_ws_id']){
               echo "<i class='fa fa-exchange'> :</i> คืนงาน";
             }else{

               if($rs['ws_job_end']) { 
                 if (strtotime($rs['ws_job_end']) > strtotime($rs['ws_end_date']) and strtotime($rs['ws_end_date']) != strtotime('0000-00-00 00:00:00')) {
                   echo DateDiff_Before_timeout($rs['ws_end_date'],$rs['ws_job_end']);  ;
                 }else{
                  echo "ผ่าน SLA";
                }
              }else if(strtotime($rs['ws_end_date']) != strtotime('0000-00-00 00:00:00') and $rs['ws_end_date'] != ''){
               echo $date10;
             }else{
              echo  "ไม่มีกำหนดปิดงาน";
            }  

          }

          ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php }else if($_GET['ws_job_start']){ ?>

  <div class="row">
   <div class="col-md-12">
    <div class="tile">

      <div class="row">
        <div class="col-md-10">
         <h4>ช่างเริ่มงานวันนี้</h4>
       </div>
       <div class="col-md-2">
         <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
       </div>
     </div>
     <hr>
     <table class="table table-striped table-sm table-responsive example">
      <thead class="align-middle text-nowrap">
        <tr>
          <th >#</th>
          <th >ชื่อช่าง</th>
          <th >ใบงาน</th>
          <th >สถานที่ปฏิบัติงาน</th>
          <th >แผนก</th>
          <th >กำหนดเริ่มงาน</th>
          <th >กำหนดปิดงาน</th>
          <th >วันที่เริ่มงาน</th>
          <th >วันที่ปิดงาน</th>
          <th class="text-center">สถานะ</th>
        </tr>
      </thead>
      <tbody class="text-nowrap align-middle thead-dark">
        <?php $date = date("Y-m-d");
        $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
          INNER JOIN category b 
          on a.c_id = b.c_id 
          LEFT JOIN place c 
          on c.place_id = a.place_id
          INNER JOIN member d 
          on a.m_id = d.m_id
          INNER JOIN member e 
          on a.ws_sender = e.m_id 
          INNER JOIN division f 
          on a.dv_id = f.dv_id
          WHERE date(a.ws_job_start) = '".$_GET['ws_job_start']."'
          ORDER BY a.m_id asc"); 
        $i=1;
        while($rs = mysqli_fetch_assoc($sql)){ 
          $sender = explode(" ",$rs['sender'])
          ?> 
          <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
            <td><?=$i++?></td>
            <td><?=$rs['m_name']?></td>
            <td><?=$rs['ws_name']?></td>
            <td><?=$rs['place_name']=="" ? "-" : $rs['place_name'];?></td>
            <td><?=$rs['dv_name_short']?></td>
            <td><?=$rs['ws_start_date']?></td>
            <td><?=$rs['ws_end_date']?></td>
            <td><?=$rs['ws_job_start']?></td>
            <td ><?=$rs['ws_job_end']=="" ? '-' : $rs['ws_job_end']; ?></td>
            <td class="text-nowrap align-middle text-center">
              <?php if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == '' ){
                echo $rs['panding_note'] =='' ? '<i class="fa fa-play-circle fa-lg text-success"></i>'
                : '<i class="fa fa-spinner fa-lg text-info fa-spin"></i>';
              }else{
                echo '<i class="fa fa-lg fa-step-forward"></i>';
              } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php }else if($_GET['ws_job_end']){ ?>

  <div class="row">
   <div class="col-md-12">
    <div class="tile">

      <div class="row">
        <div class="col-md-10"> <h4>ช่างปิดงานวันนี้</h4></div>
        <div class="col-md-2">
         <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
       </div>
     </div>
     <hr>
     <table class="table table-striped table-sm example table-responsive">
      <thead class="align-middle text-nowrap">
        <tr>
          <th >#</th>
          <th >ชื่อช่าง</th>
          <th >ใบงาน</th>
          <th >สถานที่ปฏิบัติงาน</th>
          <th >แผนก</th>
          <th >กำหนดเริ่มงาน</th>
          <th >กำหนดปิดงาน</th>
          <th >วันที่เริ่มงาน</th>
          <th >วันที่ปิดงาน</th>
          <th class="text-center">สถานะ</th>
        </tr>
      </thead>
      <tbody class="text-nowrap align-middle thead-dark">
        <?php $date = date("Y-m-d");
        $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
          INNER JOIN category b 
          on a.c_id = b.c_id 
          LEFT JOIN place c 
          on c.place_id = a.place_id
          INNER JOIN member d 
          on a.m_id = d.m_id
          INNER JOIN member e 
          on a.ws_sender = e.m_id 
          INNER JOIN division f 
          on a.dv_id = f.dv_id
          WHERE date(a.ws_job_end) = '".$_GET['ws_job_end']."'
          ORDER BY a.m_id asc"); 
        $i=1;
        while($rs = mysqli_fetch_assoc($sql)){ 
          $sender = explode(" ",$rs['sender'])
          ?> 
          <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
            <td><?=$i++?></td>
            <td><?=$rs['m_name']?></td>
            <td><?=$rs['ws_name']?></td>
            <td><?=$rs['place_name']=="" ? "-" : $rs['place_name'];?></td>
            <td><?=$rs['dv_name_short']?></td>
            <td><?=$rs['ws_start_date']?></td>
            <td><?=$rs['ws_end_date']?></td>
            <td><?=$rs['ws_job_start']?></td>
            <td ><?=$rs['ws_job_end']=="" ? '-' : $rs['ws_job_end']; ?></td>
            <td class="text-nowrap align-middle text-center">
              <?php if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == '' ){
                echo $rs['panding_note'] =='' ? '<i class="fa fa-play-circle fa-lg text-success"></i>'
                : '<i class="fa fa-spinner fa-lg text-info fa-spin"></i>';
              }else{
                echo '<i class="fa fa-lg fa-step-forward"></i>';
              } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php }else if($_GET['t_date']){ ?>

  <div class="row">
   <div class="col-md-12">
    <div class="tile">
      <div class="row">
        <div class="col-md-10">
          <h4>รายงานช่างคืนงานกลับ</h4>
        </div>
        <div class="col-md-2">
         <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
       </div>
     </div>
     <hr>
     <table class="table table-inverse table-striped table-responsive table-sm example">
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
          <th>เหตุผลที่คืนงาน</th>
          <th>วันที่คืนงาน</th>
        </tr>
      </thead>
      <tbody class="text-nowrap align-middle">

        <?php $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl
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
         Where date(a.t_date) = '".$_GET['t_date']."'  
         ORDER BY a.t_id DESC")or die(mysqli_error($conn));
        $i=1;
        while($rs = mysqli_fetch_assoc($sql)){ ?>  
         <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
           <td><?=$i;?></td>
           <td><?=$rs['ws_number_id']?></td>
           <td><?=$rs['ws_name'];?></td>
           <td><?=$rs['z_name'];?></td>
           <td><?=$rs['place_name']=="" ? "-" : $rs['place_name'];?></td>
           <td><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></td> 
           <td><?=$rs['c_name'];?></td>
           <td><?=$rs['m_sender']?></td>
           <td><?=$rs['m_name']?></td>
           <td><?=$rs['t_reason']?></td>
           <td><?=$rs['t_date'];?></td>
         </tr>
         <?php $i++;} ?>
       </tbody>
     </table>
   </div>
 </div>
</div>

<?php }else if($_GET['panding']){ ?>

  <div class="row">
   <div class="col-md-12">
    <div class="tile">
      <div class="row">
        <div class="col-md-10">
          <h4>งานคงค้างทั้งหมด</h4>
        </div>
        <div class="col-md-2">
         <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
       </div>
     </div>
     <hr>
     <table class="table table-inverse table-striped table-responsive table-sm example">
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
          <th>เหตุผลงานคงค้าง</th>
        </tr>
      </thead>
      <tbody class="text-nowrap align-middle">

        <?php $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name FROM  worksheet a
          INNER JOIN zone b 
          on a.z_id = b.z_id
          LEFT JOIN place c 
          on a.place_id = c.place_id
          INNER JOIN division d 
          on a.dv_id = d.dv_id 
          INNER JOIN category e 
          on a.c_id = e.c_id
          INNER JOIN member f 
          on a.ws_sender = f.m_id
          INNER JOIN member g 
          on a.m_id = g.m_id 
          Where a.panding_note !='' and ISNULL(a.ws_job_end)
          ORDER BY a.ws_id DESC")or die(mysqli_error($conn));
        $i=1;
        while($rs = mysqli_fetch_assoc($sql)){ ?>  
         <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
           <td><?=$i;?></td>
           <td><?=$rs['ws_number_id']?></td>
           <td><?=$rs['ws_name'];?></td>
           <td><?=$rs['z_name'];?></td>
           <td><?=$rs['place_name']=="" ? "-" : $rs['place_name'];?></td>
           <td><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></td> 
           <td><?=$rs['c_name'];?></td>
           <td><?=$rs['m_sender']?></td>
           <td><?=$rs['m_name']?></td>
           <td><?=$rs['panding_note']?></td>
         </tr>
         <?php $i++;} ?>
       </tbody>
     </table>
   </div>
 </div>
</div>
<?php }else if($_GET['backlog']){ ?>
  <div class="row">
   <div class="col-md-12">
    <div class="tile">
      <div class="row">
        <div class="col-md-10">
          <h4>งานตก SLA/ไม่กดเริ่มงาน</h4>
        </div>
        <div class="col-md-2">
         <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
       </div>
     </div>
     <hr>
     <table class="table  table-bordered table-sm example">
      <thead  class="align-middle text-nowrap">
        <tr>
          <th>No.</th>
          <th>ชื่อช่าง</th>
          <th>ชื่อใบงาน</th>
          <th>กำหนดเสร็จ</th>
          <th>เวลาที่เหลือ</th>
        </tr>
      </thead>
      <tbody  class="align-middle text-nowrap">
        <?php 
         //date ("Y-m-d H:i:s", strtotime("+2 hours", strtotime(date('Y-m-d H:i:s'))));
         //$strNewDate = date ("Y-m-d H:i:s", strtotime("+2 day", strtotime(date('Y-m-d H:i:s'))));
        $date = date("Y-m-d H:i:s");
        $sql = mysqli_query($conn,"SELECT * FROM worksheet a 
          INNER JOIN member b 
          on a.m_id = b.m_id
          INNER JOIN division c 
          on a.dv_id = c.dv_id
          LEFT JOIN place e 
          on a.place_id = e.place_id
          WHERE  a.ws_end_date <= '$date' and ISNULL(a.ws_job_end) and a.ws_end_date !='0000-00-00 00:00:00'  
          ORDER BY a.ws_end_date asc                     
          ")or die(mysqli_error($conn)); 
        $i=1;

        while ($rs = mysqli_fetch_assoc($sql)) { 
          $date0 = strtotime($rs['ws_end_date']);
          $name  = explode(' ',$rs['m_name']);

          if(strtotime(date($rs['ws_end_date'])) <= strtotime(date("Y-m-d H:i:s")) ){
           $date = DateDiff_Before_timeout($rs['ws_end_date'],date("Y-m-d H:i:s"));
         }else{
           $date = DateDiff_Over_time(date("Y-m-d H:i:s"),$rs['ws_end_date']);
         }

         ?>

         <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">

          <td><?=$i;?></td>
          <td><?="(".$rs['dv_name_short'].") ".$name[0];?></td>
          <td><?=$rs['ws_name']?></td>
          <td><?=$rs['ws_end_date'];?></td>
          <td><?=$date;?></td>
        </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<?php }else if($_GET['accept_work']){ ?>
      <div class="row">
       <div class="col-md-12">
        <div class="tile">

          <div class="row">
            <div class="col-md-10">
              <h4>รายการที่รับงานแล้ววันนี้</h4>
            </div>
            <div class="col-md-2">
             <a href="index.php">ย้อนกลับ <i class="fa fa-reply-all fa-lg"></i></a>
           </div>
         </div>
         <hr>
         <table class="table table-striped table-sm example">
          <thead class="align-middle text-nowrap">
            <tr>
              <th>#</th>
              <th>ชื่อใบงาน</th>
              <th>ประเภท</th>
              <th>สถานที่</th>
              <th>มอบหมายงาน</th>
              <th>รับงาน</th>
              <th>แผนก</th>
              <th class="text-center">สถานะ</th>
              <th>เวลารับงาน</th>
            </tr>
          </thead>
          <tbody class="text-nowrap align-middle thead-dark">
            <?php $date = date("Y-m-d");
            $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
              INNER JOIN category b 
              on a.c_id = b.c_id 
              LEFT JOIN place c 
              on c.place_id = a.place_id
              INNER JOIN member d 
              on a.m_id = d.m_id
              INNER JOIN member e 
              on a.ws_sender = e.m_id 
              INNER JOIN division f 
              on a.dv_id = f.dv_id
              WHERE date(a.accept_work) = '".$_GET['accept_work']."'
              ORDER BY a.m_id asc"); 
            $i=1;
            while($rs = mysqli_fetch_assoc($sql)){ 
              $sender = explode(" ",$rs['sender'])
              ?> 
              <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
                <td><?=$i++;?></td>
                <td><?=$rs['ws_name']?></td>
                <td><?=$rs['c_name']?></td>
                <td><?=$rs['place_name']=="" ? "-" : $rs['place_name'];?></td>
                <td>K. <?=$sender[0];?></td>
                <td><?=$rs['m_name'] == "" ? "<strong class='text-danger'>ช่างคืนงาน</strong>" : "K.".$rs['m_name'];?></td>
                <td><?=$rs['dv_name_short']?></td>
                <td class="text-center">
                  <?=$rs['accept_work'] =="" ? "<i class='fa fa-ban fa-lg text-danger'></i>" : 
                  "<i class='fa fa-check fa-lg text-success'>";?>
                </td>
                <td><?=$rs['accept_work']=="" ? "<strong class='center'>-</strong>" : $rs['accept_work']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php } ?>

</main>
<?php  require_once '../link_js/link_js.php'; ?>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.colVis.min.js"></script> -->
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('.example').DataTable( {
      lengthChange: true,
      /*buttons: ['excel' ,'print', 'colvis' ],*/
      // buttons: [
      // { extend: 'excel', className: 'btn-sm btn-warning' },
      /*{ extend: 'print', className: 'btn-sm btn-info' },*/
      // { extend: 'colvis', className: 'btn-sm btn-secondary' }
      // ],
      "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
      "drawCallback": function () {
        $('.dataTables_paginate > .pagination').addClass('pagination-sm');

      }
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0) ' );
  });
</script>
</body>
</html>