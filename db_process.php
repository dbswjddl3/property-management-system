<?php
include_once "./upload.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/securimage/securimage.php";

$db = new db();

$mode = $_POST['mode'];
$now_datetime = date('Y-m-d H:i:s');

$result = ['result' => false];

if ($mode === 'insert_member') {
    extract($_POST);

    $securimage = new Securimage(array('namespace' => 'contact'));
    $valid = $securimage->check(@$captcha_code);

    if (!$valid) {
        $result['error'] = 'The code entered was incorrect.';
    } else {
        if (!$prefer_name) {
            $prefer_name = $first_name;
        }
    
        $sql = <<<SQL
            INSERT INTO `member`
                (`id`, `password`, `prefer_name`, `first_name`, `last_name`, `phone`, `mobile`, `address`, `tfn`, `tfn_address`, `abn`, `abn_address`, `gst`, `image_face`, `image_id`, `code`, `grade`, `register_datetime`, `employ_status`) 
            VALUES 
                ('$id', PASSWORD('$password'), '$prefer_name', '$first_name', '$last_name', '$phone', '$mobile', '$address', '$tfn', '$tfn_address', '$abn', '$abn_address', '$gst', '$image_face', '$image_id', '$code', '$grade', '$register_datetime', '$employ_status') 
SQL;
    }

    if (!$result['error'] && $sql) {
        $error = $db->query($sql)->error;
        if($error) {
            $result['error'] = $error;
        } else {
            $result['result'] = true;
        }
    }
    
} elseif ($mode === 'check_id') {
    $sql = <<<SQL
        SELECT COUNT(`id`) AS `cnt` 
        FROM `member`
        WHERE `id`={$id}
SQL;
    $row = $db->query($sql)->fetchArray();
    if ($row['cnt'] === 0) {
        $result['result'] = true;
    }
}

echo json_encode($result);
exit;
?>