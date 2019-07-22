
<?php
include_once "../common.php";
include_once "../db.php";

$db = new db();

if ($_POST['mode'] == 'get_reports') {
    $sql = <<<SQL
        SELECT `c`.*, `r`.`subject`
        FROM `report_case` AS `c`
        LEFT JOIN `report` AS `r`
        ON `c`.`id` = `r`.`case_id`
        WHERE 
            `r`.`case_status`!='D'AND
            `c`.`building_id`={$_POST['building']}
        GROUP BY `c`.`id`
SQL;
    $data = $db->query($sql)->fetchAll();
    $return = [];

    foreach ($data as $row) {
        $case_status = $row['case_status'];

        if ($case_status === 'I') {
            $class_name = 'selectable-event';
            $order = 1;
            $color = 'darkorange';
            $start = date("Y-m-d", strtotime($row['start_datetime']));
            $end = date("Y-m-d", strtotime("+1 day"));
        } elseif ($case_status === 'P') {
            $class_name = 'selectable-event';
            $order = 2;
            $color = '#4CAF50';
            $start = date("Y-m-d", strtotime($row['start_datetime']));
            $end = date("Y-m-d", strtotime("+1 day"));
        } elseif ($case_status === 'C') {
            $class_name = '';
            $order = 3;
            $color = 'gray';
            $start = date("Y-m-d", strtotime($row['start_datetime']));
            $end = date("Y-m-d", strtotime("{$row['end_datetime']} +1 day"));
        }

        $return[] = [
            'id' => $row['id'],
            'className' => $class_name,
            'title' => "{$row['case_status']} - {$row['subject']}",
            'order' => $order,
            'color' => $color,
            'start' => $start,
            'end' => $end,
            'textColor' => "#fff",
            'detail' => $row,
        ];
    }
} elseif ($_POST['mode'] == 'get_latest_reply_detail') {
    require_once "../db_function.php";
    $data = get_latest_report_detail($_POST['case_id']);
    $return = get_reply_detail($data);
} elseif ($_POST['mode'] == 'change_event') {
    $id = $_POST['id'];
    $start_datetime = $_POST['start'];
    $end_datetime = $_POST['end'];

    $sql = <<<SQL
    UPDATE `report_case`
    SET 
        `start_datetime`='$start_datetime',
        `end_datetime`='$end_datetime'
    WHERE `id` = $id;
SQL;

    $return['result'] = $db->query($sql);
}

echo json_encode($return);
exit;
?>