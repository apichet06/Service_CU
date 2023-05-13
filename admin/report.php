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
        <h1><i class="fa fa-home" ></i> รายงานสถานะการทำงานของช่างทั้งหมด </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
      </ul>
    </div>

    <div class="row justify-content-center">
      <div class=" col-sm-12 col-md-4">
        <div class="tile">
          <form>
            <div class="form-row">
              <div class="col-9">
                <select id="inputState" class="form-control">
                  <option value="">---เลือกเขตพื้นที่--</option>
                  <option value="">กรุงเทพ</option>
                  <option value="">ขอนแก่น</option>
                  <option value="">หนองคาย</option>
                  <option value="">เชียงใหม่</option>
                </select>
              </div>
              <div class="col-3">
               <button type="submit" class="btn btn-info">ค้นหา</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="row">
     <div class="col-md-12">
      <div class="tile">
        <h4>รายงานสถานะการทำงานของช่างทั้งหมด</h4>
        <hr>
        <table class="table table-bordered table-inverse table-responsive">
          <thead>
            <tr>
              <th class="text-nowrap align-middle">No</th>
              <th class="text-nowrap align-middle">MR_NO</th>
              <th class="text-nowrap align-middle">CU_Job</th>
              <th class="text-nowrap align-middle">Call_Date</th>
              <th class="text-nowrap align-middle">Call_Time</th>
              <th class="text-nowrap align-middle">Customer</th>
              <th class="text-nowrap align-middle">ฝ่ายงาน</th>
              <th class="text-nowrap align-middle">Tel</th>
              <th class="text-nowrap align-middle">Help_CU</th>
              <th class="text-nowrap align-middle">Catalogue</th>
              <th class="text-nowrap align-middle">Model</th>
              <th class="text-nowrap align-middle">S/N</th>
              <th class="text-nowrap align-middle">ปัญหาที่เกิดขี้น</th>
              <th class="text-nowrap align-middle">หารแก้ไขปัญหา</th>
              <th class="text-nowrap align-middle">Start_Date</th>
              <th class="text-nowrap align-middle">Start_Time</th>
              <th class="text-nowrap align-middle">Finish_date</th>
              <th class="text-nowrap align-middle">Finish_time</th>
              <th class="text-nowrap align-middle">Job_status</th>

            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>6226786</td>
              <td>CU0834532</td>
              <td>1/9/2019</td>
              <td>18:00</td>
              <td>คุณถาวร</td>
              <td>ธุรกิจและสิทธิประโยชน์</td>
              <td>-</td>
              <td>ศิวดล</td>
              <td>Network</td>
              <td>-</td>
              <td>-</td>
              <td>Internet ใช้ไม่ได้หลังจากไฟดับ</td>
              <td>ทำการ Reset config switch ให้ใหม่</td>
              <td>1/9/2019</td>
              <td>18:00</td>
              <td>1/9/2019</td>
              <td>19:30</td>
              <td>Completed</td>
              
            </tr>
            <tr>
              <td>2</td>
              <td>6226821</td>
              <td>CU0834532</td>
              <td>1/9/2019</td>
              <td>18:00</td>
              <td>คุณถาวร</td>
              <td>ธุรกิจและสิทธิประโยชน์</td>
              <td>-</td>
              <td>ศิวดล</td>
              <td>Network</td>
              <td>-</td>
              <td>-</td>
              <td>Internet ใช้ไม่ได้หลังจากไฟดับ</td>
              <td>ทำการ Reset config switch ให้ใหม่</td>
              <td>1/9/2019</td>
              <td>18:00</td>
              <td>1/9/2019</td>
              <td>19:30</td>
              <td>Completed</td>
              
            </tr>
          </tbody>
        </table>

      </div>
    </div>

  </div>
  
</main>
<?php  require_once '../link_js/link_js.php'; ?>
</body>
</html>