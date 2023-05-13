<div class="modal fade" id="update_division" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลแผนก</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_idvision" name="update_idvision" method="POST">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">ชื่อแผนก:</label>
            <input type="text" class="form-control" name="dv_name" id="dv_name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">ชื่อแผนกย่อ:</label>
            <input type="text" class="form-control" name="dv_name_short" id="dv_name_short">
            <input type="text" class="form-control" name="id" id="dv_id" hidden>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ยืนยัน</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>


<div class="modal fade" id="update_position" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขชื่อตำแหน่งงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="position" name="update_position" method="POST">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">ตำแหน่ง:</label>
              <input type="text" class="form-control" name="p_name" id="p_name">
            </div>
            <div class="form-group col-md-6">
              <label for="message-text" class="col-form-label">ตำแหน่งย่อ:</label>
              <input type="text" class="form-control" name="p_hort" id="p_hort">
              <input type="text" class="form-control" name="p_id" id="p_id" hidden>
            </div>
          </div>
          <hr> <h5>สิทธิ์เข้าใช้งานเมนู</h5>
          <div class="row">
           <div class="col-md-2">
             <div class="animated-checkbox">
              <label>
                <input type="checkbox" name="home" id="home" value="1"><span class="label-text">หน้าหลัก</span>
              </label>
            </div>
          </div> 
          <div class="col-md-2">
           <div class="animated-checkbox">
            <label>
              <input type="checkbox" name="worksheet" id="worksheet" value="1"><span class="label-text">สร้างใบงานใหม่</span>
            </label>
          </div>
        </div>
        <div class="col-md-2">
         <div class="animated-checkbox">
          <label>
            <input type="checkbox" name="assessment" id="assessment" value="1"><span class="label-text">รอตรวจสอบ</span>
          </label>
        </div>
      </div>
      <div class="col-md-2">
       <div class="animated-checkbox">
        <label>
          <input type="checkbox" name="work_transfer" id="work_transfer" value="1"><span class="label-text">คืนงาน</span>
        </label>
      </div>
    </div>
    <div class="col-md-2">
     <div class="animated-checkbox">
      <label>
        <input type="checkbox" name="mechanic_work" id="mechanic_work" value="1"><span class="label-text">งานทั้งหมด</span>
      </label>
    </div>
  </div>
  <div class="col-md-2">
   <div class="animated-checkbox">
    <label>
      <input type="checkbox" name="work_in_out" id="work_in_out" value="1"><span class="label-text">ลงเวลางาน</span>
    </label>
  </div>
</div>
<div class="col-md-2">
 <div class="animated-checkbox">
  <label>
    <input type="checkbox" name="charts" id="charts" value="1"><span class="label-text">Charts</span>
  </label>
</div>
</div>
<div class="col-md-2">
 <div class="animated-checkbox">
  <label>
    <input type="checkbox" name="manages" id="manages" value="1"><span class="label-text">ตั้งค่าระบบ</span>
  </label>
</div>
</div>

</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-primary">ยืนยัน</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
</div>
</form>
</div>

</div>
</div>
</div>


<div class="modal fade" id="update_place" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขชื่อสถานที่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="place_x" name="update_place" method="POST">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">โซนพื้นที่:</label>
            <select name="z_id" id="z_id" required class="form-control"> 
             <option value="">--- เลือกโซนพื้นที่ ---</option>
             <?php $sql = mysqli_query ($conn,"SELECT * FROM zone ");
             while ($rs = mysqli_fetch_assoc($sql)) { ?>
              <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">สถานที่:</label>
          <input type="text" class="form-control" name="place_name" id="place_name">
          <input type="text" class="form-control" name="place_id" id="place_id" hidden>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">ยืนยัน</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>

  </div>
</div>
</div>



<div class="modal fade" id="update_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขรายชื่อสมาชิก</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="update-mamber" name="member-member" method="post" accept-charset="utf-8">
          <div class="row">
            <div class="col-md-12">
              <div id="myAlert_update_m" class="alert alert-danger alert-dismissible  collapse" role="alert">
                <strong>แจ้งเตือน!</strong> ชื่อ-สกุลหรือชื่อล็อกอินซ้ำ กรุณาตรวจเช็คอีกครั้ง!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="inputAddress">ชื่อ</label>
                  <input type="text" class="form-control" name="m_name" id="m_name" placeholder="ชื่อ" >
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">สกุล</label>
                  <input type="text" class="form-control" name="m_lname" id="m_lname" placeholder="สกุล" >
                </div>
                <div class="form-group col-md-6">
                  <label for="inputCity">ชื่อล็อกอิน</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="ชื่อล็อกอิน" >
                </div>
                <div class="form-group col-md-6">
                  <label>รหัสผ่าน</label>
                  <input type="text" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" >
                </div>
                <div class="form-group col-md-6">
                  <label for="inputCity">เบอร์โทร</label>
                  <input type="text" class="form-control" name="m_phone" id="m_phone" placeholder="เบอร์โทร" >
                  <input type="text" class="form-control" name="m_id" id="m_id" hidden>
                </div>
                <div class="form-group col-md-6">
                  <label>e-mail</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="e-mail">
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">โซนพื้นที่</label>
                  <select name="z_idx[]" style="width: 100%"    id="z_id_x ไม่ส่ง" class="form-control demoSelect" multiple >
                    <option value="">---- เลือกภูมิภาค ----</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM zone "); 
                    while ($rs = mysqli_fetch_assoc($sql)) { ?>
                      <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">แผนก</label>
                  <select name="dv_id" id="dv_id_x" class="form-control" >
                    <option value="">---- เลือกแผนก ----</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM division "); 
                    while ($rs = mysqli_fetch_assoc($sql)) { ?>
                      <option value="<?=$rs['dv_id']?>"><?=$rs['dv_name']." (".$rs['dv_name_short'].")";?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputCity">ประเภทผู้ใช้งาน</label>
                  <select name="p_id" id="p_id_x" class="form-control" >
                    <option value="">--- เลือก ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM position "); 
                    while ($rs = mysqli_fetch_assoc($sql)) { ?>
                      <option value="<?=$rs['p_id']?>"><?=$rs['p_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputEmail4">กำหนดถ่ายภาพลงเวลาเข้างาน</label>
                  <select name="photograph" class="form-control " id="photograph" >
                    <option value="">---- กำหนด ----</option>
                    <option value="1">ต้องถ่ายรุป</option>
                    <option value="0">ไม่ต้องถ่ายรุป</option>
                  </select> 
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
           <button type="submit" class="btn btn-primary">ยืนยัน</button>
           <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
         </div>
       </form>
     </div>

   </div>
 </div>
</div>


<!-- Modal -->
<div class="modal fade" id="update-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขประเภทงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="update_category" method="post" accept-charset="utf-8">
         <div class="form-group">
           <label>ชื่องาน</label>
           <input type="text" name="c_name" id="c_name" class="form-control" placeholder="ชื่องาน" required>
           <input type="text" name="c_id" id="c_id_c" class="form-control" hidden>
         </div>
         <div class="modal-footer">
          <button type="submit" class="btn btn-primary">ยืนยัน</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
        </div>   
      </form>
    </div>
    
  </div>
</div>
</div>

<!-- ****************************** -->
<!--    update การลงเวลาเข้างาน         -->
<!-- ****************************** -->

<div class="modal fade" id="working_day" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขประเภทงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_working_day" method="post" accept-charset="utf-8">
         <div id="show_view"></div>
         <input type="text" name="m_id" id="m_id_update_schedule" class="form-control" hidden>
         <div class="modal-footer">
          <button type="submit" class="btn btn-info">แก้ไข</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>

  </div>
</div>
</div>


<div class="modal fade" id="edit_zone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขโซนพื้นที่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_zone" method="post" accept-charset="utf-8">
         <div id="show_view"></div>
         <input type="text" name="z_id" id="z_id_zone" class="form-control" hidden>
         <input type="text" name="z_name" id="z_name" class="form-control"  placeholder="กำหนดโซนพื้นที่">
         <div class="modal-footer">
          <button type="submit" class="btn btn-info">แก้ไข</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>

  </div>
</div>
</div>
