  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <?php require_once '../link_css/link_css.php'; ?>
  </head>
  <body>
    <?php 
error_reporting(~E_NOTICE); //ปิด  error (Notice: Undefined index:)
$servername = "localhost";
$username = "root";
$password = "";
$db = "cloudwor_service";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>
 
<?php $sql = mysqli_query($conn,"SELECT * FROM member a
  LEFT JOIN position c 
  on a.p_id = c.p_id
  LEFT JOIN division d 
  on a.dv_id = d.dv_id
  LEFT JOIN area_zone e
  on a.m_id = e.m_id
  LEFT JOIN zone f 
  on e.z_id = f.z_id
  ") or die(mysqli_error($conn));
$oldid="";
$i=1;
while ($rs = mysqli_fetch_assoc($sql)) { 
  $user = explode(' ',$rs['m_name']); 

  if($oldid!=$rs['m_id']){
   if($oldid!=""){
    echo "<b>ด้านหลัง</b> ";
    echo "<div>";
  }
  echo "<b>แสดงครั้งเดียว</b>";
  echo "คุณ $user[0]".'<br>';
    
}
    
echo $rs['z_name']." ";
echo "<b>ซ้ำ </b>";  
$oldid=$rs['m_id'];
} 
echo "</div>";
?>

<hr>
<hr>

<table class="table table-bordered table-responsive">
  <thead>
    <tr>
      <th>ชื่อ</th>
      <th>พื้นที่รับผิดชอบ</th>
    </tr>
  </thead>
  <tbody>
 
    <?php $sql = mysqli_query($conn,"SELECT * FROM member a
      LEFT JOIN position c 
      on a.p_id = c.p_id
      LEFT JOIN division d 
      on a.dv_id = d.dv_id
      LEFT JOIN area_zone e
      on a.m_id = e.m_id
      LEFT JOIN zone f 
      on e.z_id = f.z_id
      ") or die(mysqli_error($conn));
    $oldid="";
    $i=1;
    while ($rs = mysqli_fetch_assoc($sql)) { 
      $user = explode(' ',$rs['m_name']); 

      if($oldid!=$rs['m_id']){

       if($oldid!=""){
        echo "<b>ปิดข้างขวา</b> ";
        echo '</td>
        </tr>';
      }

      echo " <tr>
      <td>แสดงครั้งเดียว คุณ $user[0]</td>
      <td> ";

    }

    echo $rs['z_name']." ";
    echo "<b>ซ้ำ</b>";  
    $oldid=$rs['m_id'];
  } 
  echo "<b>ด้านท้าย</b> ";
  echo '</td>
  </tr>';
  ?>
</tbody>
</table>
<hr><hr>

<?php  require_once '../link_js/link_js.php';  

?>
<script type="text/javascript">
  $(document).ready(function() {
    $("#data_position").DataTable();
  });
</script>
</body>
</html>
