//  $("#alert_pass").hide();
//  $("#re_password").on('submit', function(event) {
//   event.preventDefault();

//   var password1 = $("#password1").val();
//   var password2 = $("#password2").val();
  
//   if(password1!=password2){
//    $("#alert_pass").show();
//    return false;
//  }
//  $.ajax({
//   url: '../menu/manages_password.php',
//   type: 'POST',
//   dataType: 'json',
//   data: $(this).serialize(),
//   success:function(data){
//    if(data.data=="1"){
//      $("#re_pass").modal('hide');
//      setTimeout(function(){
//       swal({
//         title: "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว!",
//         text: "จำเป็นต้องออกจากระบบเพื่อเข้าใข้งานใหม่!",
//         type: "success",
//         showCancelButton: false,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "ปิด!",
//         closeOnConfirm: false
//       },
//       function(){
//         window.location.href = '../index.php'
//       });
//     },300)
//    }

//  }
// })
// });