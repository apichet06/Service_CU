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
  <?php require_once '../menu/menu.php'; require_once '../menu/datetime_function.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-file-text-o" ></i> ลงเวลางาน </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="tile">
          <form action="work_in_out.php" method="post" accept-charset="utf-8">
            <div class="row">
             <div class="form-group col-md-5 ">
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
            <div class="form-group col-md-2">
              <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search fa-2x"> ค้นหา</i></button>
            </div>  
          </div> 
        </form>   
      </div>
    </div>
  </div>

  <div class="row">
   <div class="col-md-12">
    <div class="tile">
      <h4>รายการเข้า-ออกงาน  : <?=$_POST['date_1']." ถึง ".$_POST['date_2'].$_GET['date'];?></h4>
      <hr>

      <table id="example" class="table table-striped table-bordered table-responsive table-sm ">
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
            <th>ชั่วโมงทำงาน</th>
            <th>ชั่วโมง OT</th>

          </tr>
        </thead>
        <tbody class="text-nowrap align-middle text-center">
          <?php 
          if(strtotime($_POST['date_1'])==strtotime($_POST['date_2'])){

            $sql1 = mysqli_query($conn,"SELECT *,a.m_id FROM member a
              LEFT JOIN job_in_out b 
              ON a.m_id = b.m_id
              GROUP BY a.m_id
              ORDER BY b.date_in_out,a.m_id asc");  

            $i=1;
            while ($rs1 = mysqli_fetch_assoc($sql1)) {

              if($_GET['date']){

                $sql = mysqli_query($conn,"SELECT b.m_name,min(a.date_in_out) as date_in,a.m_id,a.action,a.j_inout_id,a.trans_pic,a.t_note
                  FROM job_in_out a
                  LEFT JOIN member b 
                  on a.m_id = b.m_id
                  WHERE (date(a.date_in_out) BETWEEN '".$_GET['date']."' AND '".$_GET['date']."') and b.m_id = '".$rs1['m_id']."'
                  GROUP BY date(a.date_in_out),a.m_id 
                  ORDER BY a.date_in_out desc")or die(mysqli_error($conn));

              }else{

                $sql = mysqli_query($conn,"SELECT b.m_name,min(a.date_in_out) as date_in,a.m_id,a.action,a.j_inout_id,a.trans_pic,a.t_note
                  FROM job_in_out a
                  right JOIN member b 
                  on a.m_id = b.m_id
                  WHERE (date(a.date_in_out) BETWEEN '".$_POST['date_1']."' AND '".$_POST['date_2']."') and b.m_id = '".$rs1['m_id']."'
                  GROUP BY date(a.date_in_out),a.m_id 
                  ORDER BY a.date_in_out desc")or die(mysqli_error($conn));   
              } 
              $rs = mysqli_fetch_assoc($sql); 



              $date_in  = explode(" ",$rs['date_in']);
              $sql0 = mysqli_query($conn,"SELECT max(date_in_out)as date_out,j_inout_id,trans_pic,t_note FROM job_in_out 
                WHERE action = 'Out' and  date(date_in_out) = '$date_in[0]' and m_id = '".$rs['m_id']."'
                GROUP BY date(date_in_out),m_id")or die(mysqli_error($conn));
              $rs0 = mysqli_fetch_assoc($sql0);
              $date_out  = explode(" ",$rs0['date_out']);

                $j_out = $rs0['j_inout_id']; // id แสดงเพื่อ ส่ง ค่าไปให้แสดง gps

                 $begin = $rs['date_in']; //  วันที่เริ่มนับ
                 $end   = $rs0['date_out']; // วันที่สิ้นสุด

                 if($rs0['date_out']){
                $end=$rs0['date_out']; // วันที่สิ้นสุด
              }else{
                $end=date("Y-m-d H:i:s");
              }

              ?> 
              <tr>
                <td><?=$i;?></td>
                <td>
                  <?=$rs1['m_name']?></td>
                  <td><a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุเข้างาน :"
                    data-t_note  = "<?=$rs['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs['trans_pic']?>"
                    data-id = "<?=$rs['j_inout_id']?>">
                    <?=$rs['action']!='In' ? "" : "<img class='circular--square' src='../../xservice_site2/".$rs['trans_pic']."'>"; ?></a></td>
                    <td>
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุเข้างาน :"
                      data-t_note  = "<?=$rs['t_note']?>"
                      data-img = "../../xservice_site2/<?=$rs['trans_pic']?>"
                      data-id = "<?=$rs['j_inout_id']?>">
                      <?=$rs['action']!='In' ? "" : thai_date(strtotime($date_in[0]));?>
                    </a>
                  </td>
                  <td><a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุเข้างาน :"
                    data-t_note  = "<?=$rs['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs['trans_pic']?>"
                    data-id = "<?=$rs['j_inout_id']?>">
                    <?=$rs['action']!='In' ? "" : $date_in[1];?></a></td>
                    <td><?=$rs['t_note']?></td>
                    <td>
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุออกงาน:"
                      data-t_note  = "<?=$rs0['t_note']?>"
                      data-img = "../../xservice_site2/<?=$rs0['trans_pic']?>"
                      data-id = "<?=$j_out?>">
                      <?php if($rs0['trans_pic']){
                        echo '<img class="circular--square" src="../../xservice_site2/'.$rs0['trans_pic'].'">';
                      }else{
                        echo '-';
                      } ?>
                    </a>
                  </td>
                  <td>
                    <a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุออกงาน:"
                    data-t_note  = "<?=$rs0['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs0['trans_pic']?>"
                    data-id = "<?=$j_out?>">
                    <?=$date_out[0]=="" ? "" : thai_date(strtotime($date_out[0]));?></a>
                  </td>
                  <td>
                    <a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุออกงาน:"
                    data-t_note  = "<?=$rs0['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs0['trans_pic']?>"
                    data-id = "<?=$j_out?>">
                    <?=$date_out[1];?></a>
                  </td>
                  <td><?=$rs0['t_note']?></td>
                  <td><?php if($rs['action']=='In' and  $date_out[0]!='' ){
                    echo duration($begin,$end);
                  }else{
                    echo "-";
                  } ?>

                </td>

                <td>-</td>
                <td>-</td>
              </tr>
              <?php $i++; }

            }else{

              $sql = mysqli_query($conn,"SELECT b.m_name,min(a.date_in_out) as date_in,a.m_id,a.action,a.j_inout_id,a.trans_pic,a.t_note
                FROM job_in_out a
                right JOIN member b 
                on a.m_id = b.m_id
                WHERE date(a.date_in_out) BETWEEN '".$_POST['date_1']."' AND '".$_POST['date_2']."'
                GROUP BY date(a.date_in_out),a.m_id 
                ORDER BY a.date_in_out desc")or die(mysqli_error($conn));   
              $i=1;
              while($rs = mysqli_fetch_assoc($sql)){ 

                $date_in  = explode(" ",$rs['date_in']);

                $sql0 = mysqli_query($conn,"SELECT max(date_in_out)as date_out,j_inout_id,trans_pic,t_note FROM job_in_out 
                  WHERE action = 'Out' and  date(date_in_out) = '$date_in[0]' and m_id = '".$rs['m_id']."'
                  GROUP BY date(date_in_out),m_id
                  ORDER BY date_in_out desc")or die(mysqli_error($conn));
                $rs0 = mysqli_fetch_assoc($sql0);
                $date_out  = explode(" ",$rs0['date_out']);

                $j_out = $rs0['j_inout_id']; // id แสดงเพื่อ ส่ง ค่าไปให้แสดง gps

                 $begin = $rs['date_in']; //  วันที่เริ่มนับ
                 $end   = $rs0['date_out']; // วันที่สิ้นสุด

                 if($rs0['date_out']){
                $end=$rs0['date_out']; // วันที่สิ้นสุด
              }else{
                $end=date("Y-m-d H:i:s");
              }

              ?> 
              <tr>
                <td><?=$i;?></td>
                <td>
                  <?=$rs['m_name']?></td>
                  <td><a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุเข้างาน :"
                    data-t_note  = "<?=$rs['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs['trans_pic']?>"
                    data-id = "<?=$rs['j_inout_id']?>">
                    <?=$rs['action']!='In' ? "" : "<img class='circular--square' src='../../xservice_site2/".$rs['trans_pic']."'>"; ?></a></td>
                    <td>
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุเข้างาน :"
                      data-t_note  = "<?=$rs['t_note']?>"
                      data-img = "../../xservice_site2/<?=$rs['trans_pic']?>"
                      data-id = "<?=$rs['j_inout_id']?>">
                      <?=$rs['action']!='In' ? "" : thai_date(strtotime($date_in[0]));?>
                    </a>
                  </td>
                  <td><a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุเข้างาน :"
                    data-t_note  = "<?=$rs['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs['trans_pic']?>"
                    data-id = "<?=$rs['j_inout_id']?>">
                    <?=$rs['action']!='In' ? "" : $date_in[1];?></a></td>
                    <td><?=$rs['t_note']?></td>
                    <td>
                      <a href="#" class="gps"
                      data-toggle="modal"
                      data-target="#gps"
                      data-nn = "หมายเหตุออกงาน:"
                      data-t_note  = "<?=$rs0['t_note']?>"
                      data-img = "../../xservice_site2/<?=$rs0['trans_pic']?>"
                      data-id = "<?=$j_out?>">
                      <?php if($rs0['trans_pic']){
                        echo '<img class="circular--square" src="../../xservice_site2/'.$rs0['trans_pic'].'">';
                      }else{
                        echo '-';
                      } ?>
                    </a>
                  </td>
                  <td>
                    <a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุออกงาน:"
                    data-t_note  = "<?=$rs0['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs0['trans_pic']?>"
                    data-id = "<?=$j_out?>">
                    <?=$date_out[0]=="" ? "" : thai_date(strtotime($date_out[0]));?></a>
                  </td>
                  <td>
                    <a href="#" class="gps"
                    data-toggle="modal"
                    data-target="#gps"
                    data-nn = "หมายเหตุออกงาน:"
                    data-t_note  = "<?=$rs0['t_note']?>"
                    data-img = "../../xservice_site2/<?=$rs0['trans_pic']?>"
                    data-id = "<?=$j_out?>">
                    <?=$date_out[1];?></a>
                  </td>
                  <td><?=$rs0['t_note']?></td>
                  <td><?php if($rs['action']=='In' and  $date_out[0]!='' ){
                    echo duration($begin,$end);
                  }else{
                    echo "-";
                  } ?>

                </td>

                <td>-</td>
                <td>-</td>
              </tr>
              <?php $i++; } 
            } ?>

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
          <h5 class="modal-title" id="exampleModalLongTitle">พิกัด GPS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <img src="" class="img-thumbnail" id="img">
            </div>
            <div class="col-md-8" id="gps_show">
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

  <?php
  function duration($begin,$end){
    $remain=intval(strtotime($end)-strtotime($begin));
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

<!--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIZHyafwGyQUKJCyBK1jgHd1VqGQ8fnr4&callback=init_map" async defer></script> -->
<script type="text/javascript">

 $('.gps').click(function(event) {
   event.preventDefault();
   var id = $(this).data('id'); 
   var img =$(this).data('img');
   var nn = $(this).data('nn');
   var t_note = $(this).data('t_note'); 
     //console.log(t_note);
     $("#id").val(id);
     $("#img").attr('src',img);
     $("#nn").text(nn);
     $("#t_note").val(t_note);

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
   $.ajax({
     url: 'manages_note.php',
     type: 'POST',
     dataType: 'json',
     data: $(this).serialize(),
     success : function(data){ 
      console.log(data);

      if(data.data=="1"){

        $('#gps').hide();

        setTimeout(function(){
          window.location.reload();
        },300)
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

date(a.date_in_out) >= '".$_POST['date_1']."' AND date(a.date_in_out) <= '".$_POST['date_2']."' and b.m_id = '".$rs1['m_id']."'
  $(document).ready(function() {
    var table = $('#example').DataTable( {
      lengthChange: true,
      /*buttons: ['excel' ,'print', 'colvis' ],*/
      buttons: [
      {
        extend: 'excel',
        messageTop: 'รายงานเข้า-ออกงาน',
        className: 'btn-sm btn-warning'
      },
      /*{ extend: 'print', className: 'btn-sm btn-info' },*/
      { extend: 'colvis', className: 'btn-sm btn-secondary' }
      ],
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