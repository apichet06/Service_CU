<?php 
require_once "../db/config.php";


if (mysqli_real_escape_string($conn,$_POST['login'] == 'login')) {
	session_start();
	if(isset($_POST['username']) && isset($_POST['password'])){

		$username = mysqli_real_escape_string($conn,$_POST['username']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);


		$sql = "SELECT username FROM member WHERE   username = '$username' and password = '$password'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$active = $row['username'];

		$count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

		if($count == 1) {
   //session_register("username");
			$_SESSION['login_user'] = $active;
			$number = "1";
			$url = 'home/index.php';
		}else {
			
			$number = "0";
			$url = "-";
		}
		$xx = array(
			'number'  => $number,
			'url' => $url
		);
		echo json_encode($xx);
	}
	
}	


if($_POST['forgot'] == "forgot_password"){
    
	// $email = mysqli_escape_string($conn,$_POST['email']);

	// $sql = mysqli_query($conn,"SELECT * FROM member Where email = '$email' ");
 //     $rs = mysqli_fetch_assoc($sql);
	// if(mysqli_num_rows($sql) <= 0){

	// 	$show  = "0";

	// }else{

	require_once '../PHPMailer/src/Exception.php';
	require_once '../PHPMailer/src/OAuth.php';
	require_once '../PHPMailer/src/SMTP.php';
	require_once '../PHPMailer/src/PHPMailer.php';
	$from = "souqmajid.qt@gmail.com";

	$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP(); // enable SMTP

$mail->Debugoutput = 'html';
$mail->CharSet = "UTF-8";
$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail  tls , ssl
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587 , 465
$mail->IsHTML(true);
$mail->Username = "$from";
$mail->Password = "DevX@2020";


// $mail->SetFrom("$from");
$mail->SetFrom("apichet12011990@gmail.com","cloudwork.cloud");
// $mail->AddCC('sk.lerdsappasuk@gmail.com');

// get Email ปลายทาง
$EmailTo 	= 'apichet06@gmail.com';

$subject 	= "cloudwork.cloud";
$msg     = "<meta charset='utf-8'>";
$msg     = "สวัสดี คุณอภิเชษฐ์ สิงห์นาครอง <br>";
$msg    .= "ตามที่คุณอภิเชษฐ์ ได้แจ้งว่าลืมรหัสผ่านในการเข้าใช้งานระบบCloudwork ระบบได้ทำการ Reset รหัสผ่านของคุณเรียบร้อยแล้ว <br>";
$msg    .= "โดย <br>";
$msg    .= "รหัสผ่านเดิมของคุณคือ : 123456 <br> ระบบได้ทำการเปลี่ยนรหัสผ่านใหม่เพื่อความปลอดภัย <br>";
$msg    .= "New Password : ".strtotime(date('Y-m-d H:i:s'))." <br>";
$msg    .= "สามารถเข้าใช้งานได้ที่ http://cloudwork.cloud/service/index.php <br>";
$mail->Subject = $subject;

$mail->Body = $msg;


$mail->AddAddress($EmailTo);
$mail->Send();
// if(!$mail->Send()) {
//     echo "Mailer Error: " . $mail->ErrorInfo;
// 	return false;
// 	} else {
//     echo "Message sent!";
// 	return true;
// }


// 	require '../phpmailer1/PHPMailerAutoload.php';
// 	require '../phpmailer1/class.phpmailer.php'; 
// 	//header('Content-Type: text/html; charset=utf-8');

// $mail = new PHPMailer;
// $mail->CharSet = "utf-8";
// $mail->isSMTP();
// $mail->isHTML(true);
// $mail->Host = 'smtp.gmail.com';
// $mail->Port = 587;
// $mail->SMTPSecure = 'tls'; // ssl/tls
// $mail->SMTPAuth = true;
// $mail->SMTPDebug = 0;

// $gmail_username = "souqmajid.qt@gmail.com"; // gmail ที่ใช้ส่งsouqmajid.qt@gmail.com
// $gmail_password = "DevX@2020"; // รหัสผ่าน gmailDevX@2020
// // ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1

// $sender = "อภิเชษฐ์ สิงห์นาครอง"; // ชื่อผู้ส่ง
// $email_sender = "apichet12011990@gmail.com"; // เมล์ผู้ส่ง 
// $email_receiver = "apichet06@gmail.com"; // เมล์ผู้รับ ***

// $subject = "เปลี่ยนรหัสผ่าน"; // หัวข้อเมล์


// $mail->Username = $gmail_username;
// $mail->Password = $gmail_password;
// $mail->setFrom($email_sender, $sender);
// $mail->addAddress($email_receiver);
// $mail->Subject = $subject;

// $email_content = "ทดสอบบบบบบบบบบบบบบบบ";

// //  ถ้ามี email ผู้รับ
// if($email_receiver){
// 	$mail->msgHTML($email_content);

//     if (!$mail->send()) {  // สั่งให้ส่ง email

//         // กรณีส่ง email ไม่สำเร็จ
//     	echo "<h3 class='text-center'>ระบบมีปัญหา กรุณาลองใหม่อีกครั้ง</h3>";
//         echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
//     }else{
//         // กรณีส่ง email สำเร็จ
//     	echo "ระบบได้ส่งข้อความไปเรียบร้อย";
//     }   
// }


// require_once("../phpmailer1/class.phpmailer.php"); 
// require_once("../phpmailer1/class.smtp.php");


// $mail = new PHPMailer();   
// $mail->IsHTML(true);   
// $mail->IsSMTP();  
// $mail->CharSet = "utf-8";
// $mail->SMTPAuth = true; // enable SMTP authentication  
// $mail->SMTPSecure = "ssl"; // sets the prefix to the servier  
// $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server   
// $mail->Port = 465; // set the SMTP port for the GMAIL server   
// $mail->Username = "souqmajid.qt@gmail.com"; // GMAIL username    
// $mail->Password = "DevX@2020"; // GMAIL password    
// $mail->From = "souqmajid.qt@gmail.com"; // "name@yourdomain.com";   
// //$mail->AddReplyTo = "mail@hotmail.com"; // Reply   
// $mail->FromName = "Miss Nardanong Sukbua";  // set from Name   
// $mail->Subject = "Sending mail with PHPMailer.";    
// $mail->Body = "My Body & <b>My Description</b>";   
// $mail->AddAddress("apichet06@gmail.com", "Mr.Apichet Singnakrong"); // to Address   
// //$mail->AddAttachment("zip/PHPMailer_v5.1.zip");   
// //$mail->AddAttachment("zip/PHPMailer_v5.2.zip");   
// //$mail->AddCC("mail2@hotmail.com", "Miss Nardanong Sukbua"); //CC   
// //$mail->AddBCC("mail3@hotmail.com", "Mr.Member ShotDev"); //BCC 

// $mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low :Security

// if(!$mail->Send()) {
//     echo "Mailer Error: " . $mail->ErrorInfo;
// 	return false;
// 	} else {
//     echo "Message sent!";
// 	return true;
// }



$show  = "1";

//}

$name = array('data' => $show);
echo json_encode($name);

}

?>
