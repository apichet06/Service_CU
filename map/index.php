<!DOCTYPE html>
<html>
<head>
  <title>Simple Map</title>
  <meta name="viewport" content="initial-scale=1.0">
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <meta charset="utf-8">
  <?php require_once '../db/config.php'; ?>
 <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {
        var mapOptions = {
          center: {lat: 13.847860, lng: 100.604274},
          zoom: 10,
        }
        
        var maps = new google.maps.Map(document.getElementById("map"),mapOptions);

        var marker, info;

        $.getJSON( "json.php", function( jsonObj ) {

          //*** loop
          $.each(jsonObj, function(i, item){
           console.log(item.gps);
           marker = new google.maps.Marker({
             position: new google.maps.LatLng(item.gps),
             map: maps,
               //title: item.LOC_NAME
             });

           info = new google.maps.InfoWindow();

           google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              info.setContent(item.LOC_NAME);
              info.open(maps, marker);
            }
          })(marker, i));

          }); // loop

        });

      }
      <?php $sql = mysqli_query($conn,"SELECT * FROM job_in_out Where m_id LIKE '%5%' ");
      $rs = mysqli_fetch_assoc($sql);
      $gps = $rs['gps'];
      ?>
      function init_map() {
        var map_options = {
          zoom: 15,
          center: new google.maps.LatLng(<?=$gps;?>)
        }
        map = new google.maps.Map(document.getElementById("map"), map_options);
        
        marker = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(<?=$gps;?>)
        });
      }


        // infowindow = new google.maps.InfoWindow({
        //     content: data['formatted_address']
        // });


      </script>

      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIZHyafwGyQUKJCyBK1jgHd1VqGQ8fnr4&callback=init_map" async defer></script>
    </body>
    </html>
