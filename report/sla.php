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
          <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        </ul>
      </div>
      <div class="row">
       <div class="col-md-12">
        <div class="tile">
          <h4>รายการตรวจสอบ SLA</h4>
          <hr>
          <table id="example" class="table table-striped table-bordered table-responsive table-sm" style="width:100%">
            <thead class="text-nowrap align-middle  thead-dark">
              <tr>
                <th>No.</th>
                <th>เลขที่เลขใบงาน</th>
                <th>ชื่อใบงาน</th>
                <th>สิ่งที่ให้ดำเนินการ</th>
                <th>(Zone)เขตพื้นที่</th>
                <th>สถานที่ปฏิบัติงาน</th>
                <th>แผนก</th>
                <th>ผู้มอบหมายงาน</th> 
                <th>ชื่อช่าง</th>
                <th>กำหนดเริ่มงาน</th>
                <th>กำหนดปิดงาน</th>
                <th>วันที่เริ่มงาน</th>
                <th>วันที่ปิดงาน</th>
                <th>สถานะ</th>
                <th>สถานะ SLA</th>
              </tr>
            </thead>
            <tbody class="text-nowrap align-middle">
              <?php  $sql = mysqli_query($conn,"SELECT *,b.m_name as m_name,f.m_name as sender,g.ws_id as g_ws_id,a.ws_id as ws_id FROM worksheet a 
                INNER JOIN member b 
                on a.m_id = b.m_id
                INNER JOIN place c 
                on a.place_id = c.place_id
                INNER JOIN division d 
                on a.dv_id = d.dv_id
                INNER JOIN zone e 
                on a.z_id = e.z_id 
                INNER JOIN member f 
                on f.m_id = a.ws_sender
                LEFT JOIN transfer_job g 
                on a.ws_id = g.ws_id 
                wHERE ISNULL(a.ws_job_end) and a.ws_end_date !='0000-00-00 00:00:00'
                ORDER BY a.ws_id DESC ");
              $i=1;
              while ($rs = mysqli_fetch_assoc($sql)) {
                if(strtotime(date($rs['ws_end_date'])) <= strtotime(date("Y-m-d H:i:s")) ){
                 $date = DateDiff_Before_timeout($rs['ws_end_date'],date("Y-m-d H:i:s"));
               }else{
                 $date = DateDiff_Over_time(date("Y-m-d H:i:s"),$rs['ws_end_date']);
               }
               ?> 
               <tr>
                <td><?=$i;?></td>
                <td><?=$rs['ws_number_id']?></td>
                <td><?=$rs['ws_name']?></td>
                <td><?=$rs['ws_request']?></td>
                <td><?=$rs['z_name']?></td>
                <td><?=$rs['place_name']?></td>
                <td><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></td>
                <td><?=$rs['sender']?></td>
                <td><?=$rs['m_name'];?></td>
                <td><?=$rs['ws_start_date']?></td>
                <td><?=$rs['ws_end_date']?></td>
                <td><?=$rs['ws_job_start']?></td>
                <td><?=$rs['ws_job_end']?></td>
                <td>
                  <?php 
                  if($rs['ws_id'] === $rs['g_ws_id']){

                    echo "<i class='fa fa-exchange'> </i> โอนงาน";

                  }else{

                    if($rs['ws_job_start']!= '' and $rs['ws_job_end'] == '' ){
                      echo ($rs['panding_note'] =='' ? "<i class='fa fa-play-circle text-success'> :</i> เริ่มงานแล้ว " : "<i class='fa fa-spinner text-info fa-spin'></i> รอดำเนินการ");
                    }elseif($rs['ws_job_start'] == ''){
                      echo "<i class='fa fa-ban text-danger'></i> &nbsp; ยังไม่เริ่มงาน ";
                    }elseif($rs['ws_job_start']!= '' and $rs['ws_job_end'] != '' ){
                      echo "<i class='fa fa-step-forward'></i> &nbsp; &nbsp; ปิดงานแล้ว ";
                    }

                  }
                  ?>
                </td>
                <td> <?php  if($rs['ws_id'] === $rs['g_ws_id']){
                 echo "<i class='fa fa-exchange'> :</i> โอนงาน";
               }else{

                 if ($rs['ws_job_end']) {
                   if (strtotime($rs['ws_job_end'] > strtotime($rs['ws_end_date']))) {
                     echo "ไม่ผ่าน SLA";
                   }else{
                    echo "ผ่าน SLA";
                   }
                  }else{
                   echo $date;
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
  $(document).ready(function() {
    var table = $('#example').DataTable( {
      lengthChange: true,
      /*buttons: ['excel' ,'print', 'colvis' ],*/
      buttons: [
      { extend: 'excel', className: 'btn-sm btn-warning' },
      /*{ extend: 'print', className: 'btn-sm btn-info' },*/
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
</body>
</html>