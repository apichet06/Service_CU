<?php

if ($_SERVER['REQUEST_URI'] == '/service/index.php' or $_SERVER['REQUEST_URI'] == '/service/') { ?>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!-- Font-icon css-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="font/stylesheet.css">
	
<?php }else { ?>

	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/scrollbar.css">
	<link rel="stylesheet" type="text/css" href="../css/ekko-lightbox.css">
	<!-- Font-icon css-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../font/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../css/file-upload-with-preview.min.css">

<?php } ?>
