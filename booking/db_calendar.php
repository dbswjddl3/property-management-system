
<?php
include_once "../common.php";
include_once "../db.php";

$db = new db();

if ($_POST['mode'] == 'get_bookings') {
    $sql = <<<SQL
        SELECT * 
        FROM `booking` 
        WHERE 
            `status`='Active' AND 
            `building_id`={$_POST['building']}
SQL;
    $data = $db->query($sql)->fetchAll();
    $return = [];
    foreach ($data as $row) {
        $row['start_date'] = date('d-m-Y', strtotime($row['start_datetime']));
        $row['end_date'] = date('d-m-Y', strtotime($row['end_datetime']));
        $row['start_time'] = date('H:00', strtotime($row['start_datetime']));
        $row['end_time'] = date('H:00', strtotime($row['end_datetime']));
        $facility = implode(',', json_decode($row['facility']));
        
        $return[] = [
            'id' => $row['seq'],
            'title' => "{$row['apt_no']}/{$row['name']}/{$facility}",
            'description' => $facility,
            'start' => $row['start_datetime'],
            'end' => $row['end_datetime'],
            'detail' => $row,
            'textColor' => "#fff",
        ];
    }
} elseif ($_POST['mode'] == 'change_event') {
    $id = $_POST['id'];
    $start_datetime = $_POST['start'];
    $end_datetime = $_POST['end'];

    $sql = <<<SQL
    UPDATE `booking`
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