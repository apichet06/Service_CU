<!DOCTYPE html>
<html>
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
 <?php require_once '../menu/menu.php'; require_once '../menu/datetime_function.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-home" ></i>แยกประเภทงานของช่าง</h1>
        <p><?=$title?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item" id="datetime"></li>
      </ul>
    </div>	

  <div class="tile">
  	<div class="">
  		
  	</div>
  </div>

</main>
<?php  require_once '../link_js/link_js.php'; ?>

</body>
</html>