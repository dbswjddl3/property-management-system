<?php
ini_set("session.cache_expire", 36000);
ini_set("session.gc_maxlifetime", 36000);

session_start();

$_url = explode('/', $_SERVER['SCRIPT_URL']);
$_SERVER['ACCESS_SERVER_NAME'] = $_url[1];
$_SERVER['CURRENT_MENU'] = $_url[count($_url)-2];
$_SERVER['SERVER_DOCUMENT_ROOT'] = "{$_SERVER['DOCUMENT_ROOT']}/{$_SERVER['ACCESS_SERVER_NAME']}";

include_once "{$_SERVER['SERVER_DOCUMENT_ROOT']}/login_check.php";
include_once "{$_SERVER['SERVER_DOCUMENT_ROOT']}/common.php";
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<html class="<?=$_COMMON['device']?>">
<head>
    <title>24PM Admin</title>
    <script src="http://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script src="https://unpkg.com/file-upload-with-preview@4.0.2/dist/file-upload-with-preview.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.js" type="text/javascript"></script>
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/core/main.js"></script>
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/daygrid/main.js"></script>
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/timegrid/main.js"></script>
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/interaction/main.js"></script>
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/js/imageHandler.js?version=<?=$version?>"></script>  
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/js/common.js?version=<?=$version?>"></script>  
    <script src="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/js/slide.js?version=<?=$version?>"></script>  

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" rel="stylesheet" type="text/css" />
    <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <link href="https://unpkg.com/file-upload-with-preview@4.0.2/dist/file-upload-with-preview.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lg-transitions.css" rel="stylesheet" type="text/css" />
    <link href="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/core/main.css" rel="stylesheet" />
    <link href="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/plugins/fullcalendar/timegrid/main.css" rel="stylesheet" />
    <link href="http://24pm.com.au/<?=$_SERVER['ACCESS_SERVER_NAME']?>/css/common.css?version=<?=$version?>" rel="stylesheet" type="text/css" />
    
    <script>
    const setting = {
        datepicker: {
            uiLibrary: 'bootstrap4', 
            format: 'dd-mm-yyyy',
            size: '<?=$_COMMON['datepicker_size']?>'
        },
        summernote: {
            height: 200,
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['insert', ['link']],
            ],
            popover: {
                image: [],
                link: [],
                air: []
            },
            onImageUpload: function (data) {
                data.pop();
            }
        } 
    };
    </script>
</head>

<body>
<?php
include_once "{$_SERVER['SERVER_DOCUMENT_ROOT']}/menu.php";
include_once "{$_SERVER['SERVER_DOCUMENT_ROOT']}/function.php";
?>

<div class="wrapper">
