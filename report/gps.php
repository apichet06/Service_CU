<?php require_once '../db/config.php'; ?> 

<style>

  #map {
    height: 100%;
  }

  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style>
</head>
<body>

  <?php  $id = mysqli_escape_string($conn,$_POST['id']); 
  $sql = mysqli_query($conn,"SELECT * FROM job_in_out Where   j_inout_id like '$id' ");
  $rs = mysqli_fetch_array($sql);
  $gps = $rs['gps'];

  if($gps !="," and $gps !=""){ ?>
   <div id="map"></div>
   <script>
    function init_map() {
      var map_options = {
        zoom: 17,
        center: new google.maps.LatLng(<?=$gps?>)
      }
      map = new google.maps.Map(document.getElementById("map"), map_options);

      marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(<?=$gps?>)
      });
    }
      //const API_KEY = "aHR0cHM6Ly95b3V0dS5iZS9kUXc0dzlXZ1hjUQ==";
    </script>
    <!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIZHyafwGyQUKJCyBK1jgHd1VqGQ8fnr4&callback=init_map" ></script>
  <?php }else{ ?>
   <div class="alert alert-warning text-center" role="alert">ไม่มีพิกัดลงเวลางาน</div>
   <?php } ?>