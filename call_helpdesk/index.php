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
        <h1><i class="fa fa-home" ></i> การมอบหมายงานให้ช่าง </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
      </ul>
    </div>
    <div class="row">
     <div class="col-md-12">
      <div class="tile">
        <h4>รายการอุปกรณ์ซอฟแวร์และฮาร์ดแวร์</h4>
        <hr>
        <table class="table table-inverse table-striped">
         <thead>
           <tr>
            <th>#</th>
            <th>รายการ</th>
            <th>เขตพื้นที่</th>
            <th>สถานที่ตั้ง</th>
            <th>วันที่นำเข้า</th>
            <th>วันหมดสัญญา</th>
            <th>สถานะสัญญา</th>
            <th>หมอบหมายงานซ่อม</th>
            <th>สถานะการมอบหมายงาน</th>
          </tr>
        </thead>
        <tbody>
         <tr>
           <td>1</td>
           <td>printer cannon</td>
           <td>กรุงเทพฯ</td>
           <td>โรงพยาบาลราชพิพัฒน์</td>
           <td>20/05/2019</td>
           <td>20/05/2022</td>
           <td>เหลืออีก 2 ปี 3 เดือน 2 วัน</td>
           <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">เลือก</button></td>
           <td>ไม่มีการมอบหมาย</td>
         </tr>
         <tr>
           <td>2</td>
           <td>printer cannon</td>
           <td>ปทุมธานี</td>
           <td>โรงพยาบาลปทุมธานี</td>
           <td>20/05/2019</td>
           <td>20/05/2022</td>
           <td>เหลืออีก 2 ปี 3 เดือน 2 วัน</td>
           <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">เลือก</button></td>
           <td>อยู่ระว่างดำเนินการ</td>
         </tr>
       </tbody>
     </table>
   </div>
 </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label class="col-form-label">ช่างประจำพื้นที่</label>
            <select name="" class="form-control">
              <option value="">--เลือกช่าง--</option>
              <option value="">อภิชาติ</option>
              <option value="">วิรัช</option>
              <option value="">วินัย</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">รายละเอียดอาการเบื้องต้นที่เสีย</label>
            <textarea class="form-control" id="message-text" placeholder="รายละเอียดรายการเบื่องต้นที่เสีย"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">ยืนยัน</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>


</main>
<?php  require_once '../link_js/link_js.php'; ?>
<script type="text/javascript" src="chart.js"></script>
</body>
</html>