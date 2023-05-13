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
        <h1><i class="fa fa-home" ></i> การส่งมอบงานช่าง </h1>
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
        <h4>สร้างใบงานมอบหมายงานช่าง แผนก <?="(".$short.")";?></h4>
        <hr>
        <form name="insert_worksheet" id="insert_worksheet" method="post">
          <div class="row">
            <div class="col-md-6 "><!--ส่วนของการเพิ่มรายละเอียด-->    
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="inputState">ชื่อใบงาน</label>
                  <input type="text" class="form-control" name="ws_name" placeholder="ชื่อใบงาน ,อาการอุปกรณ์เสียที่ต้องการการซ่อม" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">ประเภทงาน</label>
                  <select name="c_id" class="form-control" required>
                    <option value="">--- ประเภทงาน ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM category"); 
                    while($rs = mysqli_fetch_assoc($sql)){ ?>
                      <option value="<?=$rs['c_id']?>"><?=$rs['c_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputAddress">รายละเอียดงาน</label>
                  <textarea type="text" class="form-control" name="ws_request" placeholder="รายละเอียดงาน" rows="6" required></textarea>
                </div>

              </div>
            </div>
            <div class="col-md-6"><!--ส่วนของการกำหนดเวลา--> 
              <div class="row">  
                <div class="form-group col-md-12" >
                  <label for="inputAddress">Zone(เขตพื้นที่)</label>
                  <select name="z_id" id="z_id" class="form-control" required>
                    <option value="">--- เลือกภูมิภาค ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM zone order by z_id desc");
                    while ($rs= mysqli_fetch_assoc($sql)) { ?>
                      <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-6" >
                  <label >เลือกสถานที่</label>
                  <select name="place_id" id="place_id" class="form-control" required>
                    <option value="">----- เลือกสถานที่ -----</option> 
                  </select><span id="reload_p"></span>
                </div>

                <div class="form-group col-md-6" >
                  <label >รายชื่อช่างในเขตพื้นที่</label>
                  <select name="m_id" id="m_id" class="form-control" required>
                    <option value="">---- รายชื่อช่างในเขตพื้นที่ ----</option>
                  </select><span id="reload_m"></span>
                </div>

                
                <div class="form-group col-md-12 ">
                  <div class="row text-center">
                    <div class="col-md-4">
                      <button type="button" class="btn btn-sm btn-info " id="show_date1">กำหนดวันเวลา</button>
                    </div>
                    <div class="col-md-4">
                      <button type="button" class="btn btn-sm btn-info " id="show_date2">กำหนดชั่วโมง</button>
                    </div>
                    <div class="col-md-4">
                      <button type="button" class="btn btn-sm btn-info " id="show_date3">เฉพาะวันเริ่มงาน</button>
                    </div>

                  </div>
                </div>
                <div class=" col-md-6 ">
                  <div class="input-group date" id="datetimepicker7" data-target-input="nearest"
                  style="display: visible;">
                  <input type="text" name="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker7" placeholder="กำหนดเวลาเริ่มงาน" required id="disabled1"/>
                  <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class=" col-md-6">
                <div class="input-group date" id="datetimepicker8" data-target-input="nearest"
                style="display: visible;">
                <input type="text" name="ws_end_date" class="form-control datetimepicker-input" data-target="#datetimepicker8" placeholder="กำหนดเวลาที่ต้องการให้งานเสร็จ" required id="disabled2" />
                <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>
            <div class="col-md-6 ">
              <div class="input-group date" id="datetimepicker1" data-target-input="nearest"
              style="display: none;">
              <input type="text" name="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker1" placeholder="กำหนดเวลาเริ่มงาน" required id="disabled3"/>
              <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <select name="ws_end_date_hour"  class="form-control " id="disabled4" style="display: none;" required>
              <option value="">--- กำหนดชั่วโมง ---</option>
              <?php for ($i=1; $i <= 100 ; $i++) { ?>
                <option value="<?=$i;?>"><?=$i;?> ชั่วโมง</option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-12">
            <div class="input-group date" id="datetimepicker2" data-target-input="nearest" 
            style="display: none;">
            <input type="text" name="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker2" placeholder="กำหนดเวลาเริ่มงาน" required id="disabled5"  />
            <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>
        </div>


      </div>
    </div> 
  </div>
  <div class="modal-footer"> 
    <button type="reset" class="btn btn-secondary">ล้าง</button>
    <button type="submit" class="btn btn-primary">ยืนยัน</button>
  </div>          
</form>
</div>
</div>


<div class="col-md-12">
  <div class="tile">
    <form   method="post" accept-charset="utf-8"> 
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="input-group date" id="datetimepicker11" data-target-input="nearest" >
          <input type="text" name="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker11" placeholder="เวลาเริ่มงาน"  />
          <div class="input-group-append" data-target="#datetimepicker11" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
      </div>
      <div class="col-md-1">
        <button type="submit" class="btn btn-info ">ค้นหา</button>
      </div> 

    </div>  
  </form>
  <table class="table table-bordered table-responsive table-sm" id="data_table" >
    <thead class="text-nowrap align-middle">
      <tr> 
        <th>#</th>
        <th>เลขที่สร้างใบงาน</th>
        <th> ---- ชื่อใบงาน ---- </th>
        <th> ----- รายละเอียด ----- </th>
        <th>ประเภทงาน </th>
        <th>Zone(เขตพื้นที่)</th>
        <th> ---- สถานที่ ---- </th>
        <th>ผู้สร้างใบงาน</th>
        <th>--- ช่างที่ถูกมอบหมายงาน ---</th>
        <th>เวลาเริ่มงาน</th>
        <th>เวลาที่งานต้องเสร็จ</th>
        <th>เวลาสร้างใบงาน</th>
        <th>--- การจัดการ ---</th>
      </tr>
    </thead>
    <tbody>
      <?php 
    
      $sql = mysqli_query($conn,"SELECT *,d.m_name as name_user,f.m_name as name_admin,a.m_id  FROM worksheet a 
        LEFT JOIN zone b 
        on a.z_id = b.z_id
        LEFT JOIN place c 
        on c.place_id = a.place_id
        LEFT JOIN member d
        on d.m_id = a.m_id
        INNER JOIN category e
        on e.c_id = a.c_id 
        LEFT JOIN member f
        on a.ws_sender = f.m_id
        Where a.ws_start_date LIKE '%".$_POST['ws_start_date']."%'
        order by a.ws_id desc")or die(mysqli_error($conn));
      $i=1;
      while($rs = mysqli_fetch_assoc($sql)){ ?>
        <tr>
          <td class="text-nowrap"><?=$i;?></td>
          <td class="text-nowrap"><a href="job_description.php?id=<?=$rs['ws_id']?>"><?=$rs['ws_number_id']?></a></td>
          <td class="text-nowrap"><?=$rs['ws_name']?></td>
          <td><?=$rs['ws_request']?></td>
          <td class="text-nowrap "><?=$rs['c_name']?></td>
          <td class="text-nowrap"><?=$rs['z_name']?></td>
          <td class="text-center"><?=$rs['place_name']=="" ? "-" : $rs['place_name']?></td>
          <td class="text-nowrap ">คุณ<?=$rs['name_admin']?></td>
          <td><?=$rs['name_user'] =="" ? "<strong class='text-danger'>ช่างคืนงาน</strong>" : "คุณ".$rs['name_user']; ?></td>
          <td><?=$rs['ws_start_date']?></td>
          <td><?=$rs['ws_end_date']?></td>
          <td><?=$rs['ws_date']?></td>
          <td class="text-center">
            <button type="button" 
            class="btn btn-warning btn-sm edit_work"
            data-ws_id = "<?=$rs['ws_id']?>"
            data-ws_name = "<?=$rs['ws_name']?>"
            data-c_id = "<?=$rs['c_id']?>"
            data-ws_request = "<?=$rs['ws_request']?>"
            data-z_id = "<?=$rs['z_id']?>"
            data-place_id = "<?=$rs['place_id']?>"
            data-m_id = "<?=$rs['m_id']?>"
            data-ws_start_date ="<?=$rs['ws_start_date']?>"
            data-ws_end_date = "<?=$rs['ws_end_date']?>"
            data-toggle="modal"
            data-target="#edit_work">แก้ไข</button>||
            <button type="button" class="btn btn-danger btn-sm del_ws"
            data-id = "<?=$rs['ws_id']?>"
            >ลบ</button> 
          </td>
        </tr>    
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>
</div>

</div>
<?php require_once 'modal.php';  ?>
</main>
<?php require_once '../link_js/link_js.php'; ?>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    document.getElementById("disabled3").disabled = true;
    document.getElementById("disabled4").disabled = true;
    document.getElementById("disabled5").disabled = true;
  });
  $("#show_date1").click(function() {
    $('#datetimepicker7').attr('style', 'display:visible');
    $('#datetimepicker8').attr('style', 'display:visible');
    $('#datetimepicker1').attr('style', 'display:none');
    $('#disabled4').attr('style', 'display:none');
    $('#datetimepicker2').attr('style','display:none');
    document.getElementById("disabled1").disabled = false;
    document.getElementById("disabled2").disabled = false;
    document.getElementById("disabled3").disabled = true;
    document.getElementById("disabled4").disabled = true;
    document.getElementById("disabled5").disabled = true;
  });


  $("#show_date2").click(function() {
    $('#datetimepicker7').attr('style', 'display:none');
    $('#datetimepicker8').attr('style', 'display:none');
    $('#datetimepicker1').attr('style', 'display:visible');
    $('#disabled4').attr('style', 'display:visible');
    $('#datetimepicker2').attr('style','display:none');
    document.getElementById("disabled1").disabled = true;
    document.getElementById("disabled2").disabled = true;
    document.getElementById("disabled3").disabled = false;
    document.getElementById("disabled4").disabled = false;
    document.getElementById("disabled5").disabled = true;
  });

  $("#show_date3").click(function() {
    $('#datetimepicker7').attr('style', 'display:none');
    $('#datetimepicker8').attr('style', 'display:none');
    $('#datetimepicker1').attr('style', 'display:none');
    $('#disabled4').attr('style', 'display:none');
    $('#datetimepicker2').attr('style','display:visible');
    document.getElementById("disabled1").disabled = true;
    document.getElementById("disabled2").disabled = true;
    document.getElementById("disabled3").disabled = true;
    document.getElementById("disabled4").disabled = true;
    document.getElementById("disabled5").disabled = false;
  });



  $(document).ready(function() {
   $('#m_id,#place_id').select2();
   $('#data_table').DataTable({
    lengthChange: true,
    buttons: ['excel' ,'print', 'colvis' ],
    "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
    "drawCallback": function () {
      $('.dataTables_paginate > .pagination').addClass('pagination-sm');

    }

  });
 });
  //function จัดการเวลา ***
  $(function () {

    $('#datetimepicker7,#datetimepicker9,#datetimepicker1,#datetimepicker2').datetimepicker({  format: 'L', format: 'YYYY-MM-DD HH:mm'});
    $('#datetimepicker8,#datetimepicker10').datetimepicker({
      useCurrent: false,
      format: 'L', 
      format: 'YYYY-MM-DD HH:mm'
    });
    $('#datetimepicker7,#datetimepicker1,#datetimepicker2').on("change.datetimepicker", function (e) {
     $('#datetimepicker8').datetimepicker('minDate', e.date);
   });
    $('#datetimepicker8').on("change.datetimepicker", function (e) {
     $('#datetimepicker7,#datetimepicker1,#datetimepicker2').datetimepicker('maxDate', e.date);
   });
  });

  $('#datetimepicker11').datetimepicker({  format: 'L', format: 'YYYY-MM-DD'});

</script>

</body>
</html>


<!-- http://cloudwork.cloud/xservice_site2/push_noti.php?m_id=51&subject=test&detail=testtest -->