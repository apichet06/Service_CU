<script type="text/javascript">

  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
     labels: ['<?=implode("','",$c_name);?>'],
     datasets: [{
      data: ['<?=implode("','",$x);?>'],
      backgroundColor: [
      'rgba(36, 209, 243, 0.8)',
      'rgba(233, 36, 243, 0.8)',
      'rgba(249, 204, 41, 0.8)',
      'rgba(32, 119, 28, 0.8)',
      'rgba(0, 0, 255, 0.8)',
      'rgba(128, 0, 128, 0.8)',
      'rgba(255, 99, 132, 0.8)',
      'rgba(54, 162, 235, 0.8)',
      'rgba(255, 206, 86, 0.8)',
      'rgba(75, 192, 192, 0.8)',
      'rgba(153, 102, 255, 0.8)',
      'rgba(255, 159, 64, 0.8)'
      ],
      borderColor: [
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      ],
      borderWidth: 2
    }]
  }
});

  var ctx = document.getElementById('myChart0').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
     labels: ['<?=implode("','",$m_month);?>'],
    //labels: ['ม.ค', 'ก.พ', 'มี.ค', 'เม.ย', 'พ.ค', 'มิ.ย','ก.ค','ส.ค','ก.ย','ต.ค','พ.ย','ธ.ค'],
    datasets: [{
      label: 'สรุปงานแผนก PM',
      data: ['<?=implode("','",$sum_job_pm);?>'],
      backgroundColor:"rgba(255, 51, 153,0.8)",
      borderColor:"rgba(255, 51, 153,1)",
      borderWidth: 2
    },
    {
      label: "สรุปงานแผนก CM",
      backgroundColor:"rgba(0, 170, 255, 0.8)",
      borderColor:"rgba(0, 170, 255, 1)",
      data: ['<?=implode("','",$sum_job_cm);?>'],
      borderWidth: 2
    } ,
    {
      label: "สรุปงานแผนก INSTALL",
      backgroundColor:"rgba(249, 204, 41, 0.8)",
      borderColor:"rgba(249, 204, 41, 1)",
      data: ['<?=implode("','",$sum_job_ins);?>'],
      borderWidth: 2
    },
    { 
      label: "สรุปงานแผนก ADMIN",
      backgroundColor:"rgba(99, 176, 162, 0.8)",
      borderColor:"rgba(99, 176, 162, 1)",
      data: ['<?=implode("','",$sum_job_ad);?>'],
      borderWidth: 2
    }
    ]
  }
});
</script>

<?php  $date = date("Y"); 
$sql = mysqli_query($conn,"SELECT count(a.ws_sender) as sum_id , b.m_name as m_name FROM worksheet a 
 INNER JOIN member b 
 on a.ws_sender = b.m_id
 Where year(a.ws_date) = '$date' and year(a.ws_date) like '%$year%' and month(a.ws_date) like '%$m[1]%'
 group by a.ws_sender 
 order by count(a.ws_sender) desc limit 10
 "); 
$sum_id = array();
$m_name = array();
while ($rs = mysqli_fetch_assoc($sql)) { 

 array_push($sum_id,$rs['sum_id']);
 array_push($m_name,$rs['m_name']);

}

?> 

<script type="text/javascript">
//////////////////////////////////////////////////


var ctxL = document.getElementById("myChart1").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ['<?=implode("','",$m_name);?>'],
    datasets: [
    {
      label: "สร้างใบงาน",
      backgroundColor:"rgba(153, 0, 0,0.5)",
      borderColor:"rgba(153, 0, 0,1)",
      data: ['<?=implode("','",$sum_id);?>',0],
      borderWidth: 1
    } 
    ]
  },
  options: {
    responsive: true,

  } 


});
</script>
<?php  $date = date("Y"); 
$sql = mysqli_query($conn,"SELECT count(a.m_id) as sum_id , b.m_name FROM worksheet a 
 INNER JOIN member b 
 on a.m_id = b.m_id
 Where year(a.ws_date) = '$date' and year(a.ws_date) like '%$year%' and month(a.ws_date) like '%$m[1]%'
 group by a.m_id
 order by count(a.m_id) desc limit 10 "); 
$sum_id0 = array();
$m_name0 = array();
while ($rs = mysqli_fetch_assoc($sql)) { 


 array_push($sum_id0,$rs['sum_id']);
 array_push($m_name0,$rs['m_name']);

}

?> 
<script type="text/javascript">
  var ctxL = document.getElementById("myChart2").getContext('2d');
  var myLineChart = new Chart(ctxL, {
    type: 'bar',
    data: {
      labels: ['<?=implode("','",$m_name0);?>'],
      datasets: [
      {
        label: "รับใบงาน",
        backgroundColor:"rgba(32, 119, 28,0.6)",
        borderColor:"rgba(32, 119, 28,1)",
        data: ['<?=implode("','",$sum_id0);?>',0],
        borderWidth: 1
      } 
      ]
    },
    options: {
      responsive: true,

    } 


  });

</script>


<?php $sql = mysqli_query($conn,"SELECT count(b.place_id)as sum_place,a.place_name FROM place a 
  INNER JOIN worksheet b 
  ON a.place_id = b.place_id
  Where year(b.ws_date) = '$date' and year(b.ws_date) like '%$year%' and month(b.ws_date) like '%$m[1]%' 
  group by b.place_id 
  order by count(b.place_id) desc limit 10") or die(mysqli_error($conn)); 
$place_name     = array();
$sum_place      = array();
while($rs_zone   = mysqli_fetch_assoc($sql)){

  array_push($place_name,$rs_zone['place_name']);
  array_push($sum_place,$rs_zone['sum_place']);

}

?>

<script type="text/javascript">
  var ctxL = document.getElementById("service").getContext('2d');
  var myLineChart = new Chart(ctxL, {
    type: 'polarArea',
   data: {
     labels: ['<?=implode("','",$place_name);?>'],
     datasets: [{

      data: ['<?=implode("','",$sum_place);?>'],
      backgroundColor: [
      'rgba(36, 209, 243, 0.8)',
      'rgba(233, 36, 243, 0.8)',
      'rgba(249, 204, 41, 0.8)',
      'rgba(32, 119, 28, 0.8)',
      'rgba(0, 0, 255, 0.8)',
      'rgba(128, 0, 128, 0.8)',
      'rgba(255, 99, 132, 0.8)',
      'rgba(54, 162, 235, 0.8)',
      'rgba(255, 206, 86, 0.8)',
      'rgba(75, 192, 192, 0.8)',
      'rgba(153, 102, 255, 0.8)',
      'rgba(255, 159, 64, 0.8)'
      ],
      borderColor: [
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      'rgba(255,255,255, 5)',
      ],
      borderWidth: 2
    }]
    } 
  });

</script>
