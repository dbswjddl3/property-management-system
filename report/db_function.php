<?php
require_once "../db.php";

define('TIMEZONE', 'australia/sydney');
date_default_timezone_set(TIMEZONE);
mysql_set_charset('utf8', $link);

function get_report_detail($id) {
    $db = new db();
    $sql = <<<SQL
        SELECT `r`.*, `c`.`case_status` 
        FROM `report` AS `r`
        LEFT JOIN `report_case` AS `c`
        ON `r`.`case_id` = `c`.`id`
        WHERE `r`.`id`={$id}
SQL;
    $data = $db->query($sql)->fetchArray();
    $data = get_reply_format_detail($data);

    return $data;
}

function get_latest_report_detail($case_id) {
    $db = new db();
    $sql = <<<SQL
        SELECT `r`.*, `c`.`case_status` 
        FROM `report` AS `r`
        LEFT JOIN `report_case` AS `c`
        ON `r`.`case_id` = `c`.`id`
        WHERE 
            `case_id`={$case_id} AND 
            `c`.`case_status`!='D' AND
        ORDER BY `id` DESC
        LIMIT 1
SQL;
    $data = $db->query($sql)->fetchArray();
    $data = get_reply_format_detail($data);

    return $data;
}

function get_reply_format_detail($data) {
    $data['register_datetime'] = date('d-m-Y H:i:s', strtotime($data['register_datetime']));
    $data['name'] = stripslashes($data['name']);
    $data['subject'] = htmlspecialchars(stripslashes($data['subject']));
    $data['images'] = json_decode($data['images']);
    $data['date'] = get_report_case_date($data);
    $data['start_date'] = date('d-m-Y', strtotime($data['start_datetime']));
    $data['end_date'] = date('d-m-Y', strtotime($data['end_datetime']));
    $data['start_time'] = date('H:00', strtotime($data['start_datetime']));
    $data['end_time'] = date('H:00', strtotime($data['end_datetime']));

    return $data;
}

function get_reply_detail($parent) {
    global $_COMMON;

    $parent_id = $parent['id'];
    $depth = $parent['depth'] + 1;
    $case_id = $parent['case_id'];
    for ($i=0; $i<$depth; $i++) {
        $subject .= "Re; ";
    }
    $subject .= $parent['subject'];
    $content = "<br><br><br>-----{$_COMMON['case_status'][$parent['case_status']]}-----<br><br>".$parent['content'];
    $start_date = $end_date = date('d-m-Y', strtotime($parent['start_datetime']));
    $start_time = date('H', strtotime($parent['start_datetime']));
    $end_time = $start_time + 2;

    return [
        'parent_id' => $parent_id,
        'depth' => $depth,
        'case_id' => $case_id,
        'subject' => $subject,
        'content' => $content,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'start_time' => $start_time,
        'end_time' => $end_time,
    ];
}

function get_report_case_date($data) {
    $start_datetime = $data['start_datetime'];
    $end_datetime = $data['end_datetime'];

    if (strtotime($start_datetime) > 0) {
        if (strtotime($end_datetime) > 0) {
            $date = date('d-m-Y H:i', strtotime($start_datetime)) . ' ~ ' . date('d-m-Y H:i', strtotime($end_datetime));
        } else {
            $date = date('d-m-Y', strtotime($start_datetime));
        }
    }

    return $date;
}

function check_case_reply($id, $case_id) {
    $db = new db();
    $sql = <<<SQL
        SELECT
            `case_status`, MAX(`id`) AS `id` 
        FROM `report` 
        WHERE 
            `case_id` = '$case_id' AND 
            `case_status` NOT IN ('C', 'D')
SQL;
    $result = $db->query($sql)->fetchArray();
    if ($id == $result['id']) {
        return true;
    } else {
        return false;
    }
}

function count_view($id) {
    $db = new db();
    $sql = "update `report` set count = count + 1 where id='$id'";
    $result = $db->query($sql);
}

function get_report_list($page) {
    global $_PAGE;
    
    $db = new db();
    $offset = $_PAGE['list_num'] * ($page - 1);

    $sql = <<<SQL
        SELECT `r`.*, if (`r`.`case_status`='D', 'D', `c`.`case_status`) AS `case_status` 
        FROM `report` AS `r`
        LEFT JOIN `report_case` AS `c`
        ON `r`.`case_id` = `c`.`id`
        WHERE 
            `r`.`depth` = 0 AND 
            `c`.`building_id`={$_SESSION['building']} 
        ORDER by `case_id` DESC
        LIMIT {$offset}, {$_PAGE['list_num']}
SQL;

    $result = $db->query($sql)->fetchAll();
    foreach ($result as $key => $row) {
        $reply = get_report_reply($row['case_id']);
        if ($reply) {
            $row['reply'] = $reply;
        }
        $result[$key] = $row;
    }

    return $result;
}

function get_report_case_count() {
    $db = new db();
    $sql = <<<SQL
        SELECT COUNT(*) AS `cnt` 
        FROM `report`
        WHERE 
            `parent_id` IS NULL AND 
            `building_id`={$_SESSION['building']} 
SQL;
    $result = $db->query($sql)->fetchArray();
    return $result['cnt'];
}

function get_report_title($row, $page) {
    if (strtotime($row['delete_datetime']) > 0) {
        $title = "Deleted by <i>{$row['delete_name']}</i> at {$row['delete_datetime']}.";
    } else {
        $row['subject'] = strip_tags($row['subject']);
        $title = "<a href='view.php?page={$page}&id={$row['id']}'>{$row['subject']}</a>";
    }

    if ($row['depth'] > 0) {
        $reply_depth = $row['depth'] * 20;
        $title = "<span style='padding-left: {$reply_depth}px;'>ㄴ {$title}</span>";
    }

    return $title;
}

function get_report_reply($case_id) {
    $db = new db();
    $sql = <<<SQL
        SELECT *
        FROM `report`
        WHERE 
            `depth` > 0 AND 
            `case_id` = {$case_id}
        ORDER by `depth` ASC
SQL;
    $result = $db->query($sql)->fetchAll();
    return $result;
}

function get_report_count() {
    $db = new db();
    $sql = <<<SQL
        SELECT COUNT(*) AS `cnt`
        FROM `report`
        WHERE 
            `depth` = 0 AND 
            `building_id`={$_SESSION['building']}
SQL;
    $result = $db->query($sql)->fetchArray();
    return $result['cnt'];
}

function imageUpload($images, $origin_images = []) {
    $result = [
        'result' => true,
        'images' => []
    ];
    
    foreach ($images as $key => $data) {  
        if (!$data) continue;

        $_server_name = explode('/', $_SERVER['SCRIPT_URL'])[1];
        $upload_path = "{$_SERVER['DOCUMENT_ROOT']}/{$_server_name}/report/uploads";

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));

        $file_name = date("YmdHis").rand().$key.'.jpg';
        $real_path = "{$upload_path}/{$file_name}";
        if (file_put_contents($real_path, $data)) {
            $result['images'][] = [
                'path' => "./uploads/{$file_name}",
            ];
        } else {
            $result['result'] = false;
        }
    }
    
    if (count($origin_images) > 0) {
        $result['images'] = array_merge($origin_images, $result['images']);
    }

    return $result;
}
?>