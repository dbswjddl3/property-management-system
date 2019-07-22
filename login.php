<?php
include_once "./db.php";

$id = $_POST['id'];
$password = $_POST['password'];

$db = new db();
$sql = <<<SQL
    SELECT * 
    FROM `member` 
    WHERE 
        `id` ='$id' AND 
        `password` = PASSWORD('$password')
SQL;
$row = $db->query($sql)->fetchArray();

if ($row) {
    session_start();

    $_SESSION = [
        'seq' => $row['seq'],
        'id' => $row['id'],
        'name' => $row['prefer_name']
    ];

    header('Location: main.php');
} else {
    echo "<script>alert('Wrong ID/Password.');history.back();</script>";
}
?>