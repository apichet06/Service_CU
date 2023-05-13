<?php 
error_reporting(~E_NOTICE); //ปิด  error (Notice: Undefined index:)

// $servername = "devx.co.th";
// $username = "devxcoth_xservice";
// $password = "8MVXucn4e";
// $db = "devxcoth_xservice";

// $servername = "localhost";
// $username = "cloudwor";
// $password = "Nxg*z5Q5Gu3O:6";
// $db = "cloudwor_service2";

$servername = "localhost";
$username = "root";
$password = "";
$db = "cloudwor_service";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);
        date_default_timezone_set("Asia/Bangkok");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

$thai_day_arr=array("อ.","จ.","อ.","พ.","พฤ.","ศ.","ส.");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"ม.ค.",
    "2"=>"ก.พ.",
    "3"=>"มี.ค.",
    "4"=>"เม.ย.",
    "5"=>"พ.ค.",
    "6"=>"มิ.ย.", 
    "7"=>"ก.ค.",
    "8"=>"ส.ค.",
    "9"=>"ก.ย.",
    "10"=>"ต.ค.",
    "11"=>"พ.ย.",
    "12"=>"ธ.ค"                 
);
function thai_date($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="".$thai_day_arr[date("w",$time)];
    $thai_date_return.= " ".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
	//$thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " ".(date("Y",$time)+543-2500);
    //$thai_date_return.= "  ".date("H:i",$time)." น.";
    return $thai_date_return;
}

?>