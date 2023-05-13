 <?php 
    $date = date("Y");
    $sql = mysqli_query($conn,"SELECT dv_name_short,dv_name,count(a.dv_id) as dv_sum FROM worksheet a 
      RIGHT JOIN division b
      on b.dv_id = a.dv_id 
      GROUP BY b.dv_id ")or die(mysqli_error($conn)); 
    $dv_name       = array();
    $dv_sum        = array();
    while ($rs = mysqli_fetch_assoc($sql)) {

      array_push($dv_name,$rs['dv_name']." (".$rs['dv_name_short'].")");
      array_push($dv_sum,$rs['dv_sum']);
    }
    ?>
    <script type="text/javascript">
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['<?=implode("','",$dv_name);?>'],
          datasets: [{

            data: ['<?=implode("','",$dv_sum);?>'],
            backgroundColor: [
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(255, 99, 132, 0.8)',
            ],
            borderColor: [
            'rgba(255,255,255, 5)',
            'rgba(255,255,255, 5)',
            'rgba(255,255,255, 5)',
            'rgba(255,255,255, 5)',
            'rgba(255,255,255, 5)',
            'rgba(255,255,255, 5)',
            ],
            borderWidth: 1.5
          }]
        }
      });
    </script>