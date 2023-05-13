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
        <h1><i class="fa fa-pie-chart" ></i> กราฟ </h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form  method="post" accept-charset="utf-8">

          <div class="tile">
            <div class="row">
              <div class="col-md-5">
                <select name="year" class="form-control">
                  <option value="">--- เลือกปี ---</option>
                  <?php $sql = mysqli_query($conn,"SELECT year(ws_date)as year FROM worksheet GROUP BY year(ws_date) desc");
                  while ($rs = mysqli_fetch_assoc($sql)) { ?>
                    <option value="<?=$rs['year']?>" <?php if($rs['year']== date('Y')){echo 'selected';} ?>><?=$rs['year']+543?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-5">
                <select name="month" class="form-control">
                  <option value="">--- เลือกเดือน ---</option>
                  <?php $sql = mysqli_query($conn,"SELECT * FROM month ");
                  while ($rs=mysqli_fetch_assoc($sql)) { ?>
                   <option value="<?=$rs['month_id'].','.$rs['month_name']?>" <?php if($rs['month_id']== date('m')){echo 'selected';} ?>><?=$rs['month_name']?></option>
                 <?php } ?>
               </select>
             </div>
             <div class="col-md-2">
              <button type="submit" class="btn btn-info">ค้นหา</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row">
 <div class="col-md-12 p-1">
  <div class="tile">
    <h4>กราฟแยกประเภทงาน ประจำปี <?=$_POST['year']=="" ? date("Y")+543 : $_POST['year']+543?> 
    <?php $month = explode(",",$_POST['month']); $year = $_POST['year']?>
    <?=$month[0]=="" ? "" : "เดือน ".$month[1];?> </h4>
    <hr>
    <canvas id="myChart" width="400" height="100"></canvas>  
  </div>
</div>

<div class="col-md-6 p-1">
  <div class="tile">
    <h4>กราฟสรุปงานแต่ละแผนก ประจำปี <?=$_POST['year']=="" ? date("Y")+543 : $_POST['year']+543?>  </h4>
    <hr>
    <canvas id="myChart0" width="400" height="200"></canvas>  
  </div>
</div>

<div class="col-md-6 p-1">
  <div class="tile">
    <h4>Top 10 กราฟสรุปผู้สร้างใบงาน ปี <?=$_POST['year']=="" ? date("Y")+543 : $_POST['year']+543?><?=$month[0]=="" ? "" : " เดือน ".$month[1];?> </h4>
    <hr>
    <canvas id="myChart1" width="400" height="200"></canvas>  
  </div>
</div>

<div class="col-md-12 p-1">
  <div class="tile">
    <h4>Top 10 ช่างที่รับงานสูงสุด ปี <?=$_POST['year']=="" ? date("Y")+543 : $_POST['year']+543?><?=$month[0]=="" ? "" : " เดือน ".$month[1];?></h4>
    <hr>
    <canvas id="myChart2" width="400" height="120"></canvas>  
  </div>
</div>
<div class="col-md-12 p-1">
  <div class="tile">
   <h4>Top 10 สถานที่ เข้าให้บริการมากที่สุด ปี <?=$_POST['year']=="" ? date("Y")+543 : $_POST['year']+543?><?=$month[0]=="" ? "" : " เดือน ".$month[1];?></h4>
   <hr> 
   <canvas id="service" width="400" height="120"></canvas>  
 </div>

</div>
</div>

</main>
<?php  require_once '../link_js/link_js.php'; ?>

<?php  $m = explode('0', $month[0]); $y = date('Y');
$sql = mysqli_query($conn,"SELECT c_name,count(b.c_id)as s_sum FROM category a 
  LEFT JOIN worksheet b 
  on a.c_id = b.c_id
  WHERE year(b.ws_date) = '$y' and (year(b.ws_date) like '%$year%' and month(b.ws_date) like '%$m[1]%')
  GROUP BY a.c_id");

$c_name  = array();
$x       = array();

while($rows = mysqli_fetch_assoc($sql)){

  array_push($c_name,$rows['c_name']);
  array_push($x,$rows['s_sum']);

}

$sql0 = mysqli_query($conn,"SELECT month_name,pm.sum_job_pm,cm.sum_job_cm,ins.sum_job_ins,month_id,ad.sum_job_ad FROM month
  LEFT JOIN (SELECT count(dv_id)as sum_job_pm,month(ws_date)as m_month_id FROM worksheet
  WHERE  dv_id = '2' and year(ws_date) = '$y' and (year(ws_date) like '%$year%')
  GROUP BY month(ws_date)
  )pm 
  on pm.m_month_id = month_id 
  LEFT JOIN (SELECT count(dv_id)as sum_job_cm,month(ws_date)as cm_month_id FROM worksheet
  WHERE  dv_id = '1' and year(ws_date) = '$y' and (year(ws_date) like '%$year%')
  GROUP BY month(ws_date)
  )cm 
  on cm.cm_month_id = month_id
  LEFT JOIN (SELECT count(dv_id)as sum_job_ins,month(ws_date)as ins_month_id FROM worksheet
  WHERE  dv_id = '3' and year(ws_date) = '$y' and (year(ws_date) like '%$year%')
  GROUP BY month(ws_date)
  )ins
  on ins.ins_month_id = month_id
  LEFT JOIN (SELECT count(dv_id)as sum_job_ad,month(ws_date)as ad_month_id FROM worksheet
  WHERE  dv_id = '4' and year(ws_date) = '$y' and (year(ws_date) like '%$year%')
  GROUP BY month(ws_date)
  )ad
  on ad.ad_month_id = month_id
  ")or die(mysqli_error($conn));

/*$sql = mysqli_query($conn," ");*/

$m_month      = array();
$sum_job_pm   = array();
$sum_job_cm   = array();
$sum_job_ins  = array();
$sum_job_ad   = array();
while ($rs = mysqli_fetch_assoc($sql0)) {
          //echo  $rs['month_id']."<br>";
          //echo  $rs['sum_job_pm']."<br>";
  array_push($m_month,$rs['month_name']);
  array_push($sum_job_pm,$rs['sum_job_pm']); 
  array_push($sum_job_cm,$rs['sum_job_cm']); 
  array_push($sum_job_ins,$rs['sum_job_ins']); 
  array_push($sum_job_ad,$rs['sum_job_ad']); 
}




?>
<?php require_once 'chart.php' ?>


</body>
</html>