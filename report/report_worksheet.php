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
        <h1><i class="fa fa-home" ></i> ประวัติการปฏิบัติงานของช่างทั้งหมด</h1>
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
        <h4>รายงานช่างโอนงานกลับ</h4>
        <hr>
        <table  class="table table-bordered table-responsive table-sm" id="example" >
          <thead class="text-nowrap align-middle thead-light">
            <tr> 
              <th>#</th>
              <th>เลขที่ใบงาน</th>
              <th>ชื่อใบงาน</th>
              <th>รายละเอียด</th>
              <th>ประเภทงาน </th>
              <th>Zone(เขตพื้นที่)</th>
              <th>สถานที่ </th>
              <th>ผู้สร้างใบงาน</th>
              <th>ช่างที่ถูกมอบหมายงาน</th>
              <th>เวลาเริ่มงาน</th>
              <th>เวลาที่งานต้องเสร็จ</th>
            </tr>
          </thead>
          <tbody class="text-nowrap align-middle">

            <?php $sql = mysqli_query($conn,"SELECT *,d.m_name as name_user,f.m_name as name_admin  FROM worksheet a 
              INNER JOIN zone b 
              on a.z_id = b.z_id
              INNER JOIN place c 
              on c.place_id = a.place_id
              LEFT JOIN member d
              on d.m_id = a.m_id
              INNER JOIN category e
              on e.c_id = a.c_id 
              INNER JOIN member f
              on a.ws_sender = f.m_id
              ORDER BY a.ws_id desc")or die(mysqli_error($conn));
            $i=1;
            while($rs = mysqli_fetch_assoc($sql)){ ?>
              <tr>
                <td><?=$i;?></td>
                <td><?=$rs['ws_number_id']?></td>
                <td><?=$rs['ws_name']?></td>
                <td><?=$rs['ws_request']?></td>
                <td><?=$rs['c_name']?></td>
                <td><?=$rs['z_name']?></td>
                <td><?=$rs['place_name']?></td>
                <td>คุณ<?=$rs['name_admin']?></td>
                <td>คุณ<?=$rs['name_user']?></td>
                <td><?=$rs['ws_start_date']?></td>
                <td><?=$rs['ws_end_date']?></td>
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
</script>
</body>
</html>