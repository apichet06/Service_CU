<?php require_once '../db/config.php'; require_once '../menu/datetime_function.php'; ?>
<div class="tile">
  <h5 class="text-center">
    <?php if($_POST['action'] == "ยังไม่เริ่มงาน"){
      echo 'รายการที่ยังไม่เริ่มงาน' ;
    }elseif ($_POST['action'] == "ปิดงานแล้ว"){
      echo 'รายการที่ปิดงานไปแล้ว';
    }elseif ($_POST['action'] == "คืนงาน"){
      echo 'รายการที่คืนงาน';
    }elseif ($_POST['action'] == "sla") {
      echo 'รายการที่ตก SLA';
    }elseif ($_POST['action'] == "pending") {
      echo 'รายงานงานคงค้าง';
    }elseif ($_POST['action'] == "เริ่มงานแล้วยังไม่ปิดงาน") {
      echo 'เริ่มงานแล้วยังไม่ปิดงาน';
    }?></h5><hr>
    <table id="example" class="table table-striped table-bordered table-responsive " style="width:100%">
      <thead class="text-nowrap align-middle">
        <tr>
          <th>No.</th>
          <th>เลขที่ใบงาน</th>
          <th>ชื่อใบงาน</th>
          <th>------ สิ่งที่ให้ดำเนินการ ------</th>
          <th>(Zone)เขตพื้นที่</th>
          <th>ประเภท</th>
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
          <th>สถานะ</th>
          <th>สถานะ SLA</th>
        </tr>
      </thead>
      <tbody class="align-middle">
        <?php  
        if($_POST['action']=="ปิดงานแล้ว"){
         $sql = mysqli_query($conn,"SELECT *,e.m_name as sender ,d.m_name as m_name FROM worksheet a 
          INNER JOIN category b 
          on a.c_id = b.c_id 
          LEFT JOIN place c 
          on c.place_id = a.place_id
          INNER JOIN member d 
          on a.m_id = d.m_id
          INNER JOIN member e 
          on a.ws_sender = e.m_id 
          INNER JOIN division f 
          on a.dv_id = f.dv_id
          LEFT JOIN zone g 
          on a.z_id = g.z_id
          WHERE a.ws_job_end !='' and a.c_id = '".$_POST['c_id']."' and a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') and a.m_id = '".$_POST['m_id']."'
          ORDER BY a.m_id asc"); 

       }else if($_POST['action']=="คืนงาน"){

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
          LEFT JOIN category h 
          on h.c_id = a.c_id 
          WHERE a.m_id ='0' and g.m_id = '".$_POST['m_id']."'  and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."')
          ORDER BY a.ws_id DESC ");

      }else if($_POST['action']=="sla"){
        $date = date("Y-m-d H:i:s");
        $sql = mysqli_query($conn,"SELECT *,b.m_name as m_name,f.m_name as sender,g.ws_id as g_ws_id,a.ws_id as ws_id FROM worksheet a 
          INNER JOIN member b 
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
          LEFT JOIN category h 
          on h.c_id = a.c_id 
          wHERE a.ws_end_date <= '$date' and ISNULL(a.ws_job_end) and a.ws_end_date !='0000-00-00 00:00:00' and a.c_id = '".$_POST['c_id']."' and a.m_id = '".$_POST['m_id']."' and a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') 
          ORDER BY a.ws_id DESC ");

      }else if($_POST['action']=="pending"){

        $sql = mysqli_query($conn,"SELECT *,f.m_name as m_sender,g.m_name as m_name,e.c_name FROM  worksheet a
          INNER JOIN zone b 
          on a.z_id = b.z_id
          LEFT JOIN place c 
          on a.place_id = c.place_id
          INNER JOIN division d 
          on a.dv_id = d.dv_id 
          INNER JOIN category e 
          on a.c_id = e.c_id
          INNER JOIN member f 
          on a.ws_sender = f.m_id
          INNER JOIN member g 
          on a.m_id = g.m_id 
          Where a.panding_note !='' and ISNULL(a.ws_job_end) and a.c_id = '".$_POST['c_id']."' and a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') and a.m_id = '".$_POST['m_id']."'
          ORDER BY a.ws_id DESC")or die(mysqli_error($conn));

      }else if ($_POST['action'] == "ยังไม่เริ่มงาน"){

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
          LEFT JOIN category  h 
          on a.c_id = h.c_id 
          WHERE  ISNULL(a.ws_job_start) AND a.c_id = '".$_POST['c_id']."' and a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') and a.m_id = '".$_POST['m_id']."'
          ORDER BY a.ws_id DESC ");

      }else if($_POST['action'] == "เริ่มงานแล้วยังไม่ปิดงาน"){

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
          LEFT JOIN category  h 
          on a.c_id = h.c_id 
          WHERE  a.ws_job_start != '' AND isnull(a.ws_job_end) AND a.c_id = '".$_POST['c_id']."' and a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') and a.m_id = '".$_POST['m_id']."'
          ORDER BY a.ws_id DESC ");

      }else if($_POST['action'] == ""){

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
          LEFT JOIN category  h 
          on a.c_id = h.c_id
          WHERE a.z_id = '".$_POST['z_id']."' and (date(a.ws_date) >= '".$_POST['date_1']."' and date(a.ws_date) <= '".$_POST['date_2']."') and a.m_id = '".$_POST['m_id']."'
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
       <tr >
        <td class="text-nowrap align-middle"><?=$i;?></td>
        <td class="text-nowrap align-middle">
          <a href="" class="job_description" 
          data-toggle="modal" 
          data-target="#show_date_report"
          data-id = "<?=$rs['ws_id']?>"
          ><?=$rs['ws_number_id']?></a></td>
          <td class="text-nowrap align-middle"><?=$rs['ws_name']?></td>
          <td class="text-nowrap align-middle"><?=$rs['ws_request']?></td>
          <td class="text-nowrap align-middle text-center"><?=$rs['z_name']=="" ? "-" : $rs['z_name']; ?></td>
          <td class="text-nowrap align-middle"><?=$rs['c_name']?></td>
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
          <td class="text-nowrap align-middle">
            <?php  if($rs['ws_id'] === $rs['g_ws_id']){
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
<!-- Modal -->
<div class="modal fade" id="show_date_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">ภาพรวมข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div id="job_description">

       </div>
     </div>
   </div>
 </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#example').DataTable({
      lengthChange: true,
      stateSave: true,
      /*buttons: ['excel' ,'print', 'colvis' ],*/
      buttons: [
      {
        extend: 'excel',
        messageTop: 'รายงานการทำงานของช่าง',
        className: 'btn-sm btn-warning',
        title: ''
      },

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


  $('.job_description').click(function(event) {
    event.preventDefault();
    var id = $(this).data("id");
    $.ajax({
     url: 'job_description.php',
     type: 'GET',
     data: {'id':id},
     success : function(data){
       $('#job_description').html(data);
     }
   })
    

  });

</script>
