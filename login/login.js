$('#form_login').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    url: "login/manage_login.php",
    type:"POST",
    dataType: "json",
    data : $(this).serialize(),
    success:function(data){
      console.log(data.number);
      if(data.number == '1'){
        window.location = data.url;
      }else{
       setTimeout(function(){
         $("#myAlert").show('fade');
       },1000);
     }
   }

 });
});
 


 $('#forgot_password').on('submit', function(e) {
  e.preventDefault();
  var forgot = "forgot_password";
  $.ajax({
    url: "login/manage_login.php",
    type:"POST",
    dataType: "json",
    data : $(this).serialize()+ "&forgot=" + forgot,
    success:function(data){
      if(data.data == '1'){
       
      }else{
       setTimeout(function(){
         $("#alert_pass").show('fade');
       },1000);
     }
   }

 });
});

 