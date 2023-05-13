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
    .circular--square {
      /*border-radius: 50%;*/
      width: 40px;
      height: 60px;
      /*-moz-box-shadow: 10px 10px 5px #888888; */
      box-shadow: 1.5px 1.5px 1.5px #888888;}
    }
  </style>
</head>
<body class="app sidebar-mini">
  <?php// require_once '../menu/menu.php'; require_once '../menu/datetime_function.php'; ?>


  <div class="row">
   <div class="col-md-12">
    <div class="tile">
      <div class="row">
        <div class="col-md-8">
         <h4>รายการเข้า-ออกงาน  : <?=$_POST['date_1'].$_GET['date']." ถึง ".$_POST['date_2'].$_GET['date'];?></h4>
       </div>
       <div class="col-md-2 text-right" >
         <!-- <button onclick="openFullscreen();" class="btn btn-info btn-sm">ขยายตาราง</button> -->
       </div>
       
       <div class="col-md-2 text-center">
         <h6><a href="work_in_out.php"> <i class="fa fa-reply-all"></i></a></h6>
       </div>
       
     </div>
     <hr>
     <table id="example" class="table table-striped table-bordered">
      <thead class="text-nowrap align-middle  thead-dark text-center">
        <tr>
          <th>No.</th>
          <th>ชื่อ - สกุล</th>
          <th>ภาพเข้างาน</th>
          <th>วันที่เข้างาน</th>
          <th>เวลาเข้างาน</th>
          <th>หมายเหตุ</th> 
          <th>ภาพออกงาน</th>
          <th>วันที่ออกงาน</th>
          <th>เวลาออกงาน</th>
          <th>หมายเหตุ</th>
          <th>เวลารวม</th>
        <!-- <th>ชั่วโมงทำงาน</th>
          <th>ชั่วโมง OT</th> -->
        </tr>
      </thead>
      <tbody class="text-nowrap align-middle text-center">
        <?php 
        if(strtotime($_POST['date_1'])==strtotime($_POST['date_2'])){

          $date_sharch = $_POST['date_1'] =="" ? $_GET['date'] : $_POST['date_1']; 
          if(!$_GET['date']){
            // if($_POST['m_id']){

            //   $sql = mysqli_query($conn,"SELECT a.m_id,a.m_name FROM member a
            //     LEFT JOIN job_in_out b 
            //     ON a.m_id = b.m_id 
            //     INNER JOIN division c 
            //     ON c.dv_id = a.dv_id
            //     WHERE a.m_id Like '%".$_POST['m_id']."%'
            //     GROUP BY a.m_id
            //     ORDER BY b.date_in_out desc,b.trans_pic asc")or die(mysqli_error($conn));

            // }else{
            $sql = mysqli_query($conn,"SELECT a.m_id,a.m_name FROM member a
              LEFT JOIN job_in_out b 
              ON a.m_id = b.m_id 
              INNER JOIN division c 
              ON c.dv_id = a.dv_id
              WHERE (a.dv_id = '".$_POST['dv'][0]."' or a.dv_id = '".$_POST['dv'][1]."' or a.dv_id = '".$_POST['dv'][2]."' or a.dv_id = '".$_POST['dv'][3]."') and (a.m_id Like '%".$_POST['m_id']."%')
              GROUP BY a.m_id
              ORDER BY b.date_in_out desc,b.trans_pic asc")or die(mysqli_error($conn)); 
            // }
          }else{
            $sql = mysqli_query($conn,"SELECT a.m_id,a.m_name FROM member a
              LEFT JOIN job_in_out b 
              ON a.m_id = b.m_id 
              INNER JOIN division c 
              ON c.dv_id = a.dv_id
              GROUP BY a.m_id
              ORDER BY b.date_in_out desc,b.trans_pic asc")or die(mysqli_error($conn)); 
          } 

          $i=1;
          while ($rs = mysqli_fetch_assoc($sql)) {

            $sql01 = mysqli_query($conn,"SELECT min(date_in_out)as date_in,action,t_note,trans_pic,j_inout_id FROM job_in_out WHERE action = 'In'  
              and date(date_in_out) = '$date_sharch' and m_id = '".$rs['m_id']."'
              ");
            $rs01 = mysqli_fetch_assoc($sql01);
            $date_in      = explode(" ",$rs01['date_in']);
            $date_start   = $rs01['date_in']; //  วันที่เริ่มนับ

            $sql0 = mysqli_query($conn,"SELECT max(date_in_out)as date_out,j_inout_id,action,trans_pic,t_note
             FROM job_in_out 
             WHERE action = 'Out' and (date(date_in_out) = '$date_sharch') and m_id = '".$rs['m_id']."'
             GROUP BY date(date_in_out)
             ORDER BY j_inout_id desc,date_in_out desc")or die(mysqli_error($conn));
            $rs0 = mysqli_fetch_assoc($sql0);
            $date_out  = explode(" ",$rs0['date_out']);

                ######################
                # กรณีที่ รายการวันที่ไม่มีในการค้นหาในวันที่เดียวกัน ให้ค้นหาวันที่มากกว่า แต่ไม่เกิน 6 โมงเช้าของวันนั้น
                ######################

            $date_ot = date('Y-m-d H:i:s', strtotime("+19 hour", strtotime(date($rs01['date_in']))));   
            $sql00= mysqli_query($conn,"SELECT min(date_in_out)as date_out,j_inout_id,trans_pic,t_note FROM job_in_out 
              WHERE action = 'Out' and  date_in_out <= '$date_ot' and date_in_out > '$date_start' and m_id = '".$rs['m_id']."'
              GROUP BY date(date_in_out),m_id
              ORDER BY j_inout_id desc")or die(mysqli_error($conn));
            $rs00 = mysqli_fetch_assoc($sql00);
            $datemin_out  = explode(" ",$rs00['date_out']);

            if($rs0['j_inout_id']){
                   $trans_pic = $rs0['trans_pic'];  // รูปภาพ
                   $j_out     = $rs0['j_inout_id']; // id แสดงเพื่อ ส่ง ค่าไปให้แสดง gps
                   $end       = $rs0['date_out'];   // วันที่สิ้นสุด
                   $t_note    = $rs0['t_note'];     // หมายเหตุ
                 }else{
                   $trans_pic = $rs00['trans_pic'];  // รูปภาพ
                   $j_out     = $rs00['j_inout_id']; // id แสดงเพื่อ ส่ง ค่าไปให้แสดง gps
                   $end       = $rs00['date_out'];   // วันที่สิ้นสุด
                   $t_note    = $rs00['t_note'];     // หมายเหตุ
                 }

                 ?> 
                 <tr>
                  <td class="align-middle"><?=$i;?></td>
                  <td class="align-middle">
                    <a href="" class="leave"
                    data-toggle    = "modal"
                    data-target    = "#modal_leave"
                    data-m_id      = "<?=$rs['m_id']?>"
                    data-t_note    = "<?=$rs01['t_note']?>"
                    data-date_time = "<?=$_POST['date_1'].$_GET['date'];?>">
                    <?=$rs['m_name']?><?=$rs['j_inout_id']?></a></td>
                    <td class="align-middle">
                      <a href="#" class="gps"
                      data-toggle = "modal"
                      data-target = "#gps"
                      data-nn     = "หมายเหตุเข้างาน :"
                      data-t_note = "<?=$rs01['t_note']?>"
                      data-img    = "../../xservice_site2/<?=$rs01['trans_pic']?>"
                      data-id     = "<?=$rs01['j_inout_id']?>"
                      data-name   = "<?=$rs['m_name']?>"
                      data-date_  = "<?=thai_date(strtotime($date_in[0]));?>"
                      data-time_  = "<?=$date_in[1];?>">
                      <?=$rs01['trans_pic']=="" ? "-" : "<img class='circular--square' src='../../xservice_site2/".$rs01['trans_pic']."'>";?></a></td>
                      <td class="align-middle">
                        <a href="#" class="gps"
                        data-toggle="modal"
                        data-target="#gps"
                        data-nn = "หมายเหตุเข้างาน :"
                        data-t_note  = "<?=$rs01['t_note']?>"
                        data-img = "../../xservice_site2/<?=$rs01['trans_pic']?>"
                        data-id = "<?=$rs01['j_inout_id']?>"
                        data-name = "<?=$rs['m_name']?>"
                        data-date_  = "<?=thai_date(strtotime($date_in[0]));?>"
                        data-time_  = "<?=$date_in[1];?>">
                        <?=$rs01['action']!='In' ? "" : thai_date(strtotime($date_in[0]));?>
                      </a>
                    </td>
                    <td class="align-middle"><a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุเข้างาน :"
                      data-t_note  = "<?=$rs01['t_note']?>"
                      data-img = "../../xservice_site2/<?=$rs01['trans_pic']?>"
                      data-id = "<?=$rs01['j_inout_id']?>"
                      data-name = "<?=$rs['m_name']?>"
                      data-date_  = "<?=thai_date(strtotime($date_in[0]));?>"
                      data-time_  = "<?=$date_in[1];?>">
                      <?=$rs01['action']!='In' ? "" : $date_in[1];?></a></td>
                      <td class="align-middle"><?=$rs01['t_note']?></td>
                      <td class="align-middle">
                        <a href="#" class="gps"
                        data-toggle="modal"
                        data-target="#gps"
                        data-nn = "หมายเหตุออกงาน:"
                        data-t_note  = "<?=$t_note?>"
                        data-img = "../../xservice_site2/<?=$trans_pic?>"
                        data-id = "<?=$j_out?>"
                        data-name   = "<?=$rs['m_name']?>"
                        data-date_  = "<?=$datemin_out[0] =="" ? thai_date(strtotime($date_out[0])) : thai_date(strtotime($datemin_out[0]));?>"
                        data-time_  = "<?=$date_out[1]=="" ? $datemin_out[1] : $date_out[1];?>">
                        <?php 
                        if($rs00['trans_pic']){
                          echo '<img class="circular--square" src="../../xservice_site2/'.$trans_pic.'">';
                        }else if($rs0['trans_pic']){
                          echo '<img class="circular--square" src="../../xservice_site2/'.$trans_pic.'">';
                        }else{
                          echo "-";
                        }
                        ?>
                      </a>
                    </td>
                    <td class="align-middle">
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn     = "หมายเหตุออกงาน:"
                      data-t_note = "<?=$t_note?>"
                      data-img    = "../../xservice_site2/<?=$trans_pic?>"
                      data-id     = "<?=$j_out?>"
                      data-name   = "<?=$rs['m_name']?>"
                      data-date_  = "<?=$datemin_out[0] =="" ? thai_date(strtotime($date_out[0])) : thai_date(strtotime($datemin_out[0]));?>"
                      data-time_  = "<?=$date_out[1]=="" ? $datemin_out[1] : $date_out[1];?>">
                      <?php if($date_out[0]==""){
                       echo  $datemin_out[0] =="" ? "" : thai_date(strtotime($datemin_out[0]));
                     }else{
                       echo thai_date(strtotime($date_out[0]));
                     } ?>

                   </a>
                 </td>
                 <td class="align-middle">
                  <a href="#" class="gps"
                  data-toggle="modal"
                  data-target="#gps"
                  data-nn     = "หมายเหตุออกงาน:"
                  data-t_note = "<?=$t_note?>"
                  data-img    = "../../xservice_site2/<?=$trans_pic?>"
                  data-id     = "<?=$j_out?>"
                  data-name   = "<?=$rs['m_name']?>"
                  data-date_  = "<?=$datemin_out[0] =="" ? thai_date(strtotime($date_out[0])) : thai_date(strtotime($datemin_out[0]));?>"
                  data-time_  = "<?=$date_out[1]=="" ? $datemin_out[1] : $date_out[1];?>">
                  <?=$date_out[1]=="" ? $datemin_out[1] : $date_out[1];?></a>
                </td>
                <!--  <td class="align-middle"><?=$datemin_out[0] =="" ? "" : $t_note?></td> -->
                <td class="align-middle"><?=$t_note?></td>
                <td class="align-middle">
                  <?php if($rs01['action']=='In' and  $j_out!=""){
                    echo duration($date_start,$end);
                  }else{
                    echo "-";
                  } ?>

                </td>

               <!--  <td class="align-middle">-</td>
                <td class="align-middle">-</td> -->
              </tr>
              <?php $i++; }

            }else{

              if($_POST['m_id']){

                $sql = mysqli_query($conn,"SELECT b.m_name,min(a.date_in_out) as date_in,a.m_id,a.action,a.j_inout_id,a.trans_pic,a.t_note
                  FROM job_in_out a
                  LEFT JOIN member b 
                  on a.m_id = b.m_id
                  INNER JOIN division c 
                  on b.dv_id = c.dv_id
                  WHERE date(a.date_in_out) >='".$_POST['date_1']."' AND date(a.date_in_out) <='".$_POST['date_2']."' and  (b.m_id Like '%".$_POST['m_id']."%')
                  GROUP BY date(a.date_in_out),a.m_id 
                  ORDER BY a.date_in_out desc")or die(mysqli_error($conn)); 

              }else{

                $sql = mysqli_query($conn,"SELECT b.m_name,min(a.date_in_out) as date_in,a.m_id,a.action,a.j_inout_id,a.trans_pic,a.t_note
                  FROM job_in_out a
                  LEFT JOIN member b 
                  on a.m_id = b.m_id
                  INNER JOIN division c 
                  on b.dv_id = c.dv_id
                  WHERE date(a.date_in_out) >='".$_POST['date_1']."' AND date(a.date_in_out) <='".$_POST['date_2']."' and (b.dv_id = '".$_POST['dv'][0]."' or b.dv_id = '".$_POST['dv'][1]."' or b.dv_id = '".$_POST['dv'][2]."' or b.dv_id = '".$_POST['dv'][3]."')
                  GROUP BY date(a.date_in_out),a.m_id 
                  ORDER BY a.date_in_out desc")or die(mysqli_error($conn));

              }

              $i=1;
              while($rs = mysqli_fetch_assoc($sql)){ 
              $date  = explode(" ",$rs['date_in']); // ใช้ในการส่งเวลา ไปค้นหาข้อมูลต่อ $date[0]

              ######################
              # แสดงข้อมูล การ ลงเลลาเข้างาน 
              ######################
              $sql02 = mysqli_query($conn,"SELECT min(date_in_out)as date_in_max,action,t_note,trans_pic,j_inout_id FROM job_in_out WHERE action = 'In'and date(date_in_out) = '$date[0]' and m_id = '".$rs['m_id']."'
                order by date_in_out asc");
              $rs02 = mysqli_fetch_assoc($sql02);
              $date_in        = explode(" ",$rs02['date_in_max']);
              $date_start     = $rs02['date_in_max']; //  วันที่เริ่มนับ
##############################################################################

              $sql0 = mysqli_query($conn,"SELECT max(a.date_in_out)as date_out,max(a.j_inout_id)as id_outone,a.action,max(a.trans_pic)as trans_img
               FROM job_in_out a
               WHERE a.action = 'Out' and (date(a.date_in_out) = '$date[0]') and a.m_id = '".$rs['m_id']."'
               ORDER BY max(a.j_inout_id) desc
               ")or die(mysqli_error($conn));
              $rs0 = mysqli_fetch_assoc($sql0);

              $date_out  = explode(" ",$rs0['date_out']);


              $sqlmax = mysqli_query($conn,"SELECT t_note FROM job_in_out WHERE j_inout_id = '".$rs0['id_outone']."' ");
              $rsmax = mysqli_fetch_assoc($sqlmax);

##############################################################################


                ######################
                # กรณีที่ รายการวันที่ไม่มีในการค้นหาในวันที่เดียวกัน ให้ค้นหาวันที่มากกว่า แต่ไม่เกิน 19 ชั่วโมงหลังจากวันลงเวลาเข้างาน
                ######################

              $date_ot = date('Y-m-d H:i:s', strtotime("+19 hour", strtotime(date($rs02['date_in_max']))));
              $sql00= mysqli_query($conn,"SELECT min(date_in_out)as date_out,j_inout_id,trans_pic,t_note FROM job_in_out 
                WHERE action = 'Out' and  date_in_out <= '$date_ot' and date_in_out >= '$date_start' and m_id = '".$rs['m_id']."'
                GROUP BY date(date_in_out),m_id
                ORDER BY j_inout_id desc")or die(mysqli_error($conn));
              $rs00 = mysqli_fetch_assoc($sql00);
              $datemin_out  = explode(" ",$rs00['date_out']);

              if(!$rs0['id_outone']){

                   $trans_pic = $rs00['trans_pic'];  // รูปภาพ
                   $j_out     = $rs00['j_inout_id']; // id แสดงเพื่อ ส่ง ค่าไปให้แสดง gps
                   $end       = $rs00['date_out'];   // วันที่สิ้นสุด
                   $t_note    = $rs00['t_note'];     // หมายเหตุ

                 }else{

                   $trans_pic = $rs0['trans_img'];    // รูปภาพ
                   $j_out     = $rs0['id_outone'];    // id แสดงเพื่อ ส่ง ค่าไปให้แสดง gps
                   $end       = $rs0['date_out'];     // วันที่สิ้นสุด
                   $t_note    = $rsmax['t_note'];     // หมายเหตุ ทำไมไม่แสดง

                 }
                 ?> 
                 <tr>
                  <td class="align-middle"><?=$i;?></td>
                  <td class="align-middle"><?=$rs['m_name']?></td>
                  <td class="align-middle"><a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุเข้างาน :"
                    data-t_note  = "<?=$rs02['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs02['trans_pic']?>"
                    data-id = "<?=$rs02['j_inout_id']?>"
                    data-name = "<?=$rs['m_name']?>"
                    data-date_ = "<?=thai_date(strtotime($date_in[0]))?>"
                    data-time_ = "<?=$date_in[1];?>">
                    <?=$rs02['trans_pic']=="" ? "-" : "<img class='circular--square' src='../../xservice_site2/".$rs02['trans_pic']."'>"; ?></a></td>
                    <td class="align-middle">
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุเข้างาน :"
                      data-t_note  = "<?=$rs02['t_note']?>"
                      data-img = "../../xservice_site2/<?=$rs02['trans_pic']?>"
                      data-id = "<?=$rs02['j_inout_id']?>"
                      data-name = "<?=$rs['m_name']?>"
                      data-date_ = "<?=thai_date(strtotime($date_in[0]))?>"
                      data-time_ = "<?=$date_in[1];?>">
                      <?=$rs02['action']!='In' ? "" : thai_date(strtotime($date_in[0]));?>
                    </a>
                  </td>
                  <td class="align-middle"><a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุเข้างาน :"
                    data-t_note  = "<?=$rs02['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs02['trans_pic']?>"
                    data-id = "<?=$rs02['j_inout_id']?>"
                    data-name = "<?=$rs['m_name']?>"
                    data-date_ = "<?=thai_date(strtotime($date_in[0]))?>"
                    data-time_ = "<?=$date_in[1];?>">
                    <?=$rs02['action']!='In' ? "" : $date_in[1];?></a></td>
                    <td class="align-middle"><?=$rs02['t_note']?></td>
                    <td class="align-middle">
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุออกงาน:"
                      data-t_note  = "<?=$t_note?>"
                      data-img = "../../xservice_site2/<?=$trans_pic?>"
                      data-id = "<?=$j_out?>"
                      data-name = "<?=$rs['m_name']?>"
                      data-date_ = "<?php if($date_out[0]==""){
                        echo $datemin_out[0] =="" ? "" : thai_date(strtotime($datemin_out[0]));
                        }else{
                          echo thai_date(strtotime($date_out[0]));
                        } ?>"
                        data-time_ = "<?php if($date_out[0]==""){ 
                          echo $date_out[1]=="" ? $datemin_out[1] : $date_out[1]; 
                          }else{
                            echo $date_out[1]=="" ? $datemin_out[1] : $date_out[1];
                          }?>">
                          <div>
                            <?php 
                            if($rs00['trans_pic']){
                              echo '<img class="circular--square" src="../../xservice_site2/'.$trans_pic.'">';
                            }else if($rs0['trans_img']){
                              echo '<img class="circular--square" src="../../xservice_site2/'.$trans_pic.'">';
                            }else{
                              echo "-";
                            }
                            ?></div>
                          </a>
                        </td>
                        <td class="align-middle">
                          <a href="#" class="gps"
                          data-toggle="modal"
                          data-target="#gps"
                          data-nn = "หมายเหตุออกงาน:"
                          data-t_note  = "<?=$t_note?>"
                          data-img = "../../xservice_site2/<?=$trans_pic?>"
                          data-id = "<?=$j_out?>"
                          data-name = "<?=$rs['m_name']?>"
                          data-date_ = "<?php if($date_out[0]==""){
                            echo $datemin_out[0] =="" ? "" : thai_date(strtotime($datemin_out[0]));
                            }else{
                              echo thai_date(strtotime($date_out[0]));
                            } ?>"
                            data-time_ = "<?php if($date_out[0]==""){ 
                              echo $date_out[1]=="" ? $datemin_out[1] : $date_out[1]; 
                              }else{
                                echo $date_out[1]=="" ? $datemin_out[1] : $date_out[1];
                              }?>">

                              <?php if($date_out[0]==""){
                                echo  $datemin_out[0] =="" ? "" : thai_date(strtotime($datemin_out[0]));
                              }else{
                               echo thai_date(strtotime($date_out[0]));
                             } ?>

                           </a>
                         </td>
                         <td class="align-middle">
                          <a href="#" class="gps"
                          data-toggle="modal"
                          data-target="#gps"
                          data-nn = "หมายเหตุออกงาน:"
                          data-t_note  = "<?=$t_note?>"
                          data-img = "../../xservice_site2/<?=$trans_pic?>"
                          data-id = "<?=$j_out?>"
                          data-name = "<?=$rs['m_name']?>"
                          data-date_ = "<?php if($date_out[0]==""){
                            echo $datemin_out[0] =="" ? "" : thai_date(strtotime($datemin_out[0]));
                            }else{
                              echo thai_date(strtotime($date_out[0]));
                            } ?>"
                            data-time_ = "<?php if($date_out[0]==""){ 
                              echo $date_out[1]=="" ? $datemin_out[1] : $date_out[1]; 
                              }else{
                                echo $date_out[1]=="" ? $datemin_out[1] : $date_out[1];
                              }?>">
                              <?=$date_out[1]=="" ? $datemin_out[1] : $date_out[1];?></a>
                            </td>
                            <td class="align-middle"><?=$t_note?></td>
                            <td class="align-middle">
                              <?php 
                              if($rs['action']=='In' and  $rs00['trans_pic']!=""){
                                echo duration($date_start,$end);

                              }elseif ($rs02['action']=="In" and $end !="" ) {
                                echo duration($date_start,$end);
                              }else{
                                echo "-";
                              } ?>

                            </td>

                      <!-- <td class="align-middle">-</td>
                        <td class="align-middle">-</td> -->
                      </tr>
                      <?php $i++; } } ?>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="gps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">พิกัด GPS : <strong id="name_"></strong> วัน - เวลา : <strong id="date_00"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-4">
                        <img src="" class="img-thumbnail" id="img">
                      </div>
                      <div class="col-md-8" id="gps_show" >
                        <!-- <iframe src="gps.php" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                      </div> 
                    </div>

                    <form id="update_note">
                      <div class="row"> 
                        <div class="col-md-3"><hr>
                          <label class="my-2 mr-2"><strong id="nn"></strong></label>
                        </div>
                        <div class="col-md-7"><hr>
                          <input type="text" name="t_note" class="form-control" id="t_note">
                          <input type="text" name="id" class="form-control" id="id" hidden="">
                        </div>
                        <div class="col-md-2"><hr>
                          <button type="submit" class="btn btn-warning ">ยืนยัน</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer" >
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ระบุเหตุผลหรือหมายเหตุไม่ลงเวลางาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="update_leave">  
                     <label>ระบุหมายเหตุ</label>
                     <textarea type="textarea" rows="4" name="t_note" class="form-control" id="update_t_note" placeholder="ระบุหมายเหตุ..."></textarea>
                     <input type="text" name="id" class="form-control" id="id_m_id" hidden>
                     <input type="text" name="date_time" class="form-control" id="date_time" hidden>
                     <div class="modal-footer">
                      <button type="submit" class="btn btn-warning">ยืนยัน</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>



          <?php
          function duration($date_start,$end){
            $remain=intval(strtotime($end)-strtotime($date_start));
            $wan=floor($remain/86400);
            $l_wan=$remain%86400;
            $hour=floor($l_wan/3600);
            $l_hour=$l_wan%3600;
            $minute=floor($l_hour/60);
            $second=$l_hour%60;
              //return $wan." วัน ".$hour." ชั่วโมง ".$minute." นาที ";
            return $hour.":".$minute;
          }

          ?>

        </main>
        <?php  require_once '../link_js/link_js.php'; ?>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.colVis.min.js"></script>

        <script>
          /**************************/
          /*       ขยายตาราง         */
          /**************************/
          var elem = document.getElementById("example");
          function openFullscreen() {
            if (elem.requestFullscreen) {
              elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { /* Firefox */
              elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
              elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE/Edge */
              elem.msRequestFullscreen();
            }
          }
        </script>
        <script type="text/javascript">
          /*******************************/
          /*  update_หมายเหตุที่ลงทะเบียนไม่ได้  */
          /*******************************/
          $('.leave').click(function(event) {
           event.preventDefault();

           var id        = $(this).data('m_id'); 
           var t_note    = $(this).data('t_note');
           var date_time = $(this).data('date_time');

           $('#id_m_id').val(id);
           $('#update_t_note').val(t_note);
           $('#date_time').val(date_time);

         });

          $('.gps').click(function(event) {
           event.preventDefault();
           var id   = $(this).data('id'); 
           var name = $(this).data('name');
           var date = $(this).data('date_');
           var time = $(this).data('time_');
           var date_time = date +' => '+ time;
           var img  = $(this).data('img');

           if(img!="../../xservice_site2/"){
            var images = img;
          }else{
            var images = 'img/no_img.jpg';
          } 

          var nn = $(this).data('nn');
          var t_note = $(this).data('t_note'); 

          $("#id").val(id);
          $("#img").attr('src',images);
          $("#nn").text(nn);
          $("#t_note").val(t_note);
          $("#name_").text(name);
          $("#date_00").text(date_time);


           //$('#img').css('width','1000px');
           //$('#img').css('margin','10px auto 10px auto');
           //console.log(id);
           $.ajax({
            url: 'gps.php',
            type: 'POST',
            data: {'id': id },
            success: function(data){
              $('#gps_show').html(data);
            }

          })
         });

          $("#update_note").on('submit',function(event) {
           event.preventDefault();
           var todu = "update_t_note";
           $.ajax({
             url: 'manages_note.php',
             type: 'POST',
             dataType: 'json',
             data: $(this).serialize()+"&update="+todu,
             success : function(data){ 
              if(data.data=="1"){

                $('#gps').hide();

                setTimeout(function(){
                  window.location.reload();
                },300)
              }

            }
          })

         });

          $("#update_leave").on('submit',function(event) {
           event.preventDefault();
           var update_leave = "update_leave";
           $.ajax({
             url: 'manages_note.php',
             type: 'POST',
             dataType: 'json',
             data: $(this).serialize()+"&update="+ update_leave,
             success :function(data){
              if(data.data=="1"){

                $('#modal_leave').modal('hide');

                setTimeout(function(){
                  window.location.reload();
                },1000)   

              }
            }
          }) 
         });


  //function จัดการเวลา ***
  $(function () {

    $('#datetimepicker7').datetimepicker({  format: 'L', format: 'YYYY-MM-DD'});
    $('#datetimepicker8').datetimepicker({
      useCurrent: false,
      format: 'L', 
      format: 'YYYY-MM-DD'
    });
    $("#datetimepicker7").on("change.datetimepicker", function (e) {
      $('#datetimepicker8').datetimepicker('minDate', e.date);
    });
    $("#datetimepicker8").on("change.datetimepicker", function (e) {
      $('#datetimepicker7').datetimepicker('maxDate', e.date);
    });
  });


  $(document).ready(function() {

   $('#m_id_search').select2();

   var table = $('#example').DataTable({
    lengthChange: true,
    stateSave: true,
    /*buttons: ['excel' ,'print', 'colvis' ],*/
    buttons: [
    {
      extend: 'excel',
      messageTop: 'รายงานเข้า-ออกงาน',
      className: 'btn-sm btn-warning',
      title: ''
    },
    // {
    //   extend: 'excelHtml5',
    //   text: 'Excel',
    //   exportOptions: {
    //     stripHtml: false
    //   }
    // },

    /*{ extend: 'print', className: 'btn-sm btn-info' },*/
    { extend: 'colvis', className: 'btn-sm btn-secondary' }
    ],
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],

    "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
    "drawCallback": function () {
      $('.dataTables_paginate > .pagination').addClass('pagination-sm');
      messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
    }
  } );

   table.buttons().container()
   .appendTo( '#example_wrapper .col-md-6:eq(0) ' );
 } );
</script>
</body>
</html>



