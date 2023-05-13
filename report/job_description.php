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
        <h1> <i class="fa fa-home" ></i> รายละเอียดงาน </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>

    <div class="row">
      <?php $date = date("Y-m-d");
      $sql = mysqli_query($conn,"SELECT *,b.ws_id,f.m_name as m_sender,g.m_name as m_name,b.place_id as pl,b.dv_id,f.m_id as sender_id,g.m_id as m_id
       FROM  worksheet b 
       LEFT JOIN zone c 
       on b.z_id = c.z_id 
       LEFT JOIN place d 
       on d.place_id = b.place_id 
       LEFT JOIN  division e 
       on e.dv_id = b.dv_id
       LEFT JOIN member f 
       on f.m_id = b.ws_sender
       LEFT JOIN member g 
       on g.m_id = b.m_id
       LEFT JOIN category h
       on h.c_id = b.c_id
       LEFT JOIN transfer_job i 
       on b.ws_id = i.ws_id 
       where  b.ws_id = '".$_GET['id']."'
       ORDER BY b.ws_id asc")or die(mysqli_error($conn));
      $i=1;
      while($rs = mysqli_fetch_assoc($sql)){ 

        if(strtotime($rs['ws_assess_date']) >= strtotime(date('Y-m-d')) or $rs['ws_assess_date'] ==''){ ?>  
          <div class="col-md-12 p-1">
            <div class="tile"> 
              <div class="col-md-12">
                <h6 class="text-right"><a href="mechanic_work.php" title=""> ย้อนกลับ <i class="fa fa-reply-all"></i></a></h6>
              </div>
              <hr>
              <!--//////////-->
              <div class="row justify-content-end">
                <div class="col-md-9">
                  <!-- <strong class="text-danger">*** รายการจะหายไปหลังจากทำการประเมินแล้ว 1 วัน ***</strong> -->
                </div>
                <div class="col-md-3">
                  <strong>เลขที่ใบงาน <i class="fa fa-angle-double-right"></i> <?=$rs['ws_number_id']; ?></strong>
                </div>
              </div><hr>

              <div class="row justify-content-start">
                <div class="col-md-5">
                  <h5>ชื่อใบงาน : <?=$rs['ws_name'];?> <input type="text" value="<?=$rs['ws_name'];?>" name="ws_name" class="form-control"></h5> 
                </div>
                <div class="col-md-6">
                  <h5> แผนก : <?=$rs['dv_name']." (".$rs['dv_name_short'].")";?>
                  <select name="dv_id" class="form-control">
                    <option value=""> - </option>
                    <?php $sql0 = mysqli_query($conn,"SELECT * FROM division");
                    while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                      <option value="<?=$rs0['dv_id'];?>"<?php if($rs['dv_id']==$rs0['dv_id']){ echo 'SELECTED';} ?>><?=$rs0['dv_name']." (".$rs0['dv_name_short'].")";?></option>
                    <?php } ?>
                  </select></h5> 
                </div>
              </div><hr>
              <div class="row justify-content-start">
                <div class="col-md-5">
                  <strong>(Zone)เขตพื้นที่ : </strong> <?=$rs['z_name']=="" ? " - " : $rs['z_name'];?>
                  <select name="z_id" class="form-control">
                    <option value=""> - </option>
                    <?php $sql0 = mysqli_query($conn,"SELECT * FROM zone order by  z_id desc");
                    while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                      <option value="<?=$rs0['z_id'];?>"<?php if($rs['z_id']==$rs0['z_id']){ echo 'SELECTED';} ?>><?=$rs0['z_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <strong> สถานที่ : </strong><?=$rs['place_name']=="" ? " - " : $rs['place_name'];?>
                  <select name="p_id" class="form-control">
                    <option value=""> - </option>
                    <?php $sql0 = mysqli_query($conn,"SELECT * FROM place");
                    while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                      <option value="<?=$rs0['place_id'];?>"<?php if($rs['place_id']==$rs0['place_id']){ echo 'SELECTED';} ?>><?=$rs0['place_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div><hr>
              <div class="row justify-content-around">
                <div class="col-md-4">
                  <strong>ผู้สร้างใบงาน :</strong> <?=$rs['m_sender']?>
                  <select name="sender_id" class="form-control">
                    <option value=""> - </option>
                    <?php $sql0 = mysqli_query($conn,"SELECT m_id,m_name FROM member");
                    while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                      <option value="<?=$rs0['m_id'];?>"<?php if($rs['sender_id']==$rs0['m_id']){ echo 'SELECTED';} ?>><?=$rs0['m_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                 <strong>ประเภทงาน : </strong><?=$rs['c_name'];?>
                 <select name="c_id" class="form-control">
                  <option value=""> - </option>
                  <?php $sql0 = mysqli_query($conn,"SELECT c_id,c_name FROM category");
                  while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                    <option value="<?=$rs0['c_id'];?>"<?php if($rs['c_id']==$rs0['c_id']){ echo 'SELECTED';} ?>><?=$rs0['c_name'];?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <strong>ช่างดำเนินการ : </strong><?=$rs['m_name']=="" ? "<strong class='text-danger'>คืนงาน</strong>" : $rs['m_name'];?>
                <?php if($rs['m_name']){ ?>
                  <select name="m_id01" class="form-control">
                    <option value=""> - </option>
                    <?php $sql0 = mysqli_query($conn,"SELECT m_id,m_name FROM member");
                    while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                      <option value="<?=$rs0['m_id'];?>"<?php if($rs['m_id']==$rs0['m_id']){ echo 'SELECTED';} ?>><?=$rs0['m_name'];?></option>
                    <?php } }?>
                  </select>
                </div>
              </div><hr>

              <div class="row justify-content-around">
                <div class="col-md-3">
                  <strong> กำหนดเริ่มงาน : </strong> 
                  <div class="input-group date" id="picker1" data-target-input="nearest">
                    <input type="text" name="ws_start_date" value="<?=$rs['ws_start_date'];?>" class="form-control datetimepicker-input" data-target="#picker1" placeholder="กำหนดเริ่มงาน"/>
                    <div class="input-group-append" data-target="#picker1" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <strong>กำหนดงานเสร็จ : </strong>
                  <div class="input-group date" id="picker2" data-target-input="nearest">
                    <input type="text" name="ws_end_date" value="<?=$rs['ws_end_date'];?>" class="form-control datetimepicker-input" data-target="#picker2" placeholder="กำหนดงานเสร็จ"  />
                    <div class="input-group-append" data-target="#picker2" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <strong>ช่างเริ่มงาน : </strong>
                  <div class="input-group date" id="picker3" data-target-input="nearest">
                    <input type="text" name="ws_job_start" value="<?=$rs['ws_job_start'] =="" ? "" : $rs['ws_job_start'];?>" class="form-control datetimepicker-input" data-target="#picker3" placeholder="ช่างเริ่มงาน"  />
                    <div class="input-group-append" data-target="#picker3" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                 <strong>ช่างปิดงาน : </strong>
                 <div class="input-group date" id="picker4" data-target-input="nearest">
                  <input type="text" name="ws_job_end" value="<?=$rs['ws_job_end']=="" ? "" : $rs['ws_job_end'];?>" class="form-control datetimepicker-input" data-target="#picker4" placeholder="ช่างเริ่มงาน"  />
                  <div class="input-group-append" data-target="#picker4" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div><hr>
            <div class="row justify-content-around">
              <div class="col-md-11">
                <strong>รายละเอียดงาน : </strong>
                <textarea name="ws_request" class="form-control" rows="3"><?=$rs['ws_jobdescription'];?></textarea>
              </div>
            </div><hr>
          
            <div class="row justify-content-around">
              <div class="col-md-11">
                <strong for="">รายการงานคงค้าง : </strong>
                <select name="panding_status" class="custom-select">
                  <option value="">-</option>
                  <?php $sql = mysqli_query($conn,"SELECT * FROM pending ");
                  while($rs0 = mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?=$rs0['pd_id']?>" <?php if($rs['panding_status'] == $rs0['pd_id']){ echo "SELECTED"; } ?>><?=$rs0['pd_name']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-11">
                <strong>รายละเอียดงานคงค้าง : </strong><textarea name="panding_note" class="form-control" rows="2"><?=$rs['panding_note'];?></textarea>
              </div>
            </div><hr>
            <div class="row justify-content-around">
              <div class="col-md-11">
                <strong>เหตุผลที่คืนงาน : </strong>
                <?php if($rs['t_reason']){ ?>
                  <textarea name="t_reason" class="form-control" rows="2"><?=$rs['t_reason'];?></textarea>
                <?php }else{ ?>
                 -
                 <textarea name="t_reason" class="form-control" hidden></textarea>
               <?php } ?>
             </div>
           </div><hr>
          <style type="text/css">
            .card-img-top{
              height: 9rem;
              /*object-fit: cover;*/
            }
          </style>
          <div class="row">
            <?php 
            $sql0 = mysqli_query($conn,"SELECT * FROM  image_work WHERE ws_id = '".$rs['ws_id']."' ");
            while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
             <div class="col-md-2 p-2">
              <a href="../../xservice_site2/<?=$rs0['img_name'];?>" 
                data-toggle="img" 
                class="img01"
                data-gallery="<?=$rs0['ws_id'];?>">
                <img src="../../xservice_site2/<?=$rs0['img_name'];?>" class="img-thumbnail card-img-top img-fluid ">
              </a>
            </div>
          <?php } ?>
          <!--data-max-height="auto"-->
        </div><hr>  

        <!---วางรูปภาพ---->
        <?php if ($rs['ws_assess_status'] != "ไม่ผ่าน" and $rs['ws_assess_status']!="") { ?> 
         <div class="row justify-content-end">
          <div class="col-md-2">
            <strong class="text-success">สถานะ : <?=$rs['ws_assess_status']?> <i class="fa fa fa-check fa-lg"></i></strong>
          </div>
        </div>
      <?php }else if($rs['ws_assess_status'] != "ผ่าน" and $rs['ws_assess_status']!=""){ ?>

        <div class="row">
          <div class="col-md-10">
            <strong class="text-danger">เหตุผลที่ไม่ผ่าน :  <?=$rs['ws_assess']?></strong>
          </div>
          <div class="col-md-2">
            <strong class="text-danger">สถานะ : <?=$rs['ws_assess_status']?> <i class="fa fa-times fa-lg"></i></strong>
          </div>
        </div>

      <?php } ?>

      <div class="modal-footer">
        <button type="text" class="btn btn-dark update">ยืนยันการแก้ไข</button>
        <a href="print.php?id=<?=$_GET['id']?>" target="_black" class="btn btn-info">พิมพ์</a>
      </div>

      <!--//////////-->
    </div>
  </div>

<?php } } ?>
</div>
<?php //require_once 'modal.php'; ?>
</main>
<?php  require_once '../link_js/link_js.php';  ?>
<script type="text/javascript">
  $('.img01').click(function (e) {
    e.preventDefault();
    $(this).ekkoLightbox();
  });

  $(function () {
    $('#picker1').datetimepicker({  format: 'L', format: 'YYYY-MM-DD HH:mm'});
    $('#picker2').datetimepicker({
      useCurrent: false,
      format: 'L', 
      format: 'YYYY-MM-DD HH:mm'
    });
    $("#picker1").on("change.datetimepicker", function (e) {
      $('#picker2').datetimepicker('minDate', e.date);
    });
    $("#picker2").on("change.datetimepicker", function (e) {
      $('#picker1').datetimepicker('maxDate', e.date);
    });

    $('#picker3').datetimepicker({  format: 'L', format: 'YYYY-MM-DD HH:mm'});
    $('#picker4').datetimepicker({
      useCurrent: false,
      format: 'L', 
      format: 'YYYY-MM-DD HH:mm'
    });
    $("#picker3").on("change.datetimepicker", function (e) {
      $('#picker4').datetimepicker('minDate', e.date);
    });
    $("#picker4").on("change.datetimepicker", function (e) {
      $('#picker3').datetimepicker('maxDate', e.date);
    });

  });


  $(document).on('click', '.update', function(event) {
    event.preventDefault();
    var ws_id             = "<?=$_GET['id']?>";
    var todu              = "update_report";
    var ws_request        =  document.getElementsByName("ws_request")[0].value;
    var panding_note      =  document.getElementsByName("panding_note")[0].value;
    var t_reason          =  document.getElementsByName("t_reason")[0].value;
    var panding_status    =  document.getElementsByName("panding_status")[0].value;

    var ws_name           =  document.getElementsByName("ws_name")[0].value;
    var dv_id             =  document.getElementsByName("dv_id")[0].value;
    var z_id              =  document.getElementsByName("z_id")[0].value;
    var p_id              =  document.getElementsByName("p_id")[0].value;
    var sender_id         =  document.getElementsByName("sender_id")[0].value;
    var c_id              =  document.getElementsByName("c_id")[0].value;
    var m_id              =  document.getElementsByName("m_id01")[0].value;
    var ws_start_date     =  document.getElementsByName("ws_start_date")[0].value;
    var ws_end_date       =  document.getElementsByName("ws_end_date")[0].value;
    var ws_job_start      =  document.getElementsByName("ws_job_start")[0].value;
    var ws_job_end        =  document.getElementsByName("ws_job_end")[0].value;

    $.ajax({
      url: '../admin/manages.php',
      type: 'POST',
      dataType: 'json',
      data: {'ws_id': ws_id,'ws_request': ws_request, 'panding_note' : panding_note , 't_reason' : t_reason , 'panding_status' : panding_status,'todu':todu,'ws_name':ws_name,'dv_id':dv_id,'z_id':z_id,'p_id':p_id,'sender_id':sender_id,'c_id':c_id,'m_id':m_id,'ws_start_date':ws_start_date,'ws_end_date':ws_end_date,'ws_job_start':ws_job_start,'ws_job_end':ws_job_end},
      success : function(data){
        if(data.data==1){
          window.location.reload();
        }else{
          console.log("faild");
        }

      }
    })    

  }); 
</script>
</body>
</html>


   <!--  <meta http-equiv="refresh"content="0;url=../../xservice_site2/push_noti.php?m_id='.$_POST['m_id'].'&subject=แจ้งเตือนงานใหม่&detail='.$POST_['ws_name'].' "> -->