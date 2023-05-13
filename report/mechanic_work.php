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

    /* Chrome, Safari and Opera syntax */
    :-webkit-full-screen {
      background-color: #FFFFFF;
    }

    /* Firefox syntax */
    :-moz-full-screen {
      background-color: #FFFFFF;
    }

    /* IE/Edge syntax */
    :-ms-fullscreen {
      background-color: #FFFFFF;
    }

    /* Standard syntax */
    :fullscreen {
      background-color: #FFFFFF;
    }
  </style>
</head>
<body class="app sidebar-mini">
  <?php require_once '../menu/menu.php'; require_once '../menu/datetime_function.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-home" ></i> งานทั้งหมด </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>
    <div class="row">
     <div class="col-md-12">
      <div class="tile">
        <div class="row">
          <div class="col-md-10">
           <h4>งานทั้งหมด</h4>
         </div>
         <div class="col-md-2 text-right">
           <button onclick="openFullscreen();" class="btn btn-info btn-sm">ขยายตาราง</button>
         </div>
       </div>
       <hr>
       <form action="" method="post" accept-charset="utf-8">
        <div class="row justify-content-center">
          <div class="col-md-6">

            <div class="form-row">
              <div class="form-group col-md-6">
                <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                  <input type="text" name="date_1" value="<?=date('Y-m-d')?>" class="form-control datetimepicker-input" data-target="#datetimepicker7" placeholder="เวลาเริ่มต้น" required />
                  <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                  <input type="text" name="date_2" value="<?=date('Y-m-d')?>" class="form-control datetimepicker-input" data-target="#datetimepicker8" placeholder="เวลาสิ้นสุด" required />
                  <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4">
                <select name="z_id" class="form-control">
                  <option value="">--- เลือกโซนพื้นที่ ---</option>
                  <?php $sql = mysqli_query($conn,"SELECT * FROM zone ");
                  while ($rs = mysqli_fetch_assoc($sql)) { ?>
                   <option value="<?=$rs['z_id'].",".$rs['z_name']?>"><?=$rs['z_name']?></option>
                 <?php } ?>            
               </select>
             </div>
             <div class="form-group col-md-4">
              <select name="c_id" class="form-control">
                <option value="">--- เลือกประเภท ---</option>
                <?php $sql = mysqli_query($conn,"SELECT c_id,c_name FROM category "); 
                while($rs = mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?=$rs['c_id']?>"><?=$rs['c_name']?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <select name="m_id" id="m_id_search" class="form-control">
                <option value="">--- เลือกชื่อ ---</option>
                <?php $sql = mysqli_query($conn,"SELECT m_id,m_name FROM member "); 
                while($rs = mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?=$rs['m_id']?>"><?=$rs['m_name']?></option>
                <?php } ?>
              </select>
            </div> 
          </div>
          <div class="row justify-content-center">
            <div class="col-md-2">
              <button type="submit" class="btn btn-info">ค้นหา</button> 
            </div>
          </div>    

        </div>
        
      </div>
    </form>
    <hr>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <?php if($_POST['action']=="ปิดงาน"){
          echo "<hr><h5 class='text-secondary text-center'>รายการที่สืบค้น : รายการที่ปิดงาน</h5>";
        }else if($_POST['action']=="คืนงาน"){
          echo "<hr><h5 class='text-secondary text-center'>รายการที่สืบค้น : รายการที่คืนงาน</h5>";
        }else if($_POST['action']=="sla"){
          echo "<hr><h5 class='text-secondary text-center'>รายการที่สืบค้น : รายการที่ตก SLA แล้ว</h5>";
        }else if($_POST['action']=="pending"){
          echo "<hr><h5 class='text-secondary text-center'>รายการที่สืบค้น : รายการที่ Pending</h5>";
        } ?>
      </div>
    </div>
    <table id="example" class="table table-striped table-bordered table-responsive table-sm" style="width:100%">
      <thead class="text-nowrap align-middle  thead-dark">
        <tr>
          <th>No.</th>
          <th>เลขที่ใบงาน</th>
          <th>ชื่อใบงาน</th>
          <th>------ สิ่งที่ให้ดำเนินการ ------</th>
          <th>(Zone)เขตพื้นที่</th>
          <th>--- ประเภท ---</th>
          <th>สถานที่ปฏิบัติงาน</th>
          <th>แผนก</th>
          <th>ผู้มอบหมายงาน</th> 
          <th>ชื่อช่าง</th>
          <th>กำหนดเริ่มงาน</th>
          <th>กำหนดปิดงาน</th>
          <th>วันที่รับงาน</th>
          <th>วันที่เริ่มงาน</th>
          <th>วันที่ปิดงาน</th>
          <th>---- รายละเอียดการปิดงาน ----</th>
          <th>เหตผลที่คืนงาน</th>
          <th>เวลาคืนงาน</th>
          <th>รายละเอียดงานคงค้าง</th>
          <th>ตนวจงานช่าง</th>
          <th>สถานะ</th>
          <th>สถานะ SLA</th>
        </tr>
      </thead>
      <tbody class="align-middle">
        <?php 
        if($_POST['date_1']){
          $z_id = explode(",",$_POST['z_id']); 
          $sql = mysqli_query($conn,"SELECT *,b.m_name as m_name,f.m_name as sender,g.ws_id as g_ws_id,a.ws_id as ws_id FROM worksheet a 
            LEFT JOIN member b 
            on a.m_id = b.m_id
            LEFT JOIN place c 
            on a.place_id = c.place_id
            LEFT JOIN division d 
            on a.dv_id = d.dv_id
            LEFT JOIN zone e 
            on a.z_id = e.z_id 
            LEFT JOIN member f 
            on f.m_id = a.ws_sender
            LEFT JOIN transfer_job g 
            on a.ws_id = g.ws_id 
            LEFT JOIN category  h 
            on a.c_id = h.c_id
            WHERE (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."' and a.z_id Like '%".$z_id[0]."') and a.c_id Like '%".$_POST['c_id']."%' and a.m_id Like '%".$_POST['m_id']."%'
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
            LEFT JOIN category h 
            on a.c_id = h.c_id
            ORDER BY a.ws_id DESC ");
        }

        $i=1;
        while ($rs = mysqli_fetch_assoc($sql)) {
          if(strtotime(date($rs['ws_end_date'])) <= strtotime(date("Y-m-d H:i:s")) ){
           $date = DateDiff_Before_timeout($rs['ws_end_date'],date("Y-m-d H:i:s"));
         }else{
           $date = DateDiff_Over_time(date("Y-m-d H:i:s"),$rs['ws_end_date']);
         }
         ?> 
         <tr onclick="window.open ('job_description.php?id=<?=$rs['ws_id']?>','_blank')">
          <td class="text-nowrap align-middle"><?=$i;?></td>
          <td class="text-nowrap align-middle"><?=$rs['ws_number_id']?></a></td>
          <td class="text-nowrap align-middle"><?=$rs['ws_name']?></td>
          <td class="align-middle"><?=$rs['ws_request']?></td>
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
          <td class="text-nowrap align-middle"><?=$rs['panding_note']?></td>
          <td class="text-nowrap align-middle"><?=$rs['ws_assess_status']=="" ? "ยังไม่ตรวจงาน":$rs['ws_assess_status'] ?></td>
          <td class="text-nowrap align-middle">
            <?php 
            if($rs['ws_id'] === $rs['g_ws_id']){

              echo "<i class='fa fa-exchange text-danger'> </i> คืนงาน";

            }else{
              ######################################################################################
              #  แก้ bug ในกรณีช่างเริ่มงานไปแล้ว แต่ไม่มีรับงานก่อนหน้านี้ คือวันที่ 5 ก.พ 63 วันล่าสุดก่อนปรับปรุงระบบ      #
              ######################################################################################
              if(strtotime($rs['ws_start_date']) >= strtotime(date("2020-02-06"))){

                if($rs['accept_work'] =="" and $rs['accept_work'] !="0000-00-00 00:00:00"){
                  echo "<i class='fa fa-exclamation-triangle text-warning'> ยังไม่รับงาน</i> ";
                }else if($rs['accept_work'] !="" and $rs['accept_work'] !="0000-00-00 00:00:00"){

                 if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == ''){
                  echo ($rs['panding_note'] =='' ? "<i class='fa fa-play-circle text-success'></i> &nbsp; เริ่มงานแล้ว " : "<i class='fa fa-spinner fa-spin'></i> งานคงค้าง");
                }elseif($rs['ws_job_start'] == ''){
                  echo "<i class='fa fa-check'> รับงาน</a>/<i class='fa fa-ban'> ยังไม่เริ่มงาน</i>";
                }elseif($rs['ws_job_start']!= '' and $rs['ws_job_end'] != '' ){
                  echo "<i class='fa fa-step-forward'></i> &nbsp; &nbsp; ปิดงานแล้ว ";
                }
              }

            }else{

             if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == ''){
              echo ($rs['panding_note'] =='' ? "<i class='fa fa-play-circle text-success'></i> &nbsp; เริ่มงานแล้ว " : "<i class='fa fa-spinner fa-spin'></i> งานคงค้าง");
            }elseif($rs['ws_job_start'] == ''){
              echo "<i class='fa fa-ban'> ยังไม่เริ่มงาน</i>";
            }elseif($rs['ws_job_start']!= '' and $rs['ws_job_end'] != '' ){
              echo "<i class='fa fa-step-forward'></i> &nbsp; &nbsp; ปิดงานแล้ว ";
            }


          }
          
        }
        ?>
      </td>
      <td class="text-nowrap align-middle"> <?php  if($rs['ws_id'] === $rs['g_ws_id']){
       echo "<i class='fa fa-exchange text-danger'> :</i> คืนงาน";
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

<script type="text/javascript">

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
    var table = $('#example').DataTable({
      lengthChange: true,
      stateSave: true,
      /*buttons: ['excel' ,'print', 'colvis' ],*/
      buttons: [
      { extend: 'excel', className: 'btn-sm btn-warning' },
      /*{ extend: 'print', className: 'btn-sm btn-info' },*/
      { extend: 'colvis', className: 'btn-sm btn-secondary' }
      ],
      "lengthMenu": [[10,25, 50,100, -1], [10,25, 50,100, "All"]],
      "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
      "drawCallback": function () {
        $('.dataTables_paginate > .pagination').addClass('pagination-sm');

      }
    });

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0) ' );
  } );

  /**************************/
  /* ขยายตาราง               */
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
</body>
</html>