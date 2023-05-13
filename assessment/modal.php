<!-- Modal -->
<div class="modal fade" id="insert_ws_assess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เหตุผลที่คิดว่าไม่ผ่าน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" id="failed_assess" accept-charset="utf-8">
       <textarea name="ws_assess" class="form-control" rows="4" required></textarea>
       <input type="text" name="id" id="idx" hidden>
      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
          <button type="submit" class="btn btn-primary">ยืนยัน</button>
        </div>
          </form>
      </div>
    </div>
  </div>
</div>

