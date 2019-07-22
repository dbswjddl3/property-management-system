<?php
include_once "./db_function.php";
include_once "../email.php";

$db = new db();

$mode = $_POST['mode'];
$id = $_POST['id'];
$case_id = $_POST['case_id'];
$case_status = $_POST['case_status'];
$building_id = $_POST['building_id'];
$name = addslashes($_POST["name"]);
$email = addslashes($_POST["email"]);
$homepage = addslashes($_POST["homepage"]);
$subject = addslashes($_POST["subject"]);
$content = addslashes($_POST["content"]);

$now_datetime = date('Y-m-d H:i:s');
$start_datetime = date('Y-m-d H:i:s', strtotime("{$_POST["start_date"]} {$_POST["start_time"]}"));
$end_datetime = "0000-00-00 00:00:00"; 
$case_end_datetime = $end_datetime; 

if ($case_status === 'C') {
    $end_datetime = $now_datetime;
    $case_end_datetime = $now_datetime;
} elseif ($case_status === 'P') {
    $end_datetime = date('Y-m-d H:i:s', strtotime("{$_POST["end_date"]} {$_POST["end_time"]}"));
}

$result = ['result' => false];

if ($mode === 'insert') {
    $ip = getenv("REMOTE_ADDR");
    $parent_id = $_POST["parent_id"];
    $depth = $_POST["depth"];
    $upload = imageUpload($_POST['image']);

    if ($upload['result'] === false) {
        $result['error'] = "File Upload Failed.";
    } else {
        $images = json_encode($upload['images']);

        if ($case_id) { // Reply Report
            $sql = <<<SQL
                UPDATE `report_case`
                SET 
                    `case_status`='$case_status',
                    `end_datetime`='$case_end_datetime'
                WHERE `id` = $case_id;
SQL;
            $db->query($sql);
    
            $sql = <<<SQL
                INSERT INTO `report`
                (`parent_id`, `depth`, `building_id`, `name`, `email`, `homepage`, `case_id`, `subject`, `content`, `images`, `count`, `ip`, `register_datetime`, `start_datetime`, `end_datetime`)        
                VALUES 
                ($parent_id, $depth, '$building_id', '$name', '$email', '$homepage', '$case_id', '$subject', '$content', '$images', 0, '$ip', '$now_datetime', '$start_datetime', '$end_datetime')
SQL;
        } else { // New Report
            $sql = <<<SQL
                INSERT INTO `report_case`
                (`case_status`, `building_id`, `start_datetime`)        
                VALUES 
                ('$case_status', '$building_id', '$start_datetime')
SQL;
            $case_id = $db->query($sql)->insertId();
            
            if ($case_id) {
                $sql = <<<SQL
                    INSERT INTO `report`
                    (`depth`, `building_id`, `name`, `email`, `homepage`, `case_id`, `subject`, `content`, `images`, `count`, `ip`, `register_datetime`, `start_datetime`)        
                    VALUES 
                    (0, '$building_id', '$name', '$email', '$homepage', '$case_id', '$subject', '$content', '$images', 0, '$ip', '$now_datetime', '$start_datetime')
SQL;
            } else {
                $result['error'] = "Case id doesn't exist.";
            }
        }
    }
} elseif ($mode === 'update') {
    $report = get_report_detail($_POST['id']);
    $origin_images = [];
    foreach ($_POST['origin_image'] as $key => $value) {
        $origin_images[] = $report['images'][$key];
    }

    $images = imageUpload($_POST['image'], $origin_images);

    if ($case_id) {
        $sql = <<<SQL
            UPDATE `report_case`
            SET `start_datetime`='$start_datetime',
            WHERE `id` = $case_id;
SQL;
        $db->query($sql);
    }

    $sql = <<<SQL
        UPDATE `report`
        SET `name`='$name', 
            `email`='$email', 
            `homepage`='$homepage', 
            `subject`='$subject', 
            `content`='$content', 
            `images`='$images',
            `start_datetime`='$start_datetime',
            `end_datetime`='$end_datetime'
        WHERE `id` = $id;
SQL;
} elseif ($mode === 'delete') {
    $delete_name = $_POST['delete_name'];

    if (!$_POST['delete_name']) {
        $delete_name = 'Unknown';
    }
    
    $sql = <<<SQL
        UPDATE `report_case` 
        SET `case_status`='D'
        WHERE `id` = $case_id;
SQL;
    
    $db->query($sql);

    $sql = <<<SQL
        UPDATE `report`
        SET `case_status`='D', 
            `delete_name`='$delete_name', 
            `delete_datetime`='$now_datetime'
        WHERE `id` = $id;
SQL;
}

if (!$result['error'] && $sql) {
    if (!$db->query($sql)->error) {
        foreach ($upload['images'] as $img) {
            $file = file_get_contents($img['path']);
            $encoded_file = chunk_split(base64_encode($file));
            $attachments[] = [
                'name' => $img['name'], // Set File Name
                'data' => $encoded_file, // File Data
                'type' => 'image/jpeg', // Type
                'encoding' => 'base64' // Content-Transfer-Encoding
            ];
        }
        
        if (!sendMail($content, $subject, $attachments)) {
            $result['warning'] = 'Failed to Send Email';
        }

        $result['result'] = true;
    }
}

echo json_encode($result);
exit;
?>