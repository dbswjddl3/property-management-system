<?php
require_once "../db.php";

define('TIMEZONE', 'australia/sydney');
date_default_timezone_set(TIMEZONE);
mysql_set_charset('utf8', $link);

function get_booking_count() {
    $db = new db();
    $sql = <<<SQL
        SELECT count(`seq`) AS cnt
        FROM `booking`
        WHERE `building_id`={$_SESSION['building']}
SQL;
    $result = $db->query($sql)->fetchArray();
    return $result['cnt'];
}

function get_booking_list($page) {
    global $_PAGE;
    
    $db = new db();
    $offset = $_PAGE['list_num'] * ($page - 1);
    $sql = <<<SQL
        SELECT * 
        FROM `booking`
        WHERE `building_id`={$_SESSION['building']}
        ORDER by `seq` DESC
        LIMIT {$offset}, {$_PAGE['list_num']}
SQL;

    $result = $db->query($sql)->fetchAll();
    return $result;
}
?>