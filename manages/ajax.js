$(document).ready(function() {
  $('#demoSelect,.demoSelect').select2();
});
$('#insert-division').on('submit', function(e) {
  e.preventDefault();
  var insert = "insert_division";
  $.ajax({
    url: "manages.php",
    type:"POST",
    dataType: "json",
    data : $(this).serialize() + '&insert=' + insert,
    success:function(data){

      if(data=="1"){
        swal({
          title: "บันทึกข้อมูล",
          text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }
    }

  });
});

$('.del_division').click(function(event) {
 event.preventDefault();
 var del = "del_division";
 var id = $(this).data('id');
 swal({
  title: "ยืนยันการลบ?",
  text: "คุณแน่ใจหรือไม่ที่จะลบ!",
  type: "warning",
  showCancelButton: true,
  cancelButtonText: "ไม่, ยกเลิก!",
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "ใช่,ฉันต้องการลบ!",
  closeOnConfirm: false
},
function(){

 $.ajax({
  url: "manages.php",
  type:"POST",
  dataType: "json",
  data : {"id":id,"del_division": del},
  success:function(data){
    if(data =="1"){
      swal({
        title: "ลบข้อมูล",
        text: "ลบข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }
  }

});
});

});

$('.update_division').click(function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  var dv_name = $(this).data('dv_name');
  var dv_name_short = $(this).data('dv_name_short');

  $('#dv_id').val(id);
  $('#dv_name').val(dv_name);
  $('#dv_name_short').val(dv_name_short);

});

$('#update_idvision').on('submit', function(e) {
  e.preventDefault();
  var update = "update_idvision";
  $.ajax({
   url: 'manages.php',
   type: 'POST',
   dataType: 'json',
   data : $(this).serialize() + '&update_idvision=' + update,
   success: function(data) {
    if(data =="1"){
      setTimeout(function(){
        $('#update_division').modal('hide');
      },500);

      setTimeout(function(){
        swal({
          title: "แก้ไขข้อมูล",
          text: "แก้ไขข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        })
      },1000);  


    }

  },

});

  
});

//ตำแหน่ง


$('#insert-position').on('submit', function(e) {
  e.preventDefault();
  var insert = "insert_position";
  $.ajax({
    url: "manages.php",
    type:"POST",
    dataType: "json",
    data : $(this).serialize() + '&insert=' + insert,
    success:function(data){

      if(data=="1"){
        swal({
          title: "บันทึกข้อมูล",
          text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }
    }

  });
});

$('.update_position').click(function(e) {
  e.preventDefault();
  var id              = $(this).data('p_id');
  var p_name          = $(this).data('p_name');
  var p_hort          = $(this).data('p_hort');
  var home            = $(this).data('home'); 
  var worksheet       = $(this).data('worksheet'); 
  var assessment      = $(this).data('assessment'); 
  var work_transfer   = $(this).data('work_transfer'); 
  var mechanic_work   = $(this).data('mechanic_work'); 
  var work_in_out     = $(this).data('work_in_out'); 
  var charts          = $(this).data('charts'); 
  var manages         = $(this).data('manages'); 
  
   
  
  $('#p_id').val(id);
  $('#p_name').val(p_name);
  $('#p_hort').val(p_hort);
  $('#home').prop("checked", home);
  $('#worksheet').prop("checked", worksheet);
  $('#assessment').prop("checked", assessment);
  $('#work_transfer').prop("checked", work_transfer);
  $('#mechanic_work').prop("checked", mechanic_work);
  $('#work_in_out').prop("checked", work_in_out);
  $('#charts').prop("checked", charts);
  $('#manages').prop("checked", manages);

});

$('#position').on('submit', function(e) {
  e.preventDefault();
  var update = "update_position";
  $.ajax({
   url: 'manages.php',
   type: 'POST',
   dataType: 'json',
   data : $(this).serialize() + '&update_position=' + update,
   success: function(data) {
    if(data =="1"){
      setTimeout(function(){
        $('#update_position').modal('hide');
      },500);

      setTimeout(function(){
        swal({
          title: "แก้ไขข้อมูล",
          text: "แก้ไขข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        })
      },1000);  


    }

  },

});

  
});

$('.del_position').click(function(event) {
 event.preventDefault();
 var del = "del_position";
 var p_id = $(this).data('p_id');
 swal({
  title: "ยืนยันการลบ?",
  text: "คุณแน่ใจหรือไม่ที่จะลบ!",
  type: "warning",
  showCancelButton: true,
  cancelButtonText: "ไม่, ยกเลิก!",
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "ใช่,ฉันต้องการลบ!",
  closeOnConfirm: false
},
function(){

 $.ajax({
  url: "manages.php",
  type:"POST",
  dataType: "json",
  data : {"p_id":p_id,"del_position": del},
  success:function(data){
    if(data =="1"){
      swal({
        title: "ลบข้อมูล",
        text: "ลบข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }
  }

});
});

});

$("#place").on('submit',function(e) {
  e.preventDefault();

  var insert = "insert_place";
  $.ajax({
    url: 'manages.php',
    type: 'post',
    dataType: 'json',
    data: $(this).serialize() +'&insert_place=' + insert ,
    success : function(data){
      if(data=="1"){
        swal({
          title: "บันทึกข้อมูล",
          text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }else if(data =="2"){
        swal({
          title: "รายการนี้มีอยู่แล้ว",
          text: "ไม่สามารถบันทึกข้อมูลได้!",
          type: "error",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        })
      }
    }
  })
});


$('.del_place').click(function(event) {
 event.preventDefault();
 var del = "del_place";
 var id = $(this).data('place_id');
 swal({
  title: "ยืนยันการลบ?",
  text: "คุณแน่ใจหรือไม่ที่จะลบ!",
  type: "warning",
  showCancelButton: true,
  cancelButtonText: "ไม่, ยกเลิก!",
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "ใช่,ฉันต้องการลบ!",
  closeOnConfirm: false
},
function(){
 $.ajax({
  url: "manages.php",
  type:"POST",
  dataType: "json",
  data : {"place_id":id,"del_place": del},
  success:function(data){
    if(data =="1"){
      swal({
        title: "ลบข้อมูล",
        text: "ลบข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }else if(data =="2"){
      swal({
        title: "ลบข้อมูล",
        text: "ข้อมูลมีการใช้งานอยู่ไม่สามารถลบได้!",
        type: "error",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      });
    }
  }

});
});

});

$('.update_place').click(function(e) {
  e.preventDefault();
  var place_id = $(this).data('place_id');
  var z_id = $(this).data('z_id');
  var place_name = $(this).data('place_name');
  console.log(place_name);
  $("#place_id").val(place_id);
  $("#z_id").val(z_id);
  $("#place_name").val(place_name);

});


$('#place_x').on('submit', function(e) {
  e.preventDefault();
  var update = "update_place";
  $.ajax({
   url: 'manages.php',
   type: 'POST',
   dataType: 'json',
   data : $(this).serialize() + '&update_place=' + update,
   success: function(data) {
    if(data =="1"){
      setTimeout(function(){
        $('#update_place').modal('hide');
      },500);

      setTimeout(function(){
        swal({
          title: "แก้ไขข้อมูล",
          text: "แก้ไขข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        })
      },1000);  


    }else if(data =="2"){
      swal({
        title: "ชื่อรายการนี้มีอยู่แล้ว",
        text: "ไม่สามารถแก้ไขข้อมูลได้!",
        type: "error",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      })
    }

  },

});  
});


$('#insert-mamber').on('submit', function(e) {
  e.preventDefault();
  var insert = "insert_member";
  $.ajax({
    url: "manages.php",
    type:"POST",
    dataType: "json",
    data : $(this).serialize() + '&insert=' + insert,
    success:function(data){
     // console.log(data);
     if(data=="1"){
      swal({
        title: "บันทึกข้อมูล",
        text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }else if(data =="11"){
      setTimeout(function(){
       $("#myAlert").show('fade');
     },200);
    }
  }

});
});


$('.del_member').click(function(event) {
 event.preventDefault();
 var del = "del_member";
 var id = $(this).data('m_id');
 console.log(id);
 swal({
  title: "ยืนยันการลบ?",
  text: "คุณแน่ใจหรือไม่ที่จะลบ!",
  type: "warning",
  showCancelButton: true,
  cancelButtonText: "ไม่, ยกเลิก!",
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "ใช่,ฉันต้องการลบ!",
  closeOnConfirm: false
},
function(){
 $.ajax({
  url: "manages.php",
  type:"POST",
  dataType: "json",
  data : {"m_id":id,"del_member": del},
  success:function(data){
    if(data =="1"){
      swal({
        title: "ลบข้อมูล",
        text: "ลบข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }
  }

});
});

});

$(".c_up_member").click(function(e) {
  e.preventDefault();
  var m_id = $(this).data('m_id');
  var m_name = $(this).data('m_name');
  var m_lname = $(this).data('m_lname');
  var p_id = $(this).data('p_id');
  var z_id = $(this).data('z_id');
  var dv_id = $(this).data('dv_id');
  var m_phone = $(this).data('m_phone');
  var username = $(this).data('username');
  var photograph = $(this).data('photograph');
  var pass = $(this).data('pass');
  var email = $(this).data('email');

  $('#m_id').val(m_id);
  $('#m_name').val(m_name);
  $('#m_lname').val(m_lname);
  $('#p_id_x').val(p_id);
  $('#z_id_x').val(z_id).trigger('change');
  $('#dv_id_x').val(dv_id);
  $('#m_phone').val(m_phone);
  $('#username').val(username);
  $('#password').val(pass);
  $('#photograph').val(photograph);
  $('#email').val(email);
});

$('#update-mamber').on('submit', function(e) {
  e.preventDefault();
  var update_member = "update_member";
  $.ajax({
    url: 'manages.php',
    type: 'post',
    dataType: 'json',
    data: $(this).serialize()+ "&update_member=" + update_member,
    success : function(data){

      if(data =="1"){
        setTimeout(function(){
          $('#update_member').modal('hide');
        },500);

        setTimeout(function(){
          swal({
            title: "แก้ไขข้อมูล",
            text: "แก้ไขข้อมูลเรียบร้อยแล้ว!",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ปิด!",
            closeOnConfirm: false
          },
          function(){
            window.location.reload();
          })
        },1000);  
      }else if(data =="11"){
        setTimeout(function(){
         $("#myAlert_update_m").show('fade');
       },200);
      }
    }
  })
});

$('#insert-category').on('submit', function(event) {
  event.preventDefault(); 
  var insert = "insert_category";
  $.ajax({
    url: 'manages.php',
    type: 'POST',
    dataType: 'json',
    data: $(this).serialize() +"&insert_category=" + insert,
    success : function(data){
      if(data=="1"){
        swal({
          title: "บันทึกข้อมูล",
          text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }else if(data=="2"){

       swal({
        title: "รายการนี้มีอยู่แล้ว",
        text: "ไม่สามารถบันทึกข้อมูลได้!",
        type: "error",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      });
     }
   }
 })
});


$(".update_cate").click(function(event) {
 event.preventDefault();
 var c_id = $(this).data('id');
 var c_name = $(this).data('c_name');

 $("#c_id_c").val(c_id);
 $("#c_name").val(c_name);
});

$('#update_category').on('submit', function(e) {
  e.preventDefault();
  var update_category = "update_category";
  $.ajax({
    url: 'manages.php',
    type: 'post',
    dataType: 'json',
    data: $(this).serialize()+ "&update_category=" + update_category,
    success : function(data){
      console.log(data);
      if(data =="1"){
        setTimeout(function(){
          $('#update-category').modal('hide');
        },500);

        setTimeout(function(){
          swal({
            title: "แก้ไขข้อมูล",
            text: "แก้ไขข้อมูลเรียบร้อยแล้ว!",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ปิด!",
            closeOnConfirm: false
          },
          function(){
            window.location.reload();
          })
        },1000);  

      }else if(data=="2"){
        setTimeout(function(){
          $('#update-category').modal('hide');
        },500);
        swal({
          title: "รายการนี้มีอยู่แล้ว",
          text: "ไม่สามารถแก้ไขข้อมูลได้!",
          type: "error",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        });
      }
    }
  })
});

$(".del_cate").click(function(e) {
  e.preventDefault();
  var c_id = $(this).data("id");
  var del  = "del_category";
  swal({
    title: "ยืนยันการลบ?",
    text: "คุณแน่ใจหรือไม่ที่จะลบ!",
    type: "warning",
    showCancelButton: true,
    cancelButtonText: "ไม่, ยกเลิก!",
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "ใช่,ฉันต้องการลบ!",
    closeOnConfirm: false
  },
  function(){
   $.ajax({
    url: "manages.php",
    type:"POST",
    dataType: "json",
    data : {"c_id":c_id,"del_category": del},
    success:function(data){
      if(data =="1"){
        swal({
          title: "ลบข้อมูล",
          text: "ลบข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }
    }

  });
 });

});


$('#insert_pending').on('submit', function(event) {
  event.preventDefault();
  var insert = "insert_pending";
  $.ajax({
    url: 'manages.php',
    type: 'POST',
    data: $(this).serialize()+"&insert_pending=" + insert,
    success : function(data){
     window.location.reload();
   }
 })

  
});


$('.working_day').click(function(event) {
 event.preventDefault();
 var m_id = $(this).data('m_id');
 
 $('#m_id_update_schedule').val(m_id);
 $.ajax({
   url: 'view_work_today.php',
   type: 'POST',
   dataType: 'json',
   data: {'m_id': m_id },
   success: function(data){
     $("#show_view").html(data.data);
   }
 })
});

$('#update_working_day').on('submit', function(event) {
 event.preventDefault();
 var update = "update_working_day";
 $.ajax({
  url: 'manages.php',
  type: 'POST',
  dataType: 'json',
  data: $(this).serialize()+"&update_working_day="+ update,
  success:function(data){
    console.log(data.data);
    if(data.data =='1'){
      $('#working_day').modal("hide");
      setTimeout(function(){
       window.location.reload();
     },1000);

    }
  }
})
})


$(".edit_zone").click(function(event) {
  var id     = $(this).data("id");
  var z_name = $(this).data("z_name");

  $("#z_id_zone").val(id);
  $("#z_name").val(z_name);
});

$("#update_zone").on('submit', function(event) {
  event.preventDefault();
  var update = "update_zone";
  $.ajax({
    url: 'manages.php',
    type: 'POST',
    dataType: 'json',
    data: $(this).serialize()+ "&update_zone="+update,
    success :function(data){
      if(data.data =="1"){
        $("#edit_zone").modal("hide");
        swal({
          title: "แก้ไขข้อมูล",
          text: "แก้ไขข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });   
      }
      //console.log(data.data);
    }
  })
  
});

$("#insert_zone").on('submit', function(event) {
  event.preventDefault();
  var insert = "insert_zone";
  $.ajax({
   url: 'manages.php',
   type: 'POST',
   dataType: 'json',
   data: $(this).serialize()+ "&insert_zone="+ insert,
   success :function(data){
    console.log(data);
    if(data.data =="1"){
      swal({
        title: "บันทึกข้อมูล",
        text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }
  }
})

});

$(".del_zone").click(function(event) {
  event.preventDefault();
  $.ajax({
    url: 'manages.php',
    type: 'POST',
    dataType: 'json',
    data: {'z_id': $(this).data('id')},
    success:function(data){
      if(data.data == "1"){
        swal({
          title: "ลบข้อมูล",
          text: "ลบข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }
    }


  })

  
});

$(".del_zone").click(function(e) {
  e.preventDefault();
  var z_id = $(this).data("id");
  var del  = "del_zone";
  swal({
    title: "ยืนยันการลบ?",
    text: "คุณแน่ใจหรือไม่ที่จะลบ!",
    type: "warning",
    showCancelButton: true,
    cancelButtonText: "ไม่, ยกเลิก!",
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "ใช่,ฉันต้องการลบ!",
    closeOnConfirm: false
  },
  function(){
   $.ajax({
    url: "manages.php",
    type:"POST",
    dataType: "json",
    data : {"z_id":z_id,"del_zone": del},
    success:function(data){
      if(data.data =="1"){
        swal({
          title: "ลบข้อมูล",
          text: "ลบข้อมูลเรียบร้อยแล้ว!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ปิด!",
          closeOnConfirm: false
        },
        function(){
          window.location.reload();
        });
      }
    }

  });
 });

});
 


$('#update_comm').on('submit', function(e) {
  e.preventDefault();
  var fd = new FormData(this);
    var todo = "update_comm";
    fd.append('update_comm',todo);
 $.ajax({
      url  : "manages.php",
      type : "POST",
      dataType: "json",
      data :fd,
      contentType:false,
      cach:false,
      processData:false, 
    success:function(data){
     //console.log(data.data);
     if(data.data=="1"){
      swal({
        title: "บันทึกข้อมูล",
        text: "บันทึกข้อมูลเรียบร้อยแล้ว!",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ปิด!",
        closeOnConfirm: false
      },
      function(){
        window.location.reload();
      });
    }
  }

});
});