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
        <h1><i class="fa fa-home" ></i> รายงานช่างที่โอนงานกลับ</h1>
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
        <h4>รายงานช่างโอนงานกลับ</h4>
        <hr>
        <table class="table table-inverse table-striped table-responsive-sm table-sm" id="example">
         <thead class="text-nowrap align-middle thead-dark">
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
            <th>เหตุผลที่โอนงาน</th>
            <th>วันที่โอนงาน</th>
          </tr>
        </thead>
        <tbody class="text-nowrap align-middle">

          <?php $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl
           FROM transfer_job a 
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
           LEFT JOIN member g 
           on g.m_id = a.m_id
           INNER JOIN category h 
           on h.c_id = b.c_id 
           ORDER BY a.t_id DESC")or die(mysqli_error($conn));
          $i=1;
          while($rs = mysqli_fetch_assoc($sql)){ ?>  
           <tr>
             <td><?=$i;?></td>
             <td><?=$rs['ws_number_id']?></td>
             <td><?=$rs['ws_name'];?></td>
             <td><?=$rs['z_name'];?></td>
             <td><?=$rs['place_name'];?></td>
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
  $(document).ready(function() {
    var table = $('#example').DataTable( {
      lengthChange: true,
      /*buttons: ['excel' ,'print', 'colvis' ],*/
      buttons: [
      { extend: 'excel', className: 'btn-sm btn-warning' },
     /* { extend: 'print', className: 'btn-sm btn-info' },*/
      { extend: 'colvis', className: 'btn-sm btn-secondary' }
      ],
      "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
      "drawCallback": function () {
        $('.dataTables_paginate > .pagination').addClass('pagination-sm');

      }
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0) ' );
  } );
</script>
</script>
</body>
</html>