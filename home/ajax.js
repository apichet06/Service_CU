$("#data1,#data2,#data3").DataTable({
	lengthChange: false,
	"searching" : false,
	//"lengthMenu": [ 3, 10, 25,50, 75, 100 ],
	"sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
	"drawCallback": function () {
		$('.dataTables_paginate > .pagination').addClass('pagination-sm');

	}
});


$("#data4").DataTable({
	lengthChange: false,
	"searching" : false,
	"lengthMenu": [ 10, 25,50, 75, 100 ],
	"sPaginationType" : 'full_numbers', 'sPaging' : 'pagination',
	"drawCallback": function () {
		$('.dataTables_paginate > .pagination').addClass('pagination-sm');

	}
});

$('.popup').click(function(event) {
	event.preventDefault();
	var message  = $(this).data('message');
	var id 		 = $(this).data('id');
	var ps 		 = $(this).data('ps');
	$(".message").text(message);

	$.ajax({
		url: 'manages.php',
		type: 'POST',
		dataType: 'json',
		data: {'id': id,"ps":ps},
		success : function(data){
			console.log(data.data_ws);
			$("#data_ws_sheet").html(data.data_ws);
		}

	})

});