<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Main CSS-->
  <?php /*require_once 'db/config.php';*/ require_once 'db/title.php'; require_once 'link_css/link_css.php'; ?>
  <link rel="shortcut icon" href="<?=$icon_index?>" type="image/x-icon">
  <title><?=$title?></title>
</head>
<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <!-- <section class="lockscreen-content">
   <div class="text-white p-4">
     <h1><?=$title?></h1>
   </div>
   <div class="lock-box"><img class="rounded-circle user-image" src="<?=$logo_index?>">

    <form class="login-form" id="form_login" method="post">

      <div id="myAlert" class="alert alert-danger alert-dismissible  collapse" role="alert">
        <strong>แจ้งเตือน!</strong> ชื่อ-รหัสผ่านไม่ถูกต้อง
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="form-group">
        <label class="control-label">ชื่อ</label>
        <input class="form-control" type="text" name="username" placeholder="Username" autofocus>
        <input class="form-control" type="text" name="login" value="login" hidden>
      </div>
      <div class="form-group">
        <label class="control-label">รหัสผ่าน</label>
        <input class="form-control" name="password" type="password" placeholder="Password">
      </div>

      <div class="form-group btn-container">
        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>เข้าสู่ระบบ</button>
      </div>
    </form>
  </div>
$msg     = "<meta charset='utf-8'>";
$msg     = "สวัสดี คุณอภิเชษฐ์ สิงห์นาครอง <br>";
// $msg      .= "ตามที่คุณอภิเชษฐ์ ได้แจ้งว่าลืมรหัสผ่านในการเข้าใช้งานระบบCloudwork ระบบได้ทำการ Reset รหัสผ่านของคุณเรียบร้อยแล้ว <br>";
// $msg       .= "โดย <br>";
// $msg      .= "รหัสผ่านเดิมของคุณคือ : 123456 <br> ระบบได้ทำการเปลี่ยนรหัสผ่านใหม่เพื่อความปลอดภัย <br>";
// $msg       .= "New Password : ".strtotime(date('Y-m-d H:i:s'))." <br>";
// $msg      .= "สามารถเข้าใช้งานได้ที่ http://cloudwork.cloud/service/index.php <br>";
</section> -->


<section class="lockscreen-content">
  <div class="text-white p-4">
    <h1><?=$title?></h1>
  </div>
  <div class="lock-box">
    <form class="login-form" id="form_login" method="post">
      <h3 class="login-head text-center"><i class="fa fa-lg fa-fw fa-user" ></i>เข้าสู่ระบบ</h3><hr>
      <div id="myAlert" class="alert alert-danger alert-dismissible  collapse">
        <strong>แจ้งเตือน!</strong> ชื่อ-รหัสผ่านไม่ถูกต้อง
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="form-group">
        <label class="control-label">ชื่อ</label>
        <input class="form-control" type="text" name="username" placeholder="Username" autofocus>
        <input class="form-control" type="text" name="login" value="login" hidden>
      </div>
      <div class="form-group">
        <label class="control-label">รหัสผ่าน</label>
        <input class="form-control" name="password" type="password" placeholder="Password">
      </div>
      <div class="form-group">
        <div class="utility">
          <div class="animated-checkbox"></div>
          <p class="semibold-text mb-2" id="forgot_click"><a href="#" data-toggle="flip">ลืมรหัสผ่าน</a></p>
        </div>
      </div>
      <div class="form-group btn-container">
        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>เข้าสู่ระบบ</button>
      </div>
    </form>
    <form class="forget-form" id="forgot_password" style="display: none;">
      <h3 class="login-head text-center"><i class="fa fa-lg fa-fw fa-lock"></i>ลืมรหัสผ่าน ?</h3><hr>
      <div id="alert_pass" class="alert alert-danger alert-dismissible  collapse">
        <strong>แจ้งเตือน!</strong> E-Mail นี้ไม่มีในระบบ
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="form-group">
        <label class="control-label">อีเมลล์</label>
        <input class="form-control" type="email" name="email" placeholder="ระบุอีเมลล์ที่มีในระบบ" required>
      </div>
      <div class="form-group btn-container">
        <button  type="submit" class="btn btn-primary btn-block" id="show_login"><i class="fa fa-unlock fa-lg fa-fw"></i>ส่ง</button>
      </div>
      <div class="form-group mt-3">
        <p class="semibold-text mb-0" id="login_click"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> กลับหน้า เข้าสู่ระบบ</a></p>
      </div>
    </form>
  </div>
</section>

<div class="card">
 <div class="card-header text-center">
  Power By : DevX (Thailand) Co.,Ltd
</div>
</div>
<!-- Essential javascripts for application to work-->
<?php require_once 'link_js/link_js.php';  ?> 
<script type="text/javascript" src="login/login.js"></script>
<script type="text/javascript">
  $("#forgot_click").click(function() {
    $('#forgot_password').attr('style', 'display:visible');
    $('#form_login').attr('style', 'display:none');
  });

  $("#login_click").click(function() {
    $('#forgot_password').attr('style', 'display:none');
    $('#form_login').attr('style', 'display:visible');
  });

</script>



</body>
</html>