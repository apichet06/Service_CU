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
  <style type="text/css" media="screen">
    table { font-size: 12px }
  </style>
</head>
<body class="app sidebar-mini">
  <?php require_once '../menu/menu.php'; require_once '../menu/datetime_function.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-home" ></i> หน้าหลัก </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>
    <div class="row">
      <?php $date = date("Y-m-d"); 
      $sql = mysqli_query($conn,"SELECT bu.ws_create,ws_js.j_s,ws_en.j_en,ws_acc.acc
        FROM worksheet a 
        LEFT JOIN(select count(ws_start_date)as ws_create ,ws_start_date
        from worksheet where date(ws_start_date) = '$date'  and m_id !=0
        )bu
        ON date(bu.ws_start_date) = '$date'
        LEFT JOIN(select count(a.ws_id)as j_s,a.ws_job_start FROM worksheet a 
        left join member b 
        on a.m_id = b.m_id Where date(a.ws_job_start) = '$date' and a.m_id !=0
        )ws_js 
        ON date(ws_js.ws_job_start) = '$date'
        LEFT JOIN(select count(ws_id)as j_en,ws_job_end from worksheet where date(ws_job_end) ='$date' and m_id !=0
        )ws_en 
        ON date(ws_en.ws_job_end) = '$date'
        LEFT JOIN(select count(ws_id)as acc,accept_work from worksheet where date(accept_work) ='$date' and m_id !=0  
        )ws_acc 
        ON date(ws_acc.accept_work) = '$date'
        "); 
      $rs = mysqli_fetch_assoc($sql);

      $sql = mysqli_query($conn,"SELECT * FROM transfer_job WHERE date(t_date) = '$date' "); 
      $row = mysqli_num_rows($sql); 

      $sql0 = mysqli_query($conn,"SELECT count(panding_note)as panding from worksheet  Where panding_note!='' and ISNULL(ws_job_end)
        ")or die(mysqli_error($conn));
      $rs0 = mysqli_fetch_assoc($sql0);



      //$strNewDate = date ("Y-m-d H:i:s", strtotime("+2 day", strtotime(date('Y-m-d H:i:s'))));
      $date = date("Y-m-d H:i:s");
      $sql0 = mysqli_query($conn,"SELECT * FROM worksheet a 
        INNER JOIN member b 
        on a.m_id = b.m_id
        INNER JOIN division c 
        on a.dv_id = c.dv_id
        LEFT JOIN place e 
        on a.place_id = e.place_id
        WHERE  a.ws_end_date <= '$date' and ISNULL(a.ws_job_end) and a.ws_end_date !='0000-00-00 00:00:00' ");
      $sla = mysqli_num_rows($sql0);
      ?>
      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-address-book fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="job_today.php?ws_start_date=<?=date("Y-m-d")?>">งานวันนี้</a></h4>
            <p><b><?=$rs['ws_create']=="" ? "0" : $rs['ws_create']?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-hourglass-start fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="job_today.php?ws_job_start=<?=date("Y-m-d")?>">เริ่มงานวันนี้</a></h4>
            <p><b><?=$rs['j_s']== "" ? "0" : $rs['j_s'];?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-calendar-check-o fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="job_today.php?ws_job_end=<?=date("Y-m-d")?>">ปิดงานวันนี้</a></h4>
            <p><b><?=$rs['j_en']== "" ? "0" : $rs['j_en'];?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-exchange fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="job_today.php?t_date=<?=date("Y-m-d")?>">คืนงานวันนี้</a></h4>
            <p><b><?=$row;?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 p-1 ">
        <div class="widget-small bg-white coloured-icon"><i class="icon fa fa-check fa-3x"></i>
          <div class="info ">
            <h4 class="text-secondary "><a href="job_today.php?accept_work=<?=date("Y-m-d")?>">รับงานวันนี้</a></h4>
            <p class="text-dark"><b><?=$rs['acc'];?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-clock-o fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="job_today.php?panding=<?=date("Y-m-d")?>">งานคงค้างทั้งหมด</a></h4>
            <p><b><?=$rs0['panding'];?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-exclamation-triangle fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="job_today.php?backlog=1">งานตก SLA</a></h4>
            <p><b><?=$sla;?></b></p>
          </div>
        </div>
      </div>

      <?php $date  =date('Y-m-d');
      $sql01 = mysqli_query($conn,"SELECT * FROM job_in_out WHERE date(date_in_out) = '$date' and action ='In'
        GROUP BY date(date_in_out),m_id ");
      $job_in_out = mysqli_num_rows($sql01);
      ?>

      <div class="col-md-6 col-lg-3 p-1">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-calendar fa-3x"></i>
          <div class="info">
            <h4 class="text-secondary"><a href="../report/work_in_out.php?date=<?=date('Y-m-d')?>">ลงเวลางานวันนี้</a></h4>
            <p><b><?=$job_in_out;?></b></p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 p-1">
        <div class="tile">
         <h5 class="text-center">งานวันนี้ <?php echo $_POST['ws_start_date']=="" ? date('d/m/Y') : $_POST['ws_start_date'];?></h5>
         <form method="post" accept-charset="utf-8"> 
          <div class="row justify-content-center">
            <div class="col-md-3">
              <div class="input-group date" id="datetimepicker11" data-target-input="nearest" >
                <input type="text" name="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker11" placeholder="เวลาเริ่มงาน"  />
                <div class="input-group-append" data-target="#datetimepicker11" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-info ">ค้นหา</button>
            </div> 
          </div>  
        </form>
        <div class="row">
          <div class="col-md-10">
              <!-- <strong class="text-secondary text-center">
                สถานะ -> เริ่มงาน <i class="fa fa-play-circle text-success"></i> :: 
                งานคงค้าง <i class="fa fa-spinner text-info fa-spin"></i> :: ปิดงานแล้ว <i class="fa fa-step-forward"></i></strong>  --> 
              </div>
              <div class="col-md-2 text-right">
               <!-- <a href="" title="" class="popup" 
               data-ps = "mechanic_start_work_today"
               data-target = "#popup"
               data-toggle = "modal"
               data-message= "รายการช่างที่เริ่มงานซ่อมวันนี้"
               ><b>ทั้งหมด</b>
             </a> -->
             <a href="../report/mechanic_work.php"><b>ทั้งหมด</b></a>
           </div>
         </div>  
         <hr>
         <div class="row">
          <div class="col-md-12 ">
            <table class="table  table-sm table-responsive" id="example">
              <thead class="text-nowrap align-middle">
                <tr>
                  <th>No.</th>
                  <th>เลขที่ใบงาน</th>
                  <th>ชื่อใบงาน</th>
                  <!-- <th>------ สิ่งที่ให้ดำเนินการ ------</th> -->
                  <th>(Zone)เขตพื้นที่</th>
                  <th>---- ประเภท ----</th>
                  <th>สถานที่ปฏิบัติงาน</th>
                  <th>แผนก</th>
                  <th>ผู้มอบหมายงาน</th> 
                  <th>ชื่อช่าง</th>
                  <th>กำหนดเริ่มงาน</th>
                  <th>กำหนดปิดงาน</th>
                  <th>วันที่รับงาน</th>
                  <th>วันที่เริ่มงาน</th>
                  <th>วันที่ปิดงาน</th>
                  <th>---- รายละเอียดงาน ----</th>
                  <th>เหตผลที่คืนงาน</th>
                  <th>เวลาคืนงาน</th>
                  <th>สถานะ</th>
                  <th>สถานะ SLA</th>
                </tr>
              </thead>
              <tbody class=" align-middle"> 
                <?php $date = date("Y-m-d");
                if($_POST['ws_start_date']){
                 $sql = mysqli_query($conn,"SELECT *,b.m_name as m_name,f.m_name as sender,g.ws_id as g_ws_id,a.ws_id as ws_id FROM worksheet a 
                  LEFT JOIN member b 
                  on a.m_id = b.m_id
                  LEFT JOIN place c 
                  on a.place_id = c.place_id
                  INNER JOIN division d 
                  on a.dv_id = d.dv_id
                  LEFT JOIN zone e 
                  on a.z_id = e.z_id 
                  LEFT JOIN member f 
                  on f.m_id = a.ws_sender
                  LEFT JOIN transfer_job g 
                  on a.ws_id = g.ws_id
                  LEFT JOIN  transfer_job h 
                  on  a.ws_id = h.ws_id
                  LEFT JOIN category i 
                  on i.c_id = a.c_id
                  Where a.ws_start_date like '%".$_POST['ws_start_date']."%'  
                  ORDER BY a.ws_id DESC ");
               }else{
                 $sql = mysqli_query($conn,"SELECT *,b.m_name as m_name,f.m_name as sender,g.ws_id as g_ws_id,a.ws_id as ws_id FROM worksheet a 
                  LEFT JOIN member b 
                  on a.m_id = b.m_id
                  LEFT JOIN place c 
                  on a.place_id = c.place_id
                  INNER JOIN division d 
                  on a.dv_id = d.dv_id
                  LEFT JOIN zone e 
                  on a.z_id = e.z_id 
                  LEFT JOIN member f 
                  on f.m_id = a.ws_sender
                  LEFT JOIN transfer_job g 
                  on a.ws_id = g.ws_id
                  LEFT JOIN  transfer_job h 
                  on  a.ws_id = h.ws_id
                  LEFT JOIN category i 
                  on i.c_id = a.c_id
                  Where date(a.ws_start_date) = '$date'  
                  ORDER BY a.ws_id DESC ");
               }
               

               $i=1;
               while ($rs = mysqli_fetch_assoc($sql)) {
                if(strtotime(date($rs['ws_end_date'])) <= strtotime(date("Y-m-d H:i:s")) ){
                 $date = DateDiff_Before_timeout($rs['ws_end_date'],date("Y-m-d H:i:s"));
               }else{
                 $date = DateDiff_Over_time(date("Y-m-d H:i:s"),$rs['ws_end_date']);
               }

               if($rs['ws_id'] === $rs['g_ws_id']){
                $table = 'bg-danger text-white';
              }else{

               if($rs['accept_work'] !="" and $rs['accept_work'] !="0000-00-00 00:00:00" and $rs['ws_job_start'] ==''){
                 $table = 'bg-secondary text-white';
               }else if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == '' ){
                $table = $rs['panding_note'] =='' ? "bg-info text-white" : "bg-warning";
              }elseif($rs['ws_job_start'] == ''){
                $table = 'table-light';
              }elseif($rs['ws_job_start']!= '' and $rs['ws_job_end'] != ''){
                $table = 'bg-primary text-white';
              }
            }


            ?> 
            <tr class="<?=$table;?>" onclick="window.location.href ='job_description.php?id=<?=$rs['ws_id']?>'">
              <td class="text-nowrap align-middle"><?=$i;?></td>
              <td class="text-nowrap align-middle"><?=$rs['ws_number_id']?></td>
              <td class="text-nowrap align-middle"><?=$rs['ws_name']?></td>
              <!-- <td ><?=$rs['ws_request']?></td> -->
              <td class="text-nowrap align-middle text-center"><?=$rs['z_name']=="" ? "-" : $rs['z_name']; ?></td>
              <td class="text-nowrap align-middle text-center"><?=$rs['c_name']?></td>
              <td class="text-nowrap align-middle text-center"><?=$rs['place_name']=="" ? " -" : $rs['place_name']?></td>
              <td class="text-nowrap align-middle"><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></td>
              <td class="text-nowrap align-middle"><?=$rs['sender']?></td>
              <td class="text-nowrap align-middle"><?=$rs['m_name']=="" ? "<strong class='text-danger'>คืนงาน</strong>" : $rs['m_name'];?></td>
              <td class="text-nowrap align-middle"><?=$rs['ws_start_date']?></td>
              <td class="text-nowrap align-middle"><?=$rs['ws_end_date']?></td>
              <td class="text-nowrap align-middle"><?=$rs['accept_work']?></td>
              <td class="text-nowrap align-middle"><?=$rs['ws_job_start']?></td>
              <td class="text-nowrap align-middle"><?=$rs['ws_job_end']?></td>
              <td ><?=$rs['ws_jobdescription']=="" ? "-" :  $rs['ws_jobdescription']?></td>
              <td class="text-nowrap align-middle"><?=$rs['t_reason']=="" ? "-" : $rs['t_reason']?></td>
              <td class="text-nowrap align-middle"><?=$rs['t_date']=="" ? "-" : $rs['t_date']?></td>
              <td class="text-nowrap align-middle">
                <?php 
                if($rs['ws_id'] === $rs['g_ws_id']){

                  echo "<i class='fa fa-exchange'> </i> คืนงาน";

                }else{

                  if($rs['accept_work'] =="" and $rs['accept_work'] !="0000-00-00 00:00:00"){
                    echo "<i class='fa fa-exclamation-triangle text-warning'> ยังไม่รับงาน</i> ";
                  }else if($rs['accept_work'] !="" and $rs['accept_work'] !="0000-00-00 00:00:00"){

                   if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == ''){
                    echo ($rs['panding_note'] =='' ? "<i class='fa fa-play-circle text-white'></i> &nbsp; เริ่มงานแล้ว " : "<i class='fa fa-spinner fa-spin'></i> งานคงค้าง");
                  }elseif($rs['ws_job_start'] == ''){
                    echo "<i class='fa fa-check'> รับงาน</a>/<i class='fa fa-ban'> ยังไม่เริ่มงาน</i>";
                  }elseif($rs['ws_job_start']!= '' and $rs['ws_job_end'] != '' ){
                    echo "<i class='fa fa-step-forward'></i> &nbsp; &nbsp; ปิดงานแล้ว ";
                  }
                }
              }
              ?>
            </td>
            <td class="text-nowrap align-middle"> <?php  if($rs['ws_id'] === $rs['g_ws_id']){
             echo "<i class='fa fa-exchange'> :</i> คืนงาน";
           }else{

             if($rs['ws_job_end']) { 
               if (strtotime($rs['ws_job_end']) > strtotime($rs['ws_end_date']) and strtotime($rs['ws_end_date']) != strtotime('0000-00-00 00:00:00')) {
                 echo DateDiff_Before_timeout($rs['ws_end_date'],$rs['ws_job_end']);
               }else{
                echo "ผ่าน SLA";
              }
            }else if(strtotime($rs['ws_end_date']) != strtotime(date('0000-00-00 00:00:00')) and $rs['ws_end_date'] != ''){
             echo '<div class="text-white">'.$date.'</div>';
           }else{
            echo  "ไม่มีกำหนดปิดงาน";
          }  

        }
        ?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>
</div>
</div>
</div>




<!-- <span id="datetime" style=" font-size: 16px;"></span>
-->


  <!-- <div class="col-md-4 p-1" >
    <div class="tile" >
      <h5 class="text-center">สถิติงานแต่ละแผนกทั้งหมด</h5>
      <hr>
      <canvas id="myChart" width="400" height="158"></canvas>  
    </div>
  </div> -->


  <?php // $date = date("Y");
  // $sql = mysqli_query($conn,"SELECT cu_cm.count_cm,cu_pm.count_pm,cu_in.count_in,
  //   ws_pm.ws_ass_pm,ws_cm.ws_ass_cm,ws_in.ws_ass_in,
  //   no_pm.no_ass_pm,no_cm.no_ass_cm,no_in.no_ass_in,
  //   cu_pm.pm_tf_job,cu_cm.cm_tf_job,cu_in.in_tf_job
  //   FROM worksheet a 
  //   LEFT JOIN (
  //   SELECT COUNT(a.dv_id)as count_cm,year(a.ws_date)as d_cm,count(b.ws_id)as cm_tf_job
  //   FROM worksheet a
  //   left join transfer_job b
  //   on a.ws_id=b.ws_id
  //   Where year(a.ws_date) = '$date' and a.dv_id = '1'
  //   GROUP BY a.dv_id
  //   )cu_cm
  //   ON cu_cm.d_cm = year(a.ws_date)
  //   LEFT JOIN (
  //   SELECT COUNT(a.dv_id)as count_pm,year(a.ws_date)as d_pm,count(b.ws_id)as pm_tf_job  
  //   FROM worksheet a
  //   left join transfer_job  b 
  //   on a.ws_id = b.ws_id
  //   Where year(a.ws_date) = '$date' and a.dv_id = '2'
  //   GROUP BY a.dv_id
  //   )cu_pm
  //   ON cu_pm.d_pm = year(a.ws_date)
  //   LEFT JOIN (
  //   SELECT COUNT(a.dv_id)as count_in,year(a.ws_date)as d_in,count(b.ws_id)as in_tf_job
  //   FROM worksheet a
  //   left join transfer_job b 
  //   on a.ws_id = b.ws_id
  //   Where year(a.ws_date) = '$date' and a.dv_id = '3'
  //   GROUP BY a.dv_id
  //   )cu_in
  //   ON cu_in.d_in = year(a.ws_date)
  //   LEFT JOIN(select year(ws_date)as sc_in,count(ws_id)as ws_ass_cm from worksheet 
  //   where ws_assess_status = 'ผ่าน' and dv_id = '1'
  //   )ws_cm
  //   ON ws_cm.sc_in = year(a.ws_date)
  //   LEFT JOIN(select year(ws_date)as sc_in,count(ws_id)as ws_ass_pm from worksheet 
  //   where ws_assess_status = 'ผ่าน' and dv_id = '2'
  //   )ws_pm
  //   ON ws_pm.sc_in = year(a.ws_date)
  //   LEFT JOIN(select year(ws_date)as sc_in,count(ws_id)as ws_ass_in from worksheet 
  //   where ws_assess_status = 'ผ่าน' and dv_id = '3'
  //   )ws_in
  //   ON ws_in.sc_in = year(a.ws_date)
  //   LEFT JOIN(select year(ws_date)as sc_in,count(ws_id)as no_ass_cm from worksheet 
  //   where ws_assess_status = 'ไม่ผ่าน' and dv_id = '1'
  //   )no_cm
  //   ON ws_cm.sc_in = year(a.ws_date)
  //   LEFT JOIN(select year(ws_date)as sc_in,count(ws_id)as no_ass_pm from worksheet 
  //   where ws_assess_status = 'ไม่ผ่าน' and dv_id = '2'
  //   )no_pm
  //   ON ws_pm.sc_in = year(a.ws_date)
  //   LEFT JOIN(select year(ws_date)as sc_in,count(ws_id)as no_ass_in from worksheet 
  //   where ws_assess_status = 'ไม่ผ่าน' and dv_id = '3'
  //   )no_in
  //   ON ws_in.sc_in = year(a.ws_date)
  //   ");
  // $sum = mysqli_fetch_assoc($sql);
  ?>

  <!-- <div class="col-md-8 p-1">
    <div class="tile">
      <h5 class="text-center">รายงานสติประจำปี <?=date("Y")-1957;?></h5><hr>
      <table class="table table-bordered table-responsive-sm">
        <thead class="text-nowrap align-middle ">
          <tr>
           <th class="text-secondary">ใบงานประจำปี CM</th>
           <th><?=$sum['count_cm'] == "" ? "0" : $sum['count_cm'];?></th>
           <th class="text-secondary">งานเสร็จสมบูรณ์ CM</th>
           <th><?=$sum['ws_ass_cm'] =="" ? "0" : $sum['ws_ass_cm']; ?></th>
           <th class="text-secondary">งานไม่ผ่าน CM</th>
           <th><?=$sum['no_ass_cm'] == "" ? "0" : $sum['no_ass_cm'];?></th>
           <th class="text-secondary">คืนงานกลับ CM</th>
           <th><?=$sum['cm_tf_job']=="" ? "0" : $sum['cm_tf_job'];?></th>
         </tr>
         <tr>
          <th class="text-secondary">ใบงานประจำปี PM</th>
          <th><?=$sum['count_pm'] == "" ? "0" : $sum['count_pm'];?></th>
          <th class="text-secondary">งานเสร็จสมบูรณ์ PM</th>
          <th><?=$sum['ws_ass_pm'] == "" ? "0" : $sum['ws_ass_pm'];?></th>
          <th class="text-secondary">งานไม่ผ่าน PM</th>
          <th><?=$sum['no_ass_pm'] == "" ? "0" : $sum['no_ass_pm'];?></th>
          <th class="text-secondary">คืนงานกลับ PM</th>
          <th><?=$sum['pm_tf_job']=="" ? "0" : $sum['pm_tf_job']?></th>
        </tr>
        <tr>
         <th class="text-secondary">ใบงานประจำปี IN</th>
         <th><?=$sum['count_in'] =="" ? "0" : $sum['count_in'];?></th>
         <th class="text-secondary">งานเสร็จสมบูรณ์ IN</th>
         <th><?=$sum['ws_ass_in']=="" ? "0" : $sum['ws_ass_in']?></th>
         <th class="text-secondary">งานไม่ผ่าน IN</th>
         <th><?=$sum['no_ass_in'] == "" ? "0" : $sum['no_ass_in'];?></th>
         <th class="text-secondary">คืนงานกลับ IN</th>
         <th><?=$sum['in_tf_job']=="" ? "0" : $sum['in_tf_job']?></th>
       </tr>
     </thead>
   </table>
 </div>
</div> -->
</div>
<?php require_once 'popup.php'; ?>
</main>
<?php require_once '../link_js/link_js.php';  require_once 'charts.php';?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
      lengthChange: true,
      "lengthMenu": [[30, 50, -1], [30, 50, "All"]],
      "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
      "drawCallback": function () {
        $('.dataTables_paginate > .pagination').addClass('pagination-sm');

      }
    });

  });
  $('#datetimepicker11').datetimepicker({  format: 'L', format: 'YYYY-MM-DD'});
</script>
</body>
</html>
