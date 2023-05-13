<?php if ($_SERVER['REQUEST_URI'] == '/service/index.php' or $_SERVER['REQUEST_URI'] == '/service/') {  ?>

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
  <!-- js รายการ datetimepeker -->
  <script  src="js/moment.min.js"></script>
  <script src="js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
  <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="js/plugins/select2.min.js"></script>

<?php }else{ ?>

  <!-- Essential javascripts for application to work-->
  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>

  <!-- js รายการ datetimepeker -->
  <script  src="../js/moment.min.js"></script>
  <script src="../js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="../js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <script type="text/javascript" src="../js/plugins/bootstrap-notify.min.js"></script>
  <script type="text/javascript" src="../js/plugins/sweetalert.min.js"></script>
  <script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/plugins/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script type="text/javascript" src="../js/ekko-lightbox.min.js"></script>
  <script type="text/javascript" src="../js/file_upload_with_preview.min.js"></script>
<?php } ?>

<script language="javascript">
  function datepersec(){
    now = new Date(); 
    var thday = new Array ("อาทิตย์","จันทร์",
      "อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์"); 
    var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
      "เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
      "ตุลาคม","พฤศจิกายน","ธันวาคม");

    var hour=''+ now.getHours();
    var min=''+ now.getMinutes();
    var sec= ''+ now.getSeconds();

    if(sec.length < 2){
      sec = '0' + sec;
    }
    if(min.length < 2){
      min = '0' + min;
    }
    if(hour.length < 2){
      hour = '0' + hour;
    }

    var datenow = "วัน" + thday[now.getDay()]+ "ที่ "+ now.getDate()+ " " + 
    thmonth[now.getMonth()]+ " " + (now.getFullYear()+543) + "&nbsp;&nbsp; เวลา " + hour +":"+ min + ":" + sec + " น." ;
    document.getElementById("datetime").innerHTML = datenow;
            //console.log(datenow);
          }
          timeout();
          function timeout(){
            setTimeout(function(){ 
              datepersec(); 
              timeout();
            }, 1000);
          }



          $("#alert_pass").hide();
          $("#re_password").on('submit', function(event) {
            event.preventDefault();

            var password1 = $("#password1").val();
            var password2 = $("#password2").val();

            if(password1!=password2){
             $("#alert_pass").show();
             return false;
           }
           $.ajax({
            url: '../menu/manages_password.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success:function(data){
             if(data.data=="1"){
               $("#re_pass").modal('hide');
               setTimeout(function(){
                swal({
                  title: "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว!",
                  text: "จำเป็นต้องออกจากระบบเพื่อเข้าใข้งานใหม่!",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "ปิด!",
                  closeOnConfirm: false
                },
                function(){
                  window.location.href = '../index.php'
                });
              },300)
             }

           }
         })
         });

          /*******************************/
          /***  active เมนู รายการที่เลิอก   ***/
          /*******************************/
          
          jQuery(document).ready(function($) {
            var path = window.location.pathname;
            path = path.replace(/\/$/, "");
            path = decodeURIComponent(path);
            $(".app-menu a").each(function () { 
              var href = $(this).attr('href').substring(2);    
              if (path.substring(8, href.length+10) === href) {
               $(this).closest('li a').addClass('active');
               $(this).closest('.treeview').addClass('is-expanded');
             }
           });
          });
            
          /*********************************/

      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
     if(document.location.hostname == 'pratikborsadiya.in') {
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
       (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
       m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
     })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
     ga('create', 'UA-72504830-1', 'auto');
     ga('send', 'pageview');
   }
 </script>
