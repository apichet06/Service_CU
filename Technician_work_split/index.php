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
  <?php require_once '../menu/menu.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-home" ></i> แยกประเภทงานช่าง </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="tile">
          <form action="" method="post" accept-charset="utf-8">
            <div class="row">
              <div class="form-group col-md-5">
                <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                  <input type="text" name="date_1" value="<?=date('Y-m-d')?>" class="form-control datetimepicker-input" data-target="#datetimepicker7" placeholder="เวลาเริ่มต้น" required />
                  <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-5">
                <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                  <input type="text" name="date_2" value="<?=date('Y-m-d')?>" class="form-control datetimepicker-input" data-target="#datetimepicker8" placeholder="เวลาสิ้นสุด" required />
                  <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <select name="z_id" class="form-control">
                  <option value="">--- เลือกโซนพื้นที่ ---</option>
                  <?php $sql = mysqli_query($conn,"SELECT * FROM zone ");
                  while ($rs = mysqli_fetch_assoc($sql)) { ?>
                   <option value="<?=$rs['z_id'].",".$rs['z_name']?>"><?=$rs['z_name']?></option>
                 <?php } ?>            
               </select>
             </div>
             <!-- <div class="col-md-4">
               <select name="year" class="form-control" required>
                 <option value="">--- เลือกปี ---</option>
                 <?php 
                 $sql = mysqli_query($conn,"SELECT year(ws_date)as year FROM worksheet 
                   GROUP BY year(ws_date) 
                   ORDER BY year(ws_date) ASC"); 
                   while($rs = mysqli_fetch_assoc($sql)){?>
                     <option value="<?=$rs['year']?>"><?=$rs['year']?></option>
                   <?php } ?>
                 </select>
               </div> -->
               
               <div class="form-group col-md-5">
                <select name="m_id" id="m_id_search" class="form-control">
                  <option value="">--- เลือกชื่อ ---</option>
                  <?php $sql = mysqli_query($conn,"SELECT m_id,m_name FROM member "); 
                  while($rs = mysqli_fetch_assoc($sql)){ ?>
                    <option value="<?=$rs['m_id']?>"><?=$rs['m_name']?></option>
                  <?php } ?>
                </select>
              </div>  
              <div class="col-md-2">
                <button type="submit" class="btn btn-info">ค้นหา</button> 
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
        <div class="tile">
          <h5 class="text-center">รายชื่อช่าง</h5>
          <h6 class="text-center text-secondary">รูปแบบการค้นหา : วันที่ <?php $z_id = explode(",",$_POST['z_id']); echo $_POST['date_1']." ถึง ".$_POST['date_2']." โซนพื้นที่ : ".$z_id[1]; ?></h6>
          <table class="table table-bordered table-sm" id="data_table">
            <thead>
              <tr>
                <th>ลำดับ</th>
                <th>ชื่อช่าง</th>
                <th>ประเภทงาน</th>
              </tr>
            </thead>
            <tbody> 
             <?php  $sql0 = mysqli_query($conn,"SELECT *,date(ws_date)as y FROM member a 
              INNER JOIN worksheet b 
              ON a.m_id = b.m_id 
              Where (b.z_id = '".$z_id[0]."' and date(b.ws_date) >= '".$_POST['date_1']."' and date(b.ws_date) <= '".$_POST['date_2']."') and (b.m_id Like '%".$_POST['m_id']."%')
              GROUP BY b.m_id
              ORDER BY b.m_id ")or die(mysqli_error($conn));
             $i=1;
             while($rs0 = mysqli_fetch_assoc($sql0)){
              ?>
              <tr>
                <td><?=$i;?></td>
                <td class="align-middle text-nowrap"><?=$rs0['m_name']?></td>
                <td>
                  <button class="btn btn-light btn-sm full_job01"
                  data-date_1 = "<?=$_POST['date_1']?>"
                  data-date_2 = "<?=$_POST['date_2']?>"
                  data-z_id   = "<?=$z_id[0]?>"
                  data-c_id   = "<?=$rs['c_id']?>"
                  data-m_id   = "<?=$rs0['m_id']?>"
                  >ดูทั้งหมด</button>
                  <?php $sql = mysqli_query($conn,"SELECT c_name,count(b.c_id)as s_sum,a.c_id FROM category a 
                    LEFT JOIN worksheet b 
                    on a.c_id = b.c_id
                    INNER JOIN zone c 
                    on b.z_id = c.z_id
                    Where b.m_id = '".$rs0['m_id']."' and date(b.ws_date) >= '".$_POST['date_1']."' and date(b.ws_date) <= '".$_POST['date_2']."' and b.z_id = '".$z_id[0]."' 
                    Group by b.c_id 
                    ");
                    while($rs = mysqli_fetch_assoc($sql)){ ?>
                      <button class="btn btn-light btn-sm on_click"
                      data-m_id="<?=$rs0['m_id']?>"
                      data-date_1 ="<?=$_POST['date_1']?>"
                      data-date_2 ="<?=$_POST['date_2']?>"
                      data-z_id = "<?=$z_id[0]?>"
                      data-c_id = "<?=$rs['c_id']?>"  
                      ><?=$rs['c_name'];?>
                    </button>
                    <?php } ?> </td>
                  </tr>
                  <?php $i++; } ?>
                </tbody>
              </table>
            </div> 
          </div>
          <div class="col-md-5 select_data">

          </div>
        </div>

        <div class="row">
         <div class="col-md-12 data_full_job"></div>
       </div>


       <!-- Button trigger modal -->

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

      $('.on_click').click(function(event) {
        event.preventDefault();
        var m_id   = $(this).data("m_id");
        var date_1 = $(this).data("date_1");
        var date_2 = $(this).data("date_2");
        var z_id   = $(this).data("z_id");
        var c_id   = $(this).data("c_id");
        $.ajax({
          url: 'data_.php',
          type: 'POST',
          beforeSend :function(){

          },
          data: { 'm_id':m_id,'date_1':date_1,'date_2':date_2, 'z_id' : z_id,'c_id': c_id },
          success: function(data){
            $('.select_data').html(data);
          }
        })
      });


      $('.full_job01').click(function(event) {
        event.preventDefault();
        var m_id = $(this).data("m_id");
        var date_1 = $(this).data("date_1");
        var date_2 = $(this).data("date_2");
        var z_id = $(this).data("z_id");
        var c_id = $(this).data("c_id");
        var action = "";
        var full ="full";
        $.ajax({
          url: 'data_report.php',
          type: 'POST',
          data: {'m_id':m_id,'date_1':date_1 ,'date_2':date_2 , 'z_id' : z_id,'c_id': c_id,'action': action },
          success: function(data){
            $('.data_full_job').html(data);
          }
        })
        $.ajax({
          url: 'data_.php',
          type: 'POST',
          beforeSend :function(){

          },
          data: { 'm_id':m_id,'date_1':date_1,'date_2':date_2, 'z_id' : z_id,'c_id': c_id,'full':full },
          success: function(data){
            $('.select_data').html(data);
          }
        })
      });



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
      
      $('#data_table').DataTable({
        lengthChange: true,
        buttons: ['excel' ,'print', 'colvis' ],
        "lengthMenu": [[6,10,-1], [6,10,"All"]],
        "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
        "drawCallback": function () {
          $('.dataTables_paginate > .pagination').addClass('pagination-sm');

        }

      });

    </script>

