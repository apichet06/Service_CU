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
        <h1><i class="fa fa-home" ></i> ประเมินงานช่าง </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12 p-1">
        <div class="tile">
          <table class="table table-bordered table-sm table-responsive example">
       
            <thead class="text-nowrap align-middle thead-dark">
              <tr>
                <th>No.</th>
                <th>เลขที่ใบงาน</th>
                <th>ชื่อใบงาน</th>
                <th>แผนก</th>
                <th>(Zone)เขตพื้นที่</th>
                <th>สถานที่</th>
                <th>ผู้สร้างใบงาน</th>
                <th>ช่างดำเนินการ</th>
                <th>สถานะ</th>
                <th class="text-center">ประเมิน</th>
              </tr>
            </thead>
            <tbody class="text-nowrap align-middle">
              <?php $date = date("Y-m-d");
              $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl
               FROM  worksheet b 
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
               where b.ws_job_end !='' 
               ORDER BY b.ws_id asc")or die(mysqli_error($conn));
              $i=1;
              while($rs = mysqli_fetch_assoc($sql)){ 
               if(strtotime($rs['ws_assess_date']) >= strtotime(date('Y-m-d')) or $rs['ws_assess_date'] ==''){ ?>

                <tr onclick="window.location.href ='assessment_data.php?id=<?=$rs['ws_id']?>'" >
                  <td><?=$i;?></td>
                  <td><?=$rs['ws_number_id']; ?></td>
                  <td><?=$rs['ws_name'];?></td>
                  <td><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></td>
                  <td><?=$rs['z_name'];?></td>
                  <td><?=$rs['place_name'];?></td>
                  <td><?=$rs['m_sender']?></td>
                  <td><?=$rs['m_name']?></td>
                  <td class="text-center"><?=$rs['ws_assess_status']==""? "-" : $rs['ws_assess_status'];?></td>
                  <td class="text-center">
                    <?php if ($rs['ws_assess_status'] == "") { ?>
                      
                    <?php }else{ ?>
                      <span>ประเมินแล้ว</span>
                    <?php } ?>
                  </td>
                </tr>
                <?php $i++;} } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
    <?php  require_once '../link_js/link_js.php';  ?>
    <script type="text/javascript" src="ajax.js"></script>
    <script type="text/javascript">
      $('.img01').click(function (e) {
        e.preventDefault();
        $(this).ekkoLightbox();
      });


      $(document).ready(function() {
        var table = $('.example').DataTable( {
          lengthChange: true,
          "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
          "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
          }
        });

        table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0) ' );
      });
    </script>

  </body>
  </html>

