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
        <h1><i class="fa fa-home" ></i> การตั้งค่าระบบ </h1>
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
        <h4>การตั้งค่าระบบ</h4>
        <hr>
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">จัดการสถานที่</a>
            <a class="nav-item nav-link" id="nav-member-tab" data-toggle="tab" href="#nav-member" role="tab" aria-controls="nav-member" aria-selected="false">จัดการสมาชิก</a>
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">จัดการแผนก</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">ประเภทผู้ใช้งาน</a>
            <a class="nav-item nav-link" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="false">ประเภทงานคงค้าง</a>
            <a class="nav-item nav-link" id="nav-type-tab" data-toggle="tab" href="#nav-type" role="tab" aria-controls="nav-type" aria-selected="false">ประเภทงาน</a>
            <a class="nav-item nav-link" id="nav-zone-tab" data-toggle="tab" href="#nav-zone" role="tab" aria-controls="nav-zone" aria-selected="false">จัดการโซนพื้นที่</a>
            <a class="nav-item nav-link" id="nav-setting-tab" data-toggle="tab" href="#nav-setting" role="tab" aria-controls="nav-setting" aria-selected="false">ตั้งค่าระบบ</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <form id="insert-division" name="division" method="post">
              <div class="form-row justify-content-center"> 
                <div class="form-group col-md-4 p-2">
                  <label for="exampleInputEmail1">ชื่อแผนก</label>
                  <input type="text" class="form-control" name="dv_name" placeholder="ชื่อแผนก" required>
                </div>
                <div class="form-group col-md-4 p-2">
                  <label for="exampleInputPassword1">ชื่อย่อแผนก</label>
                  <input type="text" class="form-control" name="dv_name_short" placeholder="ชื่อย่อแผนก" required>
                </div>
              </div>
              <div class="modal-footer">  
                <button type="submit" class="btn btn-success">บันทึก</button>
              </div>
            </form>

            <hr>
            <div class="row justify-content-center">
              <div class="col-md-5">
                <table  class="table table-bordered table-sm">
                  <thead class="text-nowrap align-middle thead-dark">
                    <tr>
                      <th>ลำดับ</th>
                      <th>ชื่อแผนก</th>
                      <th>ชื่อย่อแผนก</th>
                      <th  class="text-center">จัดการ</th>
                    </tr>
                  </thead>
                  <?php $sql = mysqli_query($conn,"SELECT * FROM division")or die(mysqli_error($conn));
                  $i=1;
                  while($rs = mysqli_fetch_assoc($sql)) { ?>
                    <tbody>
                      <tr>
                        <td><?=$i;?></td>
                        <td><?=$rs['dv_name']?></td>
                        <td><?=$rs['dv_name_short']?></td>
                        <td  class="text-center">
                          <button type="button" class="btn btn-warning btn-sm update_division" 
                          data-id = "<?=$rs['dv_id']?>"
                          data-dv_name = "<?=$rs['dv_name']?>"
                          data-dv_name_short = "<?=$rs['dv_name_short']?>"
                          data-toggle = "modal"
                          data-target ="#update_division"
                          >แก้ไข</button>
                          ||
                          <button type="button" class="btn btn-danger btn-sm del_division" 
                          data-id = "<?=$rs['dv_id']?>"
                          >ลบ</button>
                        </td>
                      </tr>
                    </tbody> 
                    <?php $i++;} ?>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <form id="insert-position" name="position" method="post">
                <div class="form-row justify-content-center"> 
                  <div class="form-group col-md-4 p-2">
                    <label>ชื่อประเภท</label>
                    <input type="text" class="form-control" name="p_name" placeholder="ชื่อประเภท" required>
                  </div>
                  <div class="form-group col-md-4 p-2">
                    <label>ชื่อย่อประเภท</label>
                    <input type="text" class="form-control" name="p_hort" placeholder="ตัวย่อประเภท" required>
                  </div>
                </div>

                <hr> <h4>สิทธิ์เข้าใช้งานเมนู</h4>
                <div class="row">
                 <div class="col-md-2">
                   <div class="animated-checkbox">
                    <label>
                      <input type="checkbox" name="home" value="1"><span class="label-text">หน้าหลัก</span>
                    </label>
                  </div>
                </div> 
                <div class="col-md-2">
                 <div class="animated-checkbox">
                  <label>
                    <input type="checkbox" name="worksheet" value="1"><span class="label-text">สร้างใบงานใหม่</span>
                  </label>
                </div>
              </div>
              <div class="col-md-2">
               <div class="animated-checkbox">
                <label>
                  <input type="checkbox" name="assessment" value="1"><span class="label-text">รอตรวจสอบ</span>
                </label>
              </div>
            </div>
            <div class="col-md-2">
             <div class="animated-checkbox">
              <label>
                <input type="checkbox" name="work_transfer" value="1"><span class="label-text">คืนงาน</span>
              </label>
            </div>
          </div>
          <div class="col-md-2">
           <div class="animated-checkbox">
            <label>
              <input type="checkbox" name="mechanic_work" value="1"><span class="label-text">งานทั้งหมด</span>
            </label>
          </div>
        </div>
        <div class="col-md-2">
         <div class="animated-checkbox">
          <label>
            <input type="checkbox" name="work_in_out" value="1"><span class="label-text">ลงเวลางาน</span>
          </label>
        </div>
      </div>
      <div class="col-md-2">
       <div class="animated-checkbox">
        <label>
          <input type="checkbox" name="charts" value="1"><span class="label-text">Charts</span>
        </label>
      </div>
    </div>
    <div class="col-md-2">
     <div class="animated-checkbox">
      <label>
        <input type="checkbox" name="manages" value="1"><span class="label-text">ตั้งค่าระบบ</span>
      </label>
    </div>
  </div>

</div>
<div class="modal-footer">  
  <button type="submit" class="btn btn-primary">บันทึก</button>
</div>
</form>
<hr>

<div class="row justify-content-center">
  <div class="col-md-8">
    <table class="table table-bordered table-sm" >
      <thead class="text-nowrap align-middle thead-dark">
        <tr>
          <th>ลำดับ</th>
          <th>ชื่อประเภท</th>
          <th>ชื่อย่อประเภท</th>
          <th>สิทธิ์เข้าใช้งานเมนู</th>
          <th class="text-center">จัดการ</th>
        </tr>
      </thead>
      <?php $sql = mysqli_query($conn,"SELECT *,a.p_id FROM position a 
        LEFT JOIN practicability b 
        ON a.p_id = b.p_id 
        ORDER BY a.p_id asc"); 
      $i=1;
      while ($rs = mysqli_fetch_assoc($sql)) {   
        ?>
        <tbody>
          <tr>
            <td><?=$i;?></td>
            <td><?=$rs['p_name']?></td>
            <td><?=$rs['p_hort']?></td>
            <td><?php 
              echo $rs['home']=="" ? "" : "หน้าหลัก ";
              echo $rs['worksheet']=="" ? "" : "สร้างใบงานใหม่ ";
              echo $rs['assessment']=="" ? "" : "รอตรวจสอบ ";
              echo $rs['work_transfer']=="" ? "" : "คืนงาน ";
              echo $rs['mechanic_work']=="" ? "" : "งานทั้งหมด ";
              echo $rs['work_in_out']=="" ? "" : "ลงเวลางาน ";
              echo $rs['charts']=="" ? "" : "Charts ";
              echo $rs['manages']=="" ? "" : "ตั้งค่าระบบ ";
            ?></td>
            <td  class="text-center"><button type="button" 
              class="btn btn-warning btn-sm update_position"
              data-p_id = "<?=$rs['p_id']?>"
              data-p_name = "<?=$rs['p_name']?>"
              data-p_hort = "<?=$rs['p_hort']?>"
              data-home ="<?=$rs['home']?>"
              data-worksheet ="<?=$rs['worksheet']?>"
              data-assessment ="<?=$rs['assessment']?>"
              data-work_transfer ="<?=$rs['work_transfer']?>"
              data-mechanic_work ="<?=$rs['mechanic_work']?>"
              data-work_in_out ="<?=$rs['work_in_out']?>"
              data-charts ="<?=$rs['charts']?>"
              data-manages = "<?=$rs['manages']?>"
              data-target ="#update_position"
              data-toggle ="modal"
              >แก้ไข</button>
              ||
              <button type="button" class="btn btn-danger btn-sm del_position" 
              data-p_id = "<?=$rs['p_id']?>"
              >ลบ</button>
            </td>
          </tr>
        </tbody>
        <?php $i++;} ?>
      </table>
    </div>
  </div>

</div><!--จบรายการตำแหน่งงาน-->


<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
  <br>
  <form id="place" name="place" method="POST">
    <div class="form-row">
      <div class="col-md-4">
        <label>โซนพื้นที่</label>
        <select  class="form-control" name="z_id" required>
          <option value="">--- เลือกโซนพื้นที่ ---</option>
          <?php $sql = mysqli_query ($conn,"SELECT * FROM zone ");
          while ($rs = mysqli_fetch_assoc($sql)) { ?>
            <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-8">
       <label>สถานที่</label>
       <input type="text" class="form-control" name="place_name" placeholder="ชื่อสถานที่" required>
     </div>
   </div>
   <div class="modal-footer">
    <button type="submit" class="btn btn-info">บันทึก</button>
  </div>
</form>
<hr>
<div class="row justify-content-center">
  <div class="col-md-10">
    <table class="table table-bordered table-responsive-sm table-responsive-lg table-sm" id="data_position">
      <thead class="text-nowrap align-middle thead-dark">
        <tr>
          <th class="text-center">#</th>
          <th>ภูมิภาค</th>
          <th>สถานที่</th>
          <th>วันที่</th>
          <th class="text-center">จัดการ</th>
        </tr>
      </thead> 
      <tbody class="text-nowrap align-middle">   
        <?php $sql =mysqli_query($conn,"SELECT * FROM place as a
          LEFT JOIN zone as b 
          on a.z_id = b.z_id
          ORDER BY a.z_id")or die(mysqli_error($conn));
        $i=1;

        while ($rs = mysqli_fetch_assoc($sql)){?>
          <tr>
            <td class="text-center"><?=$i;?></td>
            <td><?=$rs['z_name']?></td>
            <td><?=$rs['place_name']?></td>
            <td><?=$rs['place_date']?></td>
            <td  class="text-center"><button type="button" 
              class="btn btn-warning btn-sm update_place"
              data-place_id ="<?=$rs['place_id']?>"
              data-z_id ="<?=$rs['z_id']?>"
              data-place_name ="<?=$rs['place_name']?>"
              data-toggle ="modal"
              data-target ="#update_place"
              >แก้ไข</button> ||
              <button type="button"
              class="btn btn-danger del_place btn-sm"
              data-place_id ="<?=$rs['place_id']?>"
              >ลบ</button>
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<div class="tab-pane fade" id="nav-member" role="tabpanel" aria-labelledby="nav-member-tab">
  <hr>
  <form action="" id="insert-mamber" name="insert-member" method="post" accept-charset="utf-8">
    <div class="row">
      <div class="col-md-12">
        <div id="myAlert" class="alert alert-danger alert-dismissible  collapse" role="alert">
          <strong>แจ้งเตือน!</strong> ชื่อ-สกุลหรือชื่อล็อกอินซ้ำ กรุณาตรวจเช็คอีกครั้ง!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="form-group col-md-3">
            <label for="inputAddress">ชื่อ</label>
            <input type="text" class="form-control" name="m_name" placeholder="ชื่อ" required>
          </div>
          <div class="form-group col-md-3">
            <label for="inputPassword4">สกุล</label>
            <input type="text" class="form-control" name="m_lname" placeholder="สกุล" required>
          </div>
          <div class="form-group col-md-3">
            <label for="inputCity">เบอร์โทร</label>
            <input type="text" class="form-control" name="m_phone" maxlength="10" placeholder="เบอร์โทร" >
          </div>
          <div class="form-group col-md-3">
            <label>e-mail</label>
            <input type="email" name="email" class="form-control" placeholder="e-mail">
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">แผนก</label>
            <select name="dv_id" class="form-control" required>
              <option value="">---- เลือกแผนก ----</option>
              <?php $sql = mysqli_query($conn,"SELECT * FROM division "); 
              while ($rs = mysqli_fetch_assoc($sql)) { ?>
                <option value="<?=$rs['dv_id']?>"><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">โซนพื้นที่</label>
            <select name="z_idx[]" class="form-control " id="demoSelect" style="width: 100%"  multiple >
              <option value="">--- เลือกโซนพื้นที่ ---</option>
              <?php $sql = mysqli_query($conn,"SELECT * FROM zone "); 
              while ($rs = mysqli_fetch_assoc($sql)) { ?>
                <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="inputCity">ชื่อล็อกอิน/รหัสพนักงาน</label>
            <input type="text" class="form-control" name="username" placeholder="ชื่อล็อกอิน/รหัสพนักงาน" required>
          </div>
          <div class="form-group col-md-3">
            <label>รหัสผ่าน</label>
            <input type="text" name="password" class="form-control" placeholder="รหัสผ่าน" required>
          </div>
          <div class="form-group col-md-3">
            <label for="inputCity">ประเภทผู้ใช้งาน</label>
            <select name="p_id" class="form-control" required>
              <option value="">--- เลือก ---</option>
              <?php $sql = mysqli_query($conn,"SELECT * FROM position "); 
              while ($rs = mysqli_fetch_assoc($sql)) { ?>
                <option value="<?=$rs['p_id']?>"><?=$rs['p_name']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">กำหนดถ่ายภาพลงเวลาเข้างาน</label>
            <select name="photograph" class="form-control "  >
              <option value="">---- กำหนด ----</option>
              <option value="1">ต้องถ่ายรุป</option>
              <option value="0">ไม่ต้องถ่ายรุป</option>
            </select> 
          </div>
        </div>
      </div> 
    </div>
    <hr>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h4>กำหนดวันและเวลาทำงาน</h4>
        <table class="table table-sm table-responsive-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>วันทำงาน</th>
              <th>เวลาเริ่ม</th>
              <th>เวลาสิ้นสุด</th>
            </tr>
          </thead>
          <tbody>
            <?php $sql = mysqli_query($conn,"SELECT * FROM  working_day "); 
            $i=1;
            while ($rs= mysqli_fetch_assoc($sql)) { ?>
              <tr>
                <td><?=$i;?>. </td>
                <td><?=$rs['wd_name']?></td>
                <td><select name="work_start[]" class="form-control form-control-sm">
                  <option value="">--- เวลาเริ่ม ---</option>
                  <?php $sql0 = mysqli_query($conn,"SELECT * FROM attend_work"); 
                  while ($rs0 = mysqli_fetch_assoc($sql0)) {?>
                    <option value="<?=$rs0['at_attend']?>"><?=$rs0['at_attend']?></option>
                  <?php } ?>
                </select></td>
                <td><select name="work_end[]" class="form-control form-control-sm">
                  <option value="">--- เวลาสิ้นสุด ---</option>
                  <?php $sql0 = mysqli_query($conn,"SELECT * FROM attend_work"); 
                  while ($rs0 = mysqli_fetch_assoc($sql0)) { ?>
                    <option value="<?=$rs0['at_finish']?>"><?=$rs0['at_finish']?></option>
                  <?php } ?>
                </select></td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
       <button type="submit" class="btn btn-primary">ยืนยัน</button>
     </div>
   </form>
   <hr>
   <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-hover table-responsive table-sm" id="data_member">
        <thead class="text-nowrap align-middle thead-dark">
          <tr>
            <th>#</th>
            <th>ชื่อสกุล</th>
            <th>แผนก</th>
            <th>เบอร์โทร</th>
            <th class="text-nowrap align-middle">รับผิดชอบ ประจำภูมิภาค</th>
            <th class="text-nowrap align-middle">ชื่อล็อกอิน</th>
            <th class="text-nowrap align-middle">รหัสผ่าน</th>
            <th>ตำแหน่ง</th>
            <th class="text-nowrap align-middle">E-Mail</th>
            <th class="text-nowrap align-middle">ดูวันเข้างาน/แก้ไข</th>
            <th class="text-nowrap align-middle">กำหนดถ่ายภาพลงเวลา</th>
            <th class="text-center">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php $sql = mysqli_query($conn,"SELECT *,a.m_id FROM member a
            LEFT JOIN position c 
            on a.p_id = c.p_id
            LEFT JOIN division d 
            on a.dv_id = d.dv_id
            LEFT JOIN area_zone e
            on a.m_id = e.m_id
            LEFT JOIN zone f 
            on e.z_id = f.z_id
            group by a.m_id
            ORDER BY a.m_id desc");
          $oldid="";
          $i=1;
          while ($rs = mysqli_fetch_assoc($sql)) { 
            $user = explode(' ',$rs['m_name']);
            ?>
            <tr>
              <td><?=$i;?></td>
              <td class="text-nowrap align-middle"><?=$rs['m_name'];?></td>
              <td class="text-nowrap align-middle"><?=$rs['dv_name']." (".$rs['dv_name_short'].")"?></td>
              <td class="text-nowrap align-middle"><?=$rs['m_phone']?></td>
              <td class="text-nowrap align-middle">
                <?php $sql0 =mysqli_query($conn,"SELECT * FROM area_zone a 
                  INNER JOIN zone b 
                  on a.z_id = b.z_id
                  Where m_id = '".$rs['m_id']."' ");
                while($rs0=mysqli_fetch_assoc($sql0)){
                 echo $rs0['z_name']." &nbsp; ";
               }
               ?>
             </td>
             <td class="text-nowrap align-middle"><?=$rs['username'];?></td>
             <td class="text-nowrap align-middle"><?=$rs['password'];?></td>
             <td class="text-nowrap align-middle"><?=$rs['p_name']?></td>
             <td class="text-nowrap align-middle"><?=$rs['email']?></td>
             <td class="text-nowrap align-middle">
              <a href="#" class="working_day"
              data-m_id = "<?=$rs['m_id']?>"
              data-target= "#working_day"
              data-toggle= "modal"
              >ดูวันเข้างาน</a></td>
              <td class="text-nowrap align-middle"><?=$rs['photograph']?></td>
              <td class="align-middle text-nowrap text-center">
                <button type="button" class="btn btn-warning btn-sm c_up_member"
                data-m_id = "<?=$rs['m_id']?>"
                data-m_name = "<?=$user[0];?>"
                data-m_lname = "<?=$user[1].' '.$user[2].' '.$user[3];?>"
                data-m_phone = "<?=$rs['m_phone']?>"
                data-z_id = "<?=$rs['z_id']?>"
                data-p_id = "<?=$rs['p_id']?>"
                data-dv_id = "<?=$rs['dv_id']?>"
                data-username ="<?=$rs['username']?>"
                data-pass = "<?=$rs['password']?>"
                data-email ="<?=$rs['email']?>"
                data-photograph = "<?=$rs['photograph']?>"
                data-target="#update_member"
                data-toggle= "modal" 
                >แก้ไข</button>
                ||
                <button type="button" class="btn btn-danger btn-sm del_member"
                data-m_id = "<?=$rs['m_id']?>"
                >ลบ</button>
              </td>
            </tr>
            <?php $i++; } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <div class="tab-pane fade" id="nav-type" role="tabpanel" aria-labelledby="nav-type-tab">
    <hr>
    <div class="row justify-content-center">
      <div class="col-md-4 p-2">
       <form action="" id="insert-category" method="post" accept-charset="utf-8">
        <div class="form-group">
          <label>เพิ่มประเภทงาน</label>
          <input type="text" name="c_name" class="form-control" placeholder="ชื่องาน" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">บันทึก</button>
        </div>
      </form>   
    </div>
  </div>
  <hr>
  <div class="row justify-content-center">
    <div class="col-md-5">
     <table class="table table-bordered table-striped table-sm ">
       <thead class="text-nowrap align-middle thead-dark">
         <tr>
           <th>ลำดับ</th>
           <th>ประเภท</th>
           <th width="30%"  class="text-center">จัดการ</th>
         </tr>
       </thead>
       <tbody class="text-nowrap align-middle thead-dark">
        <?php $sql = mysqli_query($conn,"SELECT  * FROM  category"); 
        $i=1;
        while($rs= mysqli_fetch_assoc($sql)) { ?>

         <tr>
           <td><?=$i;?></td>
           <td><?=$rs['c_name']?></td>
           <td>
            <button type="button" class="btn btn-sm btn-warning update_cate"
            data-id="<?=$rs['c_id']?>"
            data-c_name="<?=$rs['c_name']?>"
            data-target= "#update-category"
            data-toggle= "modal"
            >แก้ไข</button>
            ||
            <button type="button" class="btn btn-sm btn-danger del_cate"
            data-id="<?=$rs['c_id']?>"
            >ลบ</button></td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
 <hr>
 <div class="row justify-content-center">
  <div class="col-md-8 p-2"> 
    <form id="insert_pending" method="post" accept-charset="utf-8">
      <div class="row">
        <div class="form-group col-md-8">
          <label for="">รายการคงค้าง (Pending)</label>
          <input type="text" name="pd_name" class="form-control" placeholder="รายการคงค้าง (Pending)" required>
        </div>
        <div class="form-group col-md-4">
         <label for="">เงื่อนไขรายการคงค้าง</label>
         <select name="pd_status" class="form-control" required>
          <option value="">--- เลือกเงื่อนไข ---</option>
          <option value="stop">ปิดงาน (เสร็จสิ้น)</option>
          <option value="start">ไม่ปิดงาน (เป็นไปตามกำหนด)</option>
        </select>
      </div> 
    </div>
    <div class="modal-footer">
      <button class="btn btn-info" type="submit">บันทึก</button>
    </div>
  </form>
</div>

<div class="col-md-8"><hr>
  <table class="table table-sm table-striped table-bordered text-center" id="data_pending">
   <thead>
     <tr>
       <th>No.</th>
       <th>รายการคงค้าง (Pending)</th>
       <th>เงื่อนไข</th>
       <!-- <th>เวลา</th> -->
       <th>จัดการ</th>
     </tr>
   </thead>
   <tbody>
    <?php  $sql = mysqli_query($conn,"SELECT * FROM pending");
    $i=1;
    while ($rs = mysqli_fetch_assoc($sql)) {

     ?>
     <tr>
       <td><?=$i;?></td>
       <td><?=$rs['pd_name']?></td>
       <td><?=$rs['pd_status'] == "stop" ? "ไม่ปิดงาน (เป็นไปตามกำหนด)" : "ปิดงาน (เสร็จสิ้น)";?></td>
       <!--  <td><?=$rs['pd_date']?></td> -->
       <td>
        <a href="" class="btn btn-warning btn-sm">แก้ไข</a> ||
        <a href="" class="btn btn-sm btn-danger">ลบ</a>
      </td>
    </tr>
    <?php $i++; }  ?>  
  </tbody>
</table>
</div>
</div>

</div> <!-- ปิดรายการ -->
<div class="tab-pane fade" id="nav-setting" role="tabpanel" aria-labelledby="nav-setting-tab">
  <hr> 
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form id="update_comm" method="post" accept-charset="utf-8">
        <div class="form-group">
          <label>ชื่อบริษัท</label>
          <input type="text" name="com_name" class="form-control" placeholder="ชื่อบริษัท">
        </div>
        <div class="form-group">
          <div class="custom-file-container" data-upload-id="myUniqueUploadId">
            <label>เลือกโลโก้ <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"> ยกเลิก <i class="fa fa-ban"></i></a>
            </label>
            <label class="custom-file-container__custom-file" >
              <input type="file" id="clear" class="custom-file-container__custom-file__custom-file-input" name="file" accept="image/*"  aria-label="Choose File" required>
              <span class="custom-file-container__custom-file__custom-file-control"></span>
            </label>
            <div class="custom-file-container__image-preview mx-auto"  style="height: 150px; width: 150px;"></div>
          </div>
        </div>
        <div class="modal-footer">
         <button type="submit" class="btn btn-info">ยืนยัน</button>
       </div> 
     </form>
   </div>
 </div>
 <hr>
 <div class="row justify-content-center">
   <div class="col-md-6">
     <table  class="table  table-bordered text-center">
       <thead class="table-primary">
         <tr>
           <th>#</th> 
           <th>ชื่อบริษัท</th>
           <th>โลโก้บริษัท</th>
         </tr>
       </thead>
       <tbody>
        <?php  
        $sql = mysqli_query($conn,"SELECT * FROM company_logo");
        while ($rs = mysqli_fetch_assoc($sql)) { ?>
          <tr>
           <td class="align-middle text-nowrap"><?=$rs['com_id']?></td>
           <td class="align-middle text-nowrap"><?=$rs['com_name']?></td>
           <td class="align-middle text-nowrap"><img src="img/<?=$rs['com_logo']?>" width="50"></td>
         </tr>
       <?php } ?>
     </tbody>
   </table>
 </div>
</div>
</div>

<div class="tab-pane fade" id="nav-zone" role="tabpanel" aria-labelledby="nav-zone-tab">
 <hr>
 <div class="row justify-content-center">
   <div class="col-md-6">
     <form   id="insert_zone">
      <div class="form-group">
        <label >โซนพื้นที่</label>
        <input type="text" name="z_name" class="form-control" placeholder="กำหนดโซนพื้นที่" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">ยืนยัน</button>
      </div>
    </form>
  </div>
</div>
<hr>
<div class="row justify-content-center">
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-sm " id="data_zone">
      <thead>
        <tr>
          <th>#</th>
          <th width="70%">โซนพื้นที่</th>
          <th class="text-center">จัดการ</th>
        </tr>
      </thead>
      <tbody>
        <?php $sql = mysqli_query($conn,"SELECT * FROM zone"); 
        $i=1;
        while ($rs = mysqli_fetch_assoc($sql)) { ?>
          <tr>
            <td><?=$i;?></td>
            <td><?=$rs['z_name']?></td>
            <td class="text-center">
              <a href="#"
              data-id = "<?=$rs['z_id']?>"
              data-z_name = "<?=$rs['z_name']?>"
              data-toggle="modal"
              data-target="#edit_zone" 
              class="btn btn-sm btn-warning edit_zone">แก้ไข</a> || 
              <a href="#" 
              class="btn btn-sm btn-danger del_zone"
              data-id = "<?=$rs['z_id']?>"
              >ลบ</a></td>
            </tr> 
            <?php $i++; } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>
</div>
</div>
</div>

</main>
<?php  require_once '../link_js/link_js.php';  require_once 'madal.php';
?>
<script type="text/javascript" src="ajax.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#data_position,#data_member,#data_pending,#data_zone").DataTable({
      "sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
      "drawCallback": function () {
        $('.dataTables_paginate > .pagination').addClass('pagination-sm');
      }
    });
  });

  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    $('a[href="' + activeTab + '"]').tab('show');
  }

  var upload = new FileUploadWithPreview('myUniqueUploadId', {

    showDeleteButtonOnImages: true,
    text: {
      chooseFile: ' ChooseImages',
      browse: 'เลือกโลโก',
      selectedCount: 'Files Selected', /*files selected*/
    },
      //maxFileCount: 0,
    });
  </script>

</body>
</html>