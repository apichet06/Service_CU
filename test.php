<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/ekko-lightbox.css" >
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="js/ekko-lightbox.min.js"></script>
</head>
<body>
    <a href="assessment/img/1.jpg" 
    data-toggle="lightbox" 
    data-gallery="multiimages" 
    data-title="Image caption 1">
    <img src="assessment/img/1.jpg" class="img-responsive">
</a>

<a href="assessment/img/1.jpg" 
data-toggle="lightbox" 
data-gallery="multiimages" 
class="img01" 
data-title="Image caption 1">
<img src="assessment/img/1.jpg" class="img-responsive">
</a>

<script type="text/javascript">
    $('.img01').click(function (e) {
        e.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
</body>
</html>