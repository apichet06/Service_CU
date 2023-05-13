//การค้นหาช่างและค้นหาสถานที่
$("#z_id").change(function(){
	var zid = $("#z_id").val();
	var member = "member";
	//เลือกสถานที่
	var place = "place";
	$.ajax({
		url: 'combobox.php',
		method: 'post',
		data: {'zid': zid,'place':place},
		dataType: "json",
		beforeSend: function() {
			$("#reload_p").html('<img src="../img/loading4.gif" />');
		},
		success: function(json){
			$("#reload_p").html("")
			$("#place_id").html('<option value=""> ----- เลือกสถานที่ ----- </option>')
			$.each(json, function(index, value) {
				$("#place_id").append('<option value="' + value.place_id + '">' + value.place_name + '</option>');
			});
		}
	})
	//เลือกราบชื่อช่าง
	$.ajax({
		url: 'combobox.php',
		method: 'post',
		data: {'zid': zid,'member':member},
		dataType: "json",
		beforeSend: function() {
			$("#reload_m").html('<img src="../img/loading4.gif"/>');
		},
		success: function(json){
			$("#reload_m").html("")
			$("#m_id").html('<option value=""> ---- รายชื่อช่างในเขตพื้นที่ ---- </option>')
			$.each(json, function(index, value) {
				$("#m_id").append('<option value="' + value.m_id + '">คุณ' + value.m_name + ' ('+ value.p_name +' -> '+ value.dv_name_short + ')' + '</option>');
			});
		}
	})


})


$("#insert_worksheet").on('submit', function(event) {
	event.preventDefault();
	var insert 	   = "insert_worksheet";
	var m_id 	   = document.getElementById("m_id").value; // id ช่าง
	var ws_name    = document.getElementsByName("ws_name")[0].value; // หัวข้องาน
	var ws_request = document.getElementsByName("ws_request")[0].value;
 	//console.log(m_id);
 	$.ajax({
 		url : '../../xservice_site2/push_noti.php',
 		type: 'GET',
 		data: {'m_id': m_id , 'subject':ws_name,'detail': ws_request},
 		success :function(data){

 		}
 	});

 	$.ajax({
 		url: 'manages.php',
 		type: 'POST',
 		dataType: 'json',
 		data: $(this).serialize() + "&insert_worksheet=" + insert,
 		success : function(data){
 			if(data=="1"){
 				swal({
 					title: "การส่งข้อมูล",
 					text: "ส่งใบงานช่างเรียบร้อยแล้ว!",
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


$(".del_ws").click(function(e) {
	e.preventDefault();
	var del = "del_ws";
	var id = $(this).data('id');
	swal({
		title: "ยืนยันการลบ?",
		text: "คุณจะไม่สามารถกู้ข้อมูลได้!",
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
			data : {"id":id,"del_ws": del},
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
				}else if(data =="11"){
					swal({
						title: "ไม่สารมารถลบข้อมูลได้!",
						text: "เนื่องจากมีการเริ่มงานหรือโอนงานแล้ว!",
						type: "error",
						showCancelButton: false,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "ปิด!",
						closeOnConfirm: false
					})
				}
			}

		});
	});
});


//แก้ไขงานช่าง

$('.edit_work').click(function(event) {
	event.preventDefault();	
	var ws_id 		= $(this).data("ws_id");  
	var ws_name 	= $(this).data("ws_name");	
	var c_id		= $(this).data("c_id");
	var ws_request  = $(this).data("ws_request");
	var z_id		= $(this).data("z_id");
	var s_date 		= $(this).data("ws_start_date");
	var e_date 		= $(this).data("ws_end_date");
	var place_id    = $(this).data("place_id");
	var m_id 	    = $(this).data("m_id");

	$('#ws_id_v_up').val(ws_id);
	$('#ws_name_up').val(ws_name);
	$('#c_id_up').val(c_id);
	$('#ws_request_up').val(ws_request);
	$('#z_id_ss_up').val(z_id);
	$('#ws_start_date').val(s_date);
	$('#ws_end_date').val(e_date);
	// $('#place_id_v_up').val(place_id).trigger('change');;
 //    $('#m_idv_up').val(m_id).trigger('change');

 $.ajax({
 	url: 'combobox_edit.php',
 	type: 'POST',
 	data: {'m_id': m_id,'place_id': place_id,'z_id':z_id },
 	success : function(data){
 		$("#edit_data_m_id").html(data);	
 	}
 })

	// var member = "member";
	// //เลือกสถานที่
	// var place = "place";
	// $.ajax({
	// 	url: 'combobox.php',
	// 	method: 'post',
	// 	data: {'zid': z_id,'place':place},
	// 	dataType: "json",
	// 	beforeSend: function() {
	// 		$("#reload_v_up").html('<img src="../img/loading4.gif" />');
	// 	},
	// 	success: function(json){
	// 		$("#reload_v_up").html("");
	// 		$("#place_id_v_up").html('<option value=""> ----- เลือกสถานที่ ----- </option>');
	// 		$.each(json, function(index, value) {
	// 			$("#place_id_v_up").append('<option value="' + value.place_id + '">' + value.place_name + '</option>');
	// 		});
	// 	}
	// })
	// //เลือกราบชื่อช่าง
	// $.ajax({
	// 	url: 'combobox.php',
	// 	method: 'post',
	// 	data: {'zid': z_id,'member':member},
	// 	dataType: "json",
	// 	beforeSend: function() {
	// 		$("#reload_v_up").html('<img src="../img/loading4.gif"/>');
	// 	},
	// 	success: function(json){
	// 		$("#reload_v_up").html("")
	// 		$("#m_idv_up").html('<option value=""> ---- รายชื่อช่างในเขตพื้นที่ ---- </option>')
	// 		$.each(json, function(index, value) {
	// 			$("#m_idv_up").append('<option value="' + value.m_id + '">คุณ' + value.m_name + ' ('+ value.p_name +' -> '+ value.dv_name_short + ')' + '</option>');
	// 		});
	// 	}
	// })


});

//การค้นหาช่างและค้นหาสถานที่
$("#z_id_ss_up").change(function(){
	var zid = $("#z_id_ss_up").val();
	var member = "member";
	//เลือกสถานที่
	var place = "place";
	$.ajax({
		url: 'combobox.php',
		method: 'post',
		data: {'zid': zid,'place':place},
		dataType: "json",
		beforeSend: function() {
			$("#reload_p_up").html('<img src="../img/loading4.gif" />');
		},
		success: function(json){
			$("#reload_p_up").html("")
			$("#place_id_v_up").html('<option value=""> ----- เลือกสถานที่ ----- </option>')
			$.each(json, function(index, value) {
				$("#place_id_v_up").append('</option><option value="' + value.place_id + '">' + value.place_name + '</option>');
			});
		}
	})
	//เลือกราบชื่อช่าง
	$.ajax({
		url: 'combobox.php',
		method: 'post',
		data: {'zid': zid,'member':member},
		dataType: "json",
		beforeSend: function() {
			$("#reload_m_up").html('<img src="../img/loading4.gif"/>');
		},
		success: function(json){
			$("#reload_m_up").html("")
			$("#m_idv_up").html('<option value=""> ---- รายชื่อช่างในเขตพื้นที่ ---- </option>')
			$.each(json, function(index, value) {
				$("#m_idv_up").append('<option value="' + value.m_id + '">คุณ' + value.m_name + ' ('+ value.p_name +' -> '+ value.dv_name_short + ')' + '</option>');
			});
		}
	})


})







// ส่งงานให้ช่างคนอื่น
$('.deliver_w').click(function(event) {
	event.preventDefault();
	
	var ws_id 		= $(this).data("ws_id");  
	var ws_name 	= $(this).data("ws_name");	
	var c_id		= $(this).data("c_id");
	var ws_request  = $(this).data("ws_request");
	var z_id		= $(this).data("z_id");
	var place_id    = $(this).data("place_id");
	var m_id 		= $(this).data("m_id");
 	console.log(m_id);
	$('#ws_id_v').val(ws_id);
	$('#ws_name').val(ws_name);
	$('#c_id').val(c_id);
	$('#ws_request').val(ws_request);
	$('#z_id_ss').val(z_id);
	//$('#place_id_v').val(place_id);



	$.ajax({
		url: 'combobox_edit.php',
		type: 'POST',
		data: {'m_id': m_id,'place_id': place_id,'z_id':z_id },
		success : function(data){
			$("#uddate_data_worksheet").html(data);	
		}
	})

	// var member = "member";
	// //เลือกสถานที่
	// var place = "place";
	// $.ajax({
	// 	url: 'combobox.php',
	// 	method: 'post',
	// 	data: {'zid': z_id,'place':place},
	// 	dataType: "json",
	// 	beforeSend: function() {
	// 		$("#reload_v").html('<img src="../img/loading4.gif" />');
	// 	},
	// 	success: function(json){
	// 		$("#reload_v").html("");
	// 		$("#place_id_v").html('<option value=""> ----- เลือกสถานที่ ----- </option>');
	// 		$.each(json, function(index, value) {
	// 			$("#place_id_v").append('<option value="' + value.place_id + '">' + value.place_name + '</option>');
	// 		});
	// 	}
	// })
	// //เลือกราบชื่อช่าง
	// $.ajax({
	// 	url: 'combobox.php',
	// 	method: 'post',
	// 	data: {'zid': z_id,'member':member},
	// 	dataType: "json",
	// 	beforeSend: function() {
	// 		$("#reload_v").html('<img src="../img/loading4.gif"/>');
	// 	},
	// 	success: function(json){
	// 		$("#reload_v").html("")
	// 		$("#m_idv").html('<option value=""> ---- รายชื่อช่างในเขตพื้นที่ ---- </option>')
	// 		$.each(json, function(index, value) {
	// 			$("#m_idv").append('<option value="' + value.m_id + '">คุณ' + value.m_name + ' ('+ value.p_name +' -> '+ value.dv_name_short + ')' + '</option>');
	// 		});
	// 	}
	// })


});



//การค้นหาช่างและค้นหาสถานที่
$("#z_id_ss").change(function(){
	var zid = $("#z_id_ss").val();
	var member = "member";
	//เลือกสถานที่
	var place = "place";
	$.ajax({
		url: 'combobox.php',
		method: 'post',
		data: {'zid': zid,'place':place},
		dataType: "json",
		beforeSend: function() {
			$("#reload_p").html('<img src="../img/loading4.gif" />');
		},
		success: function(json){
			$("#reload_p").html("")
			$("#place_id_v").html('<option value=""> ----- เลือกสถานที่ ----- </option>')
			$.each(json, function(index, value) {
				$("#place_id_v").append('</option><option value="' + value.place_id + '">' + value.place_name + '</option>');
			});
		}
	})
	//เลือกราบชื่อช่าง
	$.ajax({
		url: 'combobox.php',
		method: 'post',
		data: {'zid': zid,'member':member},
		dataType: "json",
		beforeSend: function() {
			$("#reload_m").html('<img src="../img/loading4.gif"/>');
		},
		success: function(json){
			$("#reload_m").html("")
			$("#m_idv").html('<option value=""> ---- รายชื่อช่างในเขตพื้นที่ ---- </option>')
			$.each(json, function(index, value) {
				$("#m_idv").append('<option value="' + value.m_id + '">คุณ' + value.m_name + ' ('+ value.p_name +' -> '+ value.dv_name_short + ')' + '</option>');
			});
		}
	})


})



$("#insert_deliver_work").on('submit', function(event) {
	event.preventDefault();
	var insert = "insert_deliver_work";
	$.ajax({
		url: 'manages.php',
		type: 'POST',
		dataType: 'json',
		data: $(this).serialize() + "&insert_deliver_work=" + insert,
		success : function(data){
			if(data=="1"){
				setTimeout(function(){
					$('#deliver_work').modal('hide');
				},200)
				setTimeout(function(){
					swal({
						title: "การส่งข้อมูล",
						text: "ส่งใบงานช่างเรียบร้อยแล้ว!",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "ปิด!",
						closeOnConfirm: false
					},
					function(){
						window.location.reload();
					},500)
					
				});
			}
		}
	})

});


$("#update_work").on('submit', function(event) {
	event.preventDefault();
	var update = "update_work";
	$.ajax({
		url: 'manages.php',
		type: 'POST',
		dataType: 'json',
		data: $(this).serialize()+"&update_work=" + update,
		success : function(data){
			if(data.data=="1"){
				$("#edit_work").modal('hide');
				setTimeout(function(){
					swal({
						title: "การส่งข้อมูล",
						text: "แก้ไขใบงานมอบหมายงานช่าง!",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "ปิด!",
						closeOnConfirm: false
					},
					function(){
						window.location.reload();
					});
				},1000);

				
			}
		}
	})
	
});