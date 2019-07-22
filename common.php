<?php
// $version = "1.8.35aaaa";
$version = rand(1, 1000000) . date('YmdHis');

if (is_file( "{$_SERVER['SERVER_DOCUMENT_ROOT']}/{$_SERVER['CURRENT_MENU']}/db_function.php")) {
    require_once "{$_SERVER['SERVER_DOCUMENT_ROOT']}/{$_SERVER['CURRENT_MENU']}/db_function.php";
}

$_COMMON = [
    'device' => 'pc',
    'case_status' => [
        'I' => 'Initial Case',
        'P' => 'Progress Case',
        'C' => 'Close Case',
        'D' => '-'
    ],
    'case_status_class' => [
        'I' => 'w3-red',
        'P' => '',
        'C' => 'w3-dark-gray',
        'D' => 'w3-light-gray'
    ],
    'buildings' => [
        '1' => 'Star',
        '2' => 'Sky',
        '3' => 'Vision',
        '4' => '380L'   
    ],
    'datepicker_size' => 'default',
];

//Check Mobile
$_agent = ["iPhone","iPod","Android","Blackberry", "Opera Mini", "Windows ce", "Nokia", "sony"];
for($i=0; $i<sizeof($_agent); $i++){
    if(stripos($_SERVER['HTTP_USER_AGENT'], $_agent[$i])){
        $_COMMON['device'] = 'mobile';
        $_COMMON['datepicker_size'] = 'large';
        break;
    }
}

$_PAGE = [
    'list_num' => 10,
    'page_num' => 10,
];

if ($_GET['building']) {
    $_SESSION['building'] = $_GET['building'];
}
?>
