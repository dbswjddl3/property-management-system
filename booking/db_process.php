<?php
include_once "./db_function.php";
include_once "../email.php";

$db = new db();

$mode = $_POST['mode'];
$seq = $_POST["seq"];
$apt_no = addslashes($_POST["apt_no"]);
$name = addslashes($_POST["name"]);
$mobile = addslashes($_POST["mobile"]);
$facility = json_encode($_POST["facility"]);
$start_datetime = date('Y-m-d H:i:s', strtotime("{$_POST["start_date"]} {$_POST["start_time"]}"));
$end_datetime = date('Y-m-d H:i:s', strtotime("{$_POST["end_date"]} {$_POST["end_time"]}"));

$result = ['result' => false];

if ($mode === 'insert') {
    // $sql = "SELECT COUNT(*) AS cnt FROM `booking` WHERE start_datetime <= '$end_datetime' AND end_datetime >= '$start_datetime'";
    // $data = $db->query($sql)->fetchArray();

    // if ($data['cnt'] > 0) {
    //     $result['error'] = 'Time overlapped!';
    // } else {
        $sql = <<<SQL
        INSERT INTO `booking`
        (`apt_no`, `name`, `mobile`, `facility`, `start_datetime`, `end_datetime`)        
        VALUES
        ('$apt_no', '$name', '$mobile', '$facility', '$start_datetime', '$end_datetime')
SQL;
    // }
} elseif ($mode === 'update') {
    $sql = <<<SQL
        UPDATE `booking`
        SET `apt_no`='$apt_no', 
            `name`='$name', 
            `mobile`='$mobile', 
            `facility`='$facility', 
            `start_datetime`='$start_datetime',
            `end_datetime`='$end_datetime'
        WHERE `seq` = $seq;
SQL;
} elseif ($mode === 'delete') {
    $seq = $_POST['seq'];

    $sql = <<<SQL
        UPDATE `booking`
        SET `status`='Inactive'
        WHERE `seq` = $seq;
SQL;
}

if (!$result['error']) {
    if ($db->query($sql)->query_count > 0) {
        $result['result'] = true;
        
        $facility = implode(', ', $_POST['facility']);
        $subject = "[Booking] {$apt_no} / {$name}";
        $content = "{$apt_no} / {$name} / {$mobile} / {$facility} / {$start_datetime} ~ {$end_datetime} ";
        $result['mail'] = sendMail($content, $subject, $attachments);
    }
}

echo json_encode($result);
exit;
?>