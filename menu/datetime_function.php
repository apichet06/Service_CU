<?php  
                    function DateDiff_Before_timeout($Ymd,$today){

                     list($byear, $bmonth, $bday) = explode("-", $Ymd);       
                     list($tyear, $tmonth, $tday) = explode("-", $today);     

                     $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
                     $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear);
                     $mage = ($mnow - $mbirthday);

                     $u_y = date("Y", $mage) - 1970;
                     $u_m = date("m", $mage) - 1;
                     $u_d = date("d", $mage) - 1;
                     $remain=intval(strtotime($today)-strtotime($Ymd));
                     $l_wan=$remain%86400;
                      $hour=floor($l_wan/3600); //ชั่วโมง
                      $l_hour=$l_wan%3600;
                      $minute=floor($l_hour/60); //นาที
                      $second=$l_hour%60; //วินาที
                      if($hour != 0){
                      	$time =  $hour." ชม.".$minute." น.";
                      }else{
                      	$time =  $minute." น.";
                      }

                      if ($u_y === 0 and $u_m === 0 and $u_d !== 0) { 
                      	return  $y = "<span class='text-danger'>ตก SLA $u_d วัน ".$time."</span>";
                      } elseif ($u_y == 0 and $u_m != 0 and $u_d == 0) {
                      	return   $y = "<span class='text-danger'>ตก SLA $u_m เดือน</span>";
                      } elseif ($u_y == 0 and $u_m != 0 and $u_d != 0) {
                      	return   $y = "<span class='text-danger' >ตก SLA $u_m เดือน $u_d วัน</span>";
                      } elseif ($u_y != 0 and $u_m == 0 and $u_d != 0) {
                      	return   $y = "<span class='text-danger' >ตก SLA $u_y ปี $u_d วัน</span>";
                      } elseif ($u_y != 0 and $u_m != 0 and $u_d == 0) {
                      	return   $y = "<span class='text-danger'>ตก SLA $u_y ปี $u_m เดือน</span>";
                      } elseif ($u_y != 0 and $u_m != 0 and $u_d != 0) {
                      	return   $y = "<span class='text-danger'>ตก SLA $u_y ปี $u_m เดือน $u_d วัน</span>";
                      } elseif ($u_y == 0 and $u_m === 0 and $u_d == 0){
                        return  $y = "<span class='text-danger'>ตก SLA ".$time."</span>";
                      }
                    }

                  function DateDiff_Over_time($Ymd,$today){ //ก่อนหมดเวลา

                  	list($byear, $bmonth, $bday) = explode("-", $Ymd);       
                  	list($tyear, $tmonth, $tday) = explode("-", $today);     

                  	$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
                  	$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear);
                  	$mage = ($mnow - $mbirthday);

                  	$u_y = date("Y", $mage) - 1970;
                  	$u_m = date("m", $mage) - 1;
                  	$u_d = date("d", $mage) - 1;
                  	$remain=intval(strtotime($today)-strtotime($Ymd));
                  	$l_wan=$remain%86400;
                      $hour=floor($l_wan/3600); //ชั่วโมง
                      $l_hour=$l_wan%3600;
                      $minute=floor($l_hour/60); //นาที
                      $second=$l_hour%60; //วินาที
                      if($hour != 0){
                      	$time =  $hour." ชม.".$minute." น.";
                      }else{
                      	$time =  $minute." น.";
                      }

                      if ($u_y === 0 and $u_m === 0 and $u_d !== 0) { 
                      	return  $y = "<span class='text-secondary'>เหลือ $u_d วัน ".$time."</span>";
                      } elseif ($u_y == 0 and $u_m != 0 and $u_d == 0) {
                      	return   $y = "<span class='text-secondary'>เหลือ $u_m เดือน ".$time."</span>";
                      } elseif ($u_y == 0 and $u_m != 0 and $u_d != 0) {
                      	return   $y = "<span class='text-secondary' >เหลือ $u_m เดือน $u_d วัน ".$time."</span>";
                      } elseif ($u_y != 0 and $u_m == 0 and $u_d != 0) {
                      	return   $y = "<span class='text-secondary' >เหลือ $u_y ปี $u_d วัน ".$time."</span>";
                      } elseif ($u_y != 0 and $u_m != 0 and $u_d == 0) {
                      	return   $y = "<span class='text-secondary'>เหลือ $u_y ปี $u_m เดือน ".$time."</span>";
                      } elseif ($u_y != 0 and $u_m != 0 and $u_d != 0) {
                      	return   $y = "<span class='text-secondary'>เหลือ $u_y ปี $u_m เดือน $u_d วัน ".$time."</span>";
                      } elseif ($u_y == 0 and $u_m == 0 and $u_d == 0){
                        return  $y = "<span class='text-secondary'>เหลือ ".$time."</span>";
                      }
                    }

                    ?>