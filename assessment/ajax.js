 $(".insert_success").on('click', function(event) {
 	event.preventDefault();
 	var insert_success = "insert_success";
 	var id = $(this).data('id');
 	swal({
 		title: "ยืนยันคำตอบ?",
 		text: "คุณแน่ใจหรือไม่ที่จะให้ผ่าน!",
 		type: "warning",
 		showCancelButton: true,
 		cancelButtonText: "ไม่, ยกเลิก!",
 		confirmButtonColor: "#DD6B55",
 		confirmButtonText: "ใช่,ฉันแน่ใจ!",
 		closeOnConfirm: false
 	},
 	function(){
 		$.ajax({
 			url: "manages.php",
 			type:"POST",
 			dataType: "json",
 			data : {"id":id,"insert_success": insert_success},
 			success:function(data){
 				if(data =="1"){
 					swal({
 						title: "ผ่านการตรวจ",
 						text: "ผ่านการตรวจงานเรียบร้อยแล้ว!",
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




 $(".faild").click(function(event) {
 	event.preventDefault();
 	var id = $(this).data('id');
 	$("#idx").val(id);
 });

 $("#failed_assess").on('submit', function(event) {
 	event.preventDefault();
 	var not_success = "not_success";
 	var id = $(this).data('id');
 	$.ajax({
 		url: "manages.php",
 		type:"POST",
 		dataType: "json",
 		data : $(this).serialize() +"&not_success=" + not_success,
 		success:function(data){
 			if(data =="1"){
 				setTimeout(function(){
 					$("#insert_ws_assess").modal('hide');
 				},200);
 				setTimeout(function(){
 					swal({
 						title: "ผ่านการตรวจ",
 						text: "ผ่านการตรวจงานเรียบร้อยแล้ว!",
 						type: "success",
 						showCancelButton: false,
 						confirmButtonColor: "#DD6B55",
 						confirmButtonText: "ปิด!",
 						closeOnConfirm: false
 					},
 					function(){
 						window.location.reload();
 					});
 				},500)
 				
 			}
 		}

 	});
 });


