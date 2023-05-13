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
  <?php require_once '../menu/menu.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-home" ></i> รายการช่างที่โอนงานกลับ</h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
      </ul>
    </div>
    <div class="row">
     <div class="col-md-12">
      <div class="tile">
        <h4>รายการช่างโอนงานกลับ</h4>
        <hr>
        <table class="table table-inverse table-striped table-responsive-sm">
         <thead>
           <tr>
            <th>#</th>
            <th>ชื่อใบงาน</th>
            <th>(Zone)เขตพื้นที่</th>
            <th>สถานที่</th>
            <th>แผนก</th>
            <th>ประเภทงาน</th>
            <th>ผู้สร้างใบงาน</th>
            <th>ชื่อช่าง</th>
            <th>เหตุผลที่โอนงาน</th>
            <th>วันที่โอนงาน</th>
            <th>ส่งมอบงานให้ช่าง</th>
          </tr>
        </thead>
        <tbody>

          <?php $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name FROM transfer_job a 
            INNER JOIN worksheet b 
            on a.ws_id = b.ws_id
            INNER JOIN zone c 
            on b.z_id = c.z_id 
            INNER JOIN place d 
            on d.place_id = b.place_id 
            INNER JOIN  division e 
            on e.dv_id = b.dv_id
            INNER JOIN member f 
            on f.m_id = b.ws_sender
            INNER JOIN member g 
            on g.m_id = b.m_id
            INNER JOIN category h 
            on h.c_id = b.c_id 
            ORDER BY a.t_id DESC")or die(mysqli_error($conn));
          $i=1;
          while($rs = mysqli_fetch_assoc($sql)){ ?>  
           <tr>
             <td><?=$i;?></td>
             <td><?=$rs['ws_name'];?></td>
             <td><?=$rs['z_name'];?></td>
             <td><?=$rs['place_name'];?></td>
             <td><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></td> 
             <td><?=$rs['c_name'];?></td>
             <td><?=$rs['m_sender']?></td>
             <td><?=$rs['m_name']?></td>
             <td><?=$rs['t_reason']?></td>
             <td><?=$rs['t_date'];?></td>
             <td><?php 
             if($rs['new_job']=="0"){
              echo '<button type="button" 
              class="btn btn-primary btn-sm deliver_w"
              data-ws_id = "'.$rs['ws_id'].'"
              data-ws_name = "'.$rs['ws_name'].'"
              data-c_id = "'.$rs['c_id'].'"
              data-ws_request = "'.$rs['ws_request'].'"
              data-z_id = "'.$rs['z_id'].'"
              data-toggle="modal"
              data-target="#deliver_work">คลิก</button>';
            }else{ 
              echo '<strong class="text-success">ส่งมอบงานใหม่แล้ว</strong>';
            } ?> 



          </td>
        </tr>
        <?php $i++;} ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<?php  require_once 'modal.php'; ?>
</main>

<?php  require_once '../link_js/link_js.php'; ?>
<script type="text/javascript" src="ajax.js" ></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#data_table').DataTable();
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


</script>
</body>
</html>