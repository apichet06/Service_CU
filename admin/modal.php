<div class="modal fade" id="deliver_work" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">ส่งมอบงานช่างให้ช่างท่านอื่นๆ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="insert_deliver_work" id="insert_deliver_work" method="post">
          <div class="row">
            <div class="col-md-6 "><!--ส่วนของการเพิ่มรายละเอียด-->    
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="inputState">ชื่อใบงาน</label>
                  <input type="text" class="form-control" name="ws_name" id="ws_name" placeholder="ชื่อใบงาน ,อาการอุปกรณ์เสียที่ต้องการการซ่อม" required>
                  <input type="text" class="form-control" name="id" id="ws_id_v" hidden>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">ประเภทงาน</label>
                  <select name="c_id" id="c_id" class="form-control" required>
                    <option value="">--- ประเภทงาน ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM category"); 
                    while($rs = mysqli_fetch_assoc($sql)){ ?>
                      <option value="<?=$rs['c_id']?>"><?=$rs['c_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputAddress">รายละเอียดสิ่งที่ขอให้ดำเนินการ</label>
                  <textarea type="text" class="form-control" name="ws_request" id="ws_request" placeholder="รายละเอียดสิ่งที่ขอให้ดำเนินการ" rows="5" required></textarea>
                </div>

              </div>
            </div>
            <div class="col-md-6"><!--ส่วนของการกำหนดเวลา--> 
              <div class="row">  
                <div class="form-group col-md-12" >
                  <label for="inputAddress">Zone(เขตพื้นที่)</label>
                  <select name="z_id" id="z_id_ss" class="form-control" >
                    <option value="">--- เลือกภูมิภาค ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM zone  order by z_id desc");
                    while ($rs= mysqli_fetch_assoc($sql)) { ?>
                      <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
                    <?php } ?>

                  </select>
                </div>
                <div  class="col-md-12">
                  <div class="row" id ="uddate_data_worksheet">
                    
                  </div>
                </div>
                <div class="form-group col-md-6 ">
                  <label>กำหนดเวลาเริ่มงาน</label>
                  <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                    <input type="text" name="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker7" placeholder="กำหนดเวลาเริ่มงาน" required />
                    <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>กำหนดเวลาที่ต้องการให้งานเสร็จ</label>
                  <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                    <input type="text" name="ws_end_date" class="form-control datetimepicker-input" data-target="#datetimepicker8" placeholder="กำหนดเวลาที่ต้องการให้งานเสร็จ" required />
                    <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
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



<div class="modal fade" id="edit_work" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขใบงานมอบหมายงานช่าง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="update_work" id="update_work" method="post">
          <div class="row">
            <div class="col-md-6 "><!--ส่วนของการเพิ่มรายละเอียด-->    
              <div class="row">

                <div class="form-group col-md-6">
                  <label for="inputState">ชื่อใบงาน</label>
                  <input type="text" class="form-control" name="ws_name" id="ws_name_up" placeholder="ชื่อใบงาน ,อาการอุปกรณ์เสียที่ต้องการการซ่อม" required>
                  <input type="text" class="form-control" name="id" id="ws_id_v_up" hidden>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">ประเภทงาน</label>
                  <select name="c_id" id="c_id_up" class="form-control" required>
                    <option value="">--- ประเภทงาน ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM category"); 
                    while($rs = mysqli_fetch_assoc($sql)){ ?>
                      <option value="<?=$rs['c_id']?>"><?=$rs['c_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputAddress">รายละเอียดสิ่งที่ขอให้ดำเนินการ</label>
                  <textarea type="text" class="form-control" name="ws_request" id="ws_request_up" placeholder="รายละเอียดสิ่งที่ขอให้ดำเนินการ" rows="5" required></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-6"><!--ส่วนของการกำหนดเวลา--> 
              <div class="row">  
                <div class="form-group col-md-12" >
                  <label for="inputAddress">Zone(เขตพื้นที่)</label> 
                  <select name="z_id" id="z_id_ss_up" class="form-control" >
                    <option value="">--- เลือกภูมิภาค ---</option>
                    <?php $sql = mysqli_query($conn,"SELECT * FROM zone order by z_id desc");
                    while ($rs= mysqli_fetch_assoc($sql)) { ?>
                      <option value="<?=$rs['z_id']?>"><?=$rs['z_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div  class="col-md-12">
                  <div class="row" id ="edit_data_m_id">
                    
                  </div>
                </div>
                <div class="form-group col-md-6 ">
                  <label>กำหนดเวลาเริ่มงาน</label>
                  <div class="input-group date" id="datetimepicker9" data-target-input="nearest">
                    <input type="text" name="ws_start_date" id="ws_start_date" class="form-control datetimepicker-input" data-target="#datetimepicker9" placeholder="กำหนดเวลาเริ่มงาน" required />
                    <div class="input-group-append" data-target="#datetimepicker9" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>กำหนดเวลาที่ต้องการให้งานเสร็จ</label>
                  <div class="input-group date" id="datetimepicker10" data-target-input="nearest">
                    <input type="text" name="ws_end_date" id="ws_end_date" class="form-control datetimepicker-input" data-target="#datetimepicker10" placeholder="กำหนดเวลาที่ต้องการให้งานเสร็จ" required />
                    <div class="input-group-append" data-target="#datetimepicker10" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
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


