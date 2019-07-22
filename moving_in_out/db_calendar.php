
<?php
include_once "../common.php";
include_once "../db.php";

$db = new db();

if ($_POST['mode'] == 'get_movings') {
    $sql = <<<SQL
        SELECT * 
        FROM `moving_in_out` 
        WHERE 
            `status`='Active' AND 
            `building_id`={$_POST['building']}
SQL;
    $data = $db->query($sql)->fetchAll();
    $return = [];
    foreach ($data as $row) {
        $return[] = [
            'id' => $row['seq'],
            'title' => "{$row['apt_no']}/{$row['name']}/{$facility}",
            'start' => $row['start_datetime'],
            'end' => $row['end_datetime'],
            'textColor' => "#fff",
            'detail' => $row,
        ];
    }
} elseif ($_POST['mode'] == 'change_event') {
    $id = $_POST['id'];
    $start_datetime = $_POST['start'];
    $end_datetime = $_POST['end'];

    $sql = <<<SQL
    UPDATE `moving_in_out`
    SET 
        `start_datetime`='$start_datetime',
        `end_datetime`='$end_datetime'
    WHERE `seq` = $id;
SQL;

    $return['result'] = $db->query($sql);
}

echo json_encode($return);
exit;
?>