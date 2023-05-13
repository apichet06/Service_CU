<?php 
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header('Last-Modified:' . gmdate('D, d M Y H:i:s').'GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
session_start(); 

  require_once '../db/config.php';
  $sql = mysqli_query($conn,"SELECT *,a.username,a.m_name,b.dv_name_short,a.p_id,c.p_hort,d.home,d.worksheet,d.assessment,d.mechanic_work,d.work_in_out,d.charts,d.manages FROM member a 
   INNER JOIN division b 
   on a.dv_id = b.dv_id
   INNER JOIN position c 
   on a.p_id = c.p_id
   LEFT JOIN practicability d 
   on d.p_id = a.p_id
   Where a.username = '".$_SESSION['login_user']."' ");
  $rs0 = mysqli_fetch_assoc($sql);
  $user       = $rs0['m_name'];
  $short      = $rs0['dv_name_short'];
  $authority  = $rs0['p_id'];
  $status     = $rs0['p_hort'];

  $home           = $rs0['home'];
  $worksheet      = $rs0['worksheet'];
  $assessment     = $rs0['assessment'];
  $work_transfer  = $rs0['work_transfer'];
  $mechanic_work  = $rs0['mechanic_work'];
  $work_in_out    = $rs0['work_in_out'];
  $charts         = $rs0['charts'];
  $manages        = $rs0['manages'];

  if ($rs0['username'] == '') {
    header("location:../index.php");
  }

  ?>
  <!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="../home/index.php"><img src="../img2/name_.png" width="120"></a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
   <!-- <li class="app-search">
      <input class="app-search__input" type="search" placeholder="Search">
      <button class="app-search__button"><i class="fa fa-search"></i></button>
    </li>
    Notification Menu-->
    <!-- <li class="dropdown ">
     <a class="app-nav__item hide" href="#" data-toggle="dropdown" aria-label="Show notifications">
      <i class="fa fa-bell-o fa-lg"></i>
      <span class="badge badge-danger badge-pill"></span>
    </a>
    <ul class="app-notification dropdown-menu dropdown-menu-right">
      <li class="app-notification__title">ข้อความใหม่ <span class ="x"></span></li>
      <div class="app-notification__content">
        <li class="show_messages"></li>
      </div>
    </ul>
  </li> -->
  <!-- User Menu-->
  <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
    <ul class="dropdown-menu settings-menu dropdown-menu-right">
      <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#re_pass"><i class="fa fa-key "></i> เปลี่ยนรหัสผ่าน</a></li>
      <li><a class="dropdown-item" href="../login/manage_logout.php"><i class="fa fa-sign-out "></i> ออกจากระบบ</a></li>
    </ul>
  </li>
</ul>
</header>

<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?=$logo;?>" width="46">
    <div>
      <p class="app-sidebar__user-name">ยินดีต้อนรับสู่ระบบ</p>
      <p class="app-sidebar__user-designation"><?php echo  'คุณ '.$user;  ?></p>
      <!--  <p class="app-sidebar__user-designation"><?=$rs0['dv_name'];?></p> -->
      <p class="app-sidebar__user-designation">สถานะ : <?=$status."(".$short.")";?></p>
    </div>
  </div>


 <ul class="app-menu">
  <!--<li><a class="app-menu__item" href="dashboard.html"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">กระดานแจ้งงาน</span></a></li>-->
  <?php if($home == "1"){ ?> 
    <li><a class="app-menu__item" 
      href="../home/index.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">หน้าหลัก </span></a></li>
    <?php } ?>

    
    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">ใบงาน</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu ">
        <?php if($worksheet =="1"){ ?>
          <li><a class="treeview-item" href="../admin/worksheet.php"><i class="icon fa fa-circle-o"></i>สร้างใหม่</a>
          </li>
        <?php } if($assessment =="1"){ ?>
          <li><a class="treeview-item" href="../assessment/assessment.php"><i class="icon fa fa-circle-o"></i>รอตรวจสอบ</a>
          </li>
        <?php } if($work_transfer =="1"){ ?>
          <li><a class="treeview-item" href="../admin/work_transfer.php"><i class="icon fa fa-circle-o"></i>คืนงาน</a>
          </li>
        <?php } if($mechanic_work =="1"){ ?>         
          <li><a class="treeview-item" href="../report/mechanic_work.php"><i class="icon fa fa-circle-o"></i>งานทั้งหมด</a>
          </li> 
        <?php } if($mechanic_work =="1"){ ?>         
          <li><a class="treeview-item" href="../Technician_work_split/index.php"><i class="icon fa fa-circle-o"></i>สรุปงานช่าง(แยกประเภท)</a>
          </li> 
        <?php } ?>
      </ul>
    </li>

    <?php if($work_in_out =='1'){ ?> 
      <li><a class="app-menu__item" href="../report/work_in_out.php"><i class="app-menu__icon fa fa-file-text-o"></i><span class="app-menu__label">ลงเวลางาน</span></a>
      </li>
    <?php } if($charts =='1'){ ?> 
      <li><a class="app-menu__item" href="../charts/index.php"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Charts </span></a></li>
    <?php } if($manages =='1'){ ?> 
      <li><a class="app-menu__item" href="../manages/index.php"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">ตั้งค่าระบบ </span></a></li>
    <?php } ?>

  </ul>
</aside>

<!-- Modal -->
<div class="modal fade" id="re_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เปลี่ยนรหัสผ่าน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="re_password">
          <div class="form-group">
            <div class="alert alert-warning" role="alert" id="alert_pass">
             <a href="#" class="alert-link">แจ้งเตือน!</a>. รหัสผ่านที่กลอกไม่ตรงกัน
           </div>
           <label>รหัสผ่านใหม่</label>
           <input type="password" class="form-control" name="password1" id="password1" placeholder="รหัสผ่านใหม่">
           <input type="text" name="m_id" value="<?=$rs0['m_id']?>" class="form-control" hidden>
         </div>
         <div class="form-group">
          <label>ยืนยันรหัสผ่านใหม่</label>
          <input type="password" class="form-control" name="password2" id="password2"  placeholder="ยืนยันรหัสผ่านใหม่">
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



